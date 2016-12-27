<?php

namespace AppBundle\Listener;


use AppBundle\Entity\Deploy;
use AppBundle\Event\DeployRequested;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DeployStarter
{

    /**
     * @var Client
     */
    private $api;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(Client $api, EntityManager $em)
    {
        $this->api = $api;
        $this->em = $em;
    }

    private function now()
    {
        return (new \DateTime())->format(\DateTime::ISO8601);
    }

    public function onDeployRequested(DeployRequested $event)
    {
        $config = $event->getConfig();
        $now = $this->now();

        $deploy = new Deploy();
        $config->setLastDeploy($now);
        $deploy->setStarted($now);
        $deploy->setConfig($config);

        try {
            $response = $this->api->get($config->getTriggerUrl(),
                                        ['query' => ['key' => $config->getApikey()]]);

            $status = $response->getStatusCode();
            $deploy->setSuccess($status === 200 ? 1 : 0);
            $deploy->setLog($response->getBody());
        } catch (RequestException $e) {
            $deploy->setSuccess(0);

            $response = $e->getResponse();
            if ($response === null) {
                $deploy->setLog($e->getMessage());
            } else {
                $deploy->setLog($e->getMessage() . "\n\n" . $response->getBody());
            }
        }

        $deploy->setEnded($this->now());
        $this->em->persist($deploy);
        $this->em->persist($config);
        $this->em->flush();
    }

}

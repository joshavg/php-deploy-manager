<?php

namespace AppBundle\Listener;


use AppBundle\Entity\Deploy;
use AppBundle\Event\DeployRequested;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;

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

        $response =
            $this->api->get($config->getTriggerUrl(), ['query' => ['key' => $config->getApikey()]]);

        $status = $response->getStatusCode();
        $deploy->setSuccess($status === 200 ? 1 : 0);

        $deploy->setEnded($this->now());
        $deploy->setLog($response->getBody());

        $this->em->persist($deploy);
        $this->em->flush();
    }

}

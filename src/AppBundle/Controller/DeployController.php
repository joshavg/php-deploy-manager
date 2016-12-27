<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ApplicationConfig;
use AppBundle\Event\DeployRequested;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @Route("/deploy")
 */
class DeployController extends Controller
{
    /**
     * @Route("/list/{configId}", name="deploy_list")
     * @Template()
     *
     * @param $configId
     * @return array
     */
    public function listAction($configId)
    {
        /** @var ApplicationConfig $config */
        $config =
            $this->getDoctrine()->getRepository('AppBundle:ApplicationConfig')->find($configId);
        $qb = $this->getDoctrine()->getRepository('AppBundle:Deploy')->createQueryBuilder('d');
        $deploys = $qb->select('d')
                      ->where('d.config = :config')
                      ->setParameter('config', $config)
                      ->getQuery()
                      ->execute();

        return ['deploys' => $deploys];
    }

    /**
     * @Route("/check/{configId}", name="deploy_check")
     * @Template()
     *
     * @param $configId
     * @return array
     */
    public function checkAction($configId)
    {
        /** @var ApplicationConfig $config */
        $config =
            $this->getDoctrine()->getRepository('AppBundle:ApplicationConfig')->find($configId);

        return ['applicationConfig' => $config];
    }

    /**
     * @Route("/start/{configId}", name="deploy_start")
     * @param $configId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function startAction($configId)
    {
        /** @var ApplicationConfig $config */
        $config =
            $this->getDoctrine()->getRepository('AppBundle:ApplicationConfig')->find($configId);

        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch('deploy.requested', new DeployRequested($config));

        return $this->redirectToRoute('homepage');
    }


}

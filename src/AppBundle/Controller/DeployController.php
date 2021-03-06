<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ApplicationConfig;
use AppBundle\Entity\Deploy;
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

        $deployRepo = $this->getDoctrine()->getRepository('AppBundle:Deploy');
        $qb = $deployRepo->createQueryBuilder('d');
        $deploys = $qb->select('d')
                      ->where('d.config = :config')
                      ->orderBy('d.started', 'DESC')
                      ->setParameter('config', $config)
                      ->getQuery()
                      ->execute();

        return ['applicationConfig' => $config, 'deploys' => $deploys];
    }

    /**
     * @Route("/start/{configId}", name="deploy_start")
     *
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

        return $this->redirectToRoute('deploy_check', ['configId' => $configId]);
    }

    /**
     * @Route("/log/{deployId}", name="deploy_log")
     * @Template()
     *
     * @param $deployId
     * @return array
     */
    public function logAction($deployId)
    {
        $deploy = $this->getDoctrine()->getRepository('AppBundle:Deploy')->find($deployId);

        return ['deploy' => $deploy];
    }

    /**
     * @Route("/clear/{configId}", name="deploy_log_clear")
     *
     * @param $configId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function clearAction($configId)
    {
        $this->getDoctrine()
             ->getRepository('AppBundle:Deploy')
             ->createQueryBuilder('d')
             ->delete()
             ->getQuery()
             ->execute();

        return $this->redirectToRoute('deploy_check', ['configId' => $configId]);
    }
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/deploy")
 */
class DeployController extends Controller
{
    /**
     * @Route("/check/{configId}", name="deploy_check")
     */
    public function checkAction($configId)
    {
        return $this->render('', []);
    }
}

<?php

namespace AppBundle\Event;

use AppBundle\Entity\ApplicationConfig;
use Symfony\Component\EventDispatcher\Event;

class DeployRequested extends Event
{

    /**
     * @var ApplicationConfig
     */
    private $config;

    public function __construct(ApplicationConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return ApplicationConfig
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param ApplicationConfig $config
     * @return DeployRequested
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

}

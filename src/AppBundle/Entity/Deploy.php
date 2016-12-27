<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Deploy
 *
 * @ORM\Table(name="deploy")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DeployRepository")
 */
class Deploy
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="started", type="string", length=50)
     */
    private $started;

    /**
     * @var string
     *
     * @ORM\Column(name="ended", type="string", length=50, nullable=true)
     */
    private $ended;

    /**
     * @var string
     *
     * @ORM\Column(name="log", type="text", nullable=true)
     */
    private $log;

    /**
     * @var int
     *
     * @ORM\Column(name="success", type="integer", nullable=true)
     */
    private $success;

    /**
     * @var ApplicationConfig
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ApplicationConfig")
     */
    private $config;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set started
     *
     * @param string $started
     *
     * @return Deploy
     */
    public function setStarted($started)
    {
        $this->started = $started;

        return $this;
    }

    /**
     * Get started
     *
     * @return string
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * Set ended
     *
     * @param string $ended
     *
     * @return Deploy
     */
    public function setEnded($ended)
    {
        $this->ended = $ended;

        return $this;
    }

    /**
     * Get ended
     *
     * @return string
     */
    public function getEnded()
    {
        return $this->ended;
    }

    /**
     * Set log
     *
     * @param string $log
     *
     * @return Deploy
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Get log
     *
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @return int
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param int $success
     * @return Deploy
     */
    public function setSuccess($success)
    {
        $this->success = $success;
        return $this;
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
     * @return Deploy
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

}


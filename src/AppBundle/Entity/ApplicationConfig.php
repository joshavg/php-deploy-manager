<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApplicationConfig
 *
 * @ORM\Table(name="application_config")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApplicationConfigRepository")
 */
class ApplicationConfig
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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=1000, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="trigger_url", type="string", length=1000, nullable=true)
     */
    private $triggerUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="apikey", type="string", length=500, nullable=true)
     */
    private $apikey;

    /**
     * @var string
     *
     * @ORM\Column(name="last_deploy", type="string", nullable=true)
     */
    private $lastDeploy;


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
     * Set title
     *
     * @param string $title
     *
     * @return ApplicationConfig
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ApplicationConfig
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return ApplicationConfig
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set apikey
     *
     * @param string $apikey
     *
     * @return ApplicationConfig
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;

        return $this;
    }

    /**
     * Get apikey
     *
     * @return string
     */
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * Set lastDeploy
     *
     * @param string $lastDeploy
     *
     * @return ApplicationConfig
     */
    public function setLastDeploy($lastDeploy)
    {
        $this->lastDeploy = $lastDeploy;

        return $this;
    }

    /**
     * Get lastDeploy
     *
     * @return string
     */
    public function getLastDeploy()
    {
        return $this->lastDeploy;
    }

    /**
     * @param string $triggerUrl
     * @return ApplicationConfig
     */
    public function setTriggerUrl($triggerUrl)
    {
        $this->triggerUrl = $triggerUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getTriggerUrl()
    {
        return $this->triggerUrl;
    }
}


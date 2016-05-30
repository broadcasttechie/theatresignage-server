<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlayerReport
 *
 * @ORM\Table(name="player_report")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlayerReportRepository")
 */
class PlayerReport
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
     * @var int
     *
     * @ORM\Column(name="playerID", type="integer")
     */
    private $playerID;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="localIP", type="string", length=255)
     */
    private $localIP;

    /**
     * @var string
     *
     * @ORM\Column(name="remoteIP", type="string", length=255)
     */
    private $remoteIP;

    /**
     * @var string
     *
     * @ORM\Column(name="hamachiIP", type="string", length=255)
     */
    private $hamachiIP;

    /**
     * @var string
     *
     * @ORM\Column(name="currentAsset", type="string", length=255)
     */
    private $currentAsset;

    /**
     * @var string
     *
     * @ORM\Column(name="cpu", type="string", length=255)
     */
    private $cpu;

    /**
     * @var string
     *
     * @ORM\Column(name="memory", type="string", length=255)
     */
    private $memory;

    /**
     * @var string
     *
     * @ORM\Column(name="top", type="string", length=255)
     */
    private $top;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set playerID
     *
     * @param integer $playerID
     * @return PlayerReport
     */
    public function setPlayerID($playerID)
    {
        $this->playerID = $playerID;

        return $this;
    }

    /**
     * Get playerID
     *
     * @return integer 
     */
    public function getPlayerID()
    {
        return $this->playerID;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return PlayerReport
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set localIP
     *
     * @param string $localIP
     * @return PlayerReport
     */
    public function setLocalIP($localIP)
    {
        $this->localIP = $localIP;

        return $this;
    }

    /**
     * Get localIP
     *
     * @return string 
     */
    public function getLocalIP()
    {
        return $this->localIP;
    }

    /**
     * Set remoteIP
     *
     * @param string $remoteIP
     * @return PlayerReport
     */
    public function setRemoteIP($remoteIP)
    {
        $this->remoteIP = $remoteIP;

        return $this;
    }

    /**
     * Get remoteIP
     *
     * @return string 
     */
    public function getRemoteIP()
    {
        return $this->remoteIP;
    }

    /**
     * Set hamachiIP
     *
     * @param string $hamachiIP
     * @return PlayerReport
     */
    public function setHamachiIP($hamachiIP)
    {
        $this->hamachiIP = $hamachiIP;

        return $this;
    }

    /**
     * Get hamachiIP
     *
     * @return string 
     */
    public function getHamachiIP()
    {
        return $this->hamachiIP;
    }

    /**
     * Set currentAsset
     *
     * @param string $currentAsset
     * @return PlayerReport
     */
    public function setCurrentAsset($currentAsset)
    {
        $this->currentAsset = $currentAsset;

        return $this;
    }

    /**
     * Get currentAsset
     *
     * @return string 
     */
    public function getCurrentAsset()
    {
        return $this->currentAsset;
    }

    /**
     * Set cpu
     *
     * @param string $cpu
     * @return PlayerReport
     */
    public function setCpu($cpu)
    {
        $this->cpu = $cpu;

        return $this;
    }

    /**
     * Get cpu
     *
     * @return string 
     */
    public function getCpu()
    {
        return $this->cpu;
    }

    /**
     * Set memory
     *
     * @param string $memory
     * @return PlayerReport
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * Get memory
     *
     * @return string 
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Set top
     *
     * @param string $top
     * @return PlayerReport
     */
    public function setTop($top)
    {
        $this->top = $top;

        return $this;
    }

    /**
     * Get top
     *
     * @return string 
     */
    public function getTop()
    {
        return $this->top;
    }
}

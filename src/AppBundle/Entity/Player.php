<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Player
 *
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlayerRepository")
 */
class Player
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="playerGroup", type="string", length=255)
     */
    private $playerGroup;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastReport", type="datetime")
     */
    private $lastReport;

    /**
     * @var int
     *
     * @ORM\Column(name="channel", type="integer")
     */
    private $channel;


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
     * Set name
     *
     * @param string $name
     * @return Player
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set playerGroup
     *
     * @param string $playerGroup
     * @return Player
     */
    public function setPlayerGroup($playerGroup)
    {
        $this->playerGroup = $playerGroup;

        return $this;
    }

    /**
     * Get playerGroup
     *
     * @return string 
     */
    public function getPlayerGroup()
    {
        return $this->playerGroup;
    }

    /**
     * Set lastReport
     *
     * @param \DateTime $lastReport
     * @return Player
     */
    public function setLastReport($lastReport)
    {
        $this->lastReport = $lastReport;

        return $this;
    }

    /**
     * Get lastReport
     *
     * @return \DateTime 
     */
    public function getLastReport()
    {
        return $this->lastReport;
    }

    /**
     * Set channel
     *
     * @param integer $channel
     * @return Player
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Get channel
     *
     * @return integer 
     */
    public function getChannel()
    {
        return $this->channel;
    }
}

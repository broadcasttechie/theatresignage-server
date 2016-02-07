<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchduleItem
 *
 * @ORM\Table(name="schedule_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ScheduleItemRepository")
 */
class ScheduleItem
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
     * @ORM\Column(name="sequence", type="integer", options={"default" = 0})
     */
    private $sequence = 0;

    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Channel", inversedBy="scheduleItem")
     */
    protected $channel;
        /**
     *
     * @ORM\ManyToOne(targetEntity="Asset", inversedBy="scheduleItem")
     */
    protected $asset;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stop", type="datetime")
     */
    private $stop;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer", nullable=true)
     */
    private $duration;


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
     * Set assetId
     *
     * @param integer $assetId
     * @return SchduleItem
     */
    public function setAssetId($assetId)
    {
        $this->assetId = $assetId;

        return $this;
    }

    /**
     * Get assetId
     *
     * @return integer 
     */
    public function getAssetId()
    {
        return $this->assetId;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     * @return SchduleItem
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set stop
     *
     * @param \DateTime $stop
     * @return SchduleItem
     */
    public function setStop($stop)
    {
        $this->stop = $stop;

        return $this;
    }

    /**
     * Get stop
     *
     * @return \DateTime 
     */
    public function getStop()
    {
        return $this->stop;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     * @return SchduleItem
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set channelId
     *
     * @param \AppBundle\Entity\Channel $channelId
     * @return SchduleItem
     */
    public function setChannelId(\AppBundle\Entity\Channel $channelId = null)
    {
        $this->channelId = $channelId;

        return $this;
    }

    /**
     * Get channelId
     *
     * @return \AppBundle\Entity\Channel 
     */
    public function getChannelId()
    {
        return $this->channelId;
    }

    /**
     * Set channel
     *
     * @param \AppBundle\Entity\Channel $channel
     * @return SchduleItem
     */
    public function setChannel(\AppBundle\Entity\Channel $channel = null)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Get channel
     *
     * @return \AppBundle\Entity\Channel 
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Set asset
     *
     * @param \AppBundle\Entity\Asset $asset
     * @return SchduleItem
     */
    public function setAsset(\AppBundle\Entity\Asset $asset = null)
    {
        $this->asset = $asset;

        return $this;
    }

    /**
     * Get asset
     *
     * @return \AppBundle\Entity\Asset 
     */
    public function getAsset()
    {
        return $this->asset;
    }



    /**
     * Set sequence
     *
     * @param integer $sequence
     * @return ScheduleItem
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * Get sequence
     *
     * @return integer 
     */
    public function getSequence()
    {
        return $this->sequence;
    }
}

<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\Criteria;

use Doctrine\ORM\Mapping as ORM;

/**
 * Channel
 *
 * @ORM\Table(name="channel")
 * @ORM\Entity
 */
class Channel
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


       /**
     * @var string
     *
     * @ORM\Column(name="duration", type="integer", length=11, nullable=true)
     */
    private $duration;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Channel")
     * @ORM\JoinColumn(name="inherits", referencedColumnName="id")
     */
    protected $inherits;
    
     /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Channel", mappedBy="inherits")
     */
    protected $children;

     /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ScheduleItem", mappedBy="channel")
     */
    protected $scheduleItem;
    
     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Group")
     */
    protected $group;
    

    /**
     * Set name
     *
     * @param string $name
     * @return Channel
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set group
     *
     * @param \AppBundle\Entity\Group $group
     * @return Channel
     */
    public function setGroup(\AppBundle\Entity\Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \AppBundle\Entity\Group 
     */
    public function getGroup()
    {
        return $this->group;
    }


    /**
     * Set duration
     *
     * @param integer $duration
     * @return Channel
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
     * Set inherits
     *
     * @param \AppBundle\Entity\Channel $inherits
     * @return Channel
     */
    public function setInherits(\AppBundle\Entity\Channel $inherits = null)
    {
        $this->inherits = $inherits;

        return $this;
    }

    /**
     * Get inherits
     *
     * @return \AppBundle\Entity\Channel 
     */
    public function getInherits()
    {
        return $this->inherits;
    }
    
    /**
    *
    * @return string String representation of this class
    */
    public function __toString()
    {
        return $this->name;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->scheduleItem = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add scheduleItem
     *
     * @param \AppBundle\Entity\ScheduleItem $scheduleItem
     * @return Channel
     */
    public function addScheduleItem(\AppBundle\Entity\ScheduleItem $scheduleItem)
    {
        $this->scheduleItem[] = $scheduleItem;

        return $this;
    }

    /**
     * Remove scheduleItem
     *
     * @param \AppBundle\Entity\ScheduleItem $scheduleItem
     */
    public function removeScheduleItem(\AppBundle\Entity\ScheduleItem $scheduleItem)
    {
        $this->scheduleItem->removeElement($scheduleItem);
    }

    /**
     * Get scheduleItem
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getScheduleItem()
    {
        return $this->scheduleItem;
    }

    /**
     * Add children
     *
     * @param \AppBundle\Entity\Channel $children
     * @return Channel
     */
    public function addChild(\AppBundle\Entity\Channel $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \AppBundle\Entity\Channel $children
     */
    public function removeChild(\AppBundle\Entity\Channel $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }
}

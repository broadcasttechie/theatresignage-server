<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\Criteria;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Asset
 *
 * @ORM\Table(name="asset")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Asset
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;


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
     * @ORM\Column(name="mime_type", type="string", length=50, nullable=false)
     */
    private $mimeType;
    
    
   
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * //mapping is to config
     * @Vich\UploadableField(mapping="asset_file", fileNameProperty="uri", nullable=true)
     * 
     * @Vich\Uploadable
     * @var File
     */
    private $uriFile;
        
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @var string
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $uri;
    
    
    
    /**
     * @Gedmo\Slug(fields={"name","updatedAt"})
     * @ORM\Column(length=128, unique=true,nullable=true)
     */
    private $slug;

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug){
        $this->slug = $slug;
        return $this;
    }
    
    
    
    
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ScheduleItem", mappedBy="asset")
     */
    protected $scheduleItem;
    
    
    
    
    
     /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $uriFile
     *
     * @return AssetImage
     */
    public function setUriFile(File $uriFile = null)
    {
        $this->uriFile = $uriFile;
        if ($uriFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }
    
    
    
    /**
     * @return UploadedFile
     */
    public function getUriFile()
    {
        return $this->uriFile;
    }
    
    
    /**
     * @var \AppBundle\Entity\Group
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_group", referencedColumnName="id")
     * })
     */
    private $ownerGroup;

    
    
    public function __toString() {
        return $this->name;
    }
    

    
    
    

    
    
    
    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Asset
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
     * Set ownerGroup
     *
     * @param \AppBundle\Entity\Group $ownerGroup
     * @return Asset
     */
    public function setOwnerGroup(\AppBundle\Entity\Group $ownerGroup = null)
    {
        $this->ownerGroup = $ownerGroup;

        return $this;
    }

    /**
     * Get ownerGroup
     *
     * @return \AppBundle\Entity\Group 
     */
    public function getOwnerGroup()
    {
        return $this->ownerGroup;
    }

    


    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return Asset
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }


    /**
     * Set uri
     *
     * @param string $uri
     * @return Asset
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        #$this->name = pathinfo($uri, PATHINFO_FILENAME);
        $this->name =  pathinfo(substr($uri, strpos($uri, '_')+1), PATHINFO_FILENAME);
        return $this;
    }

    /**
     * Get uri
     *
     * @return string 
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Asset
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
     * Set scheduleItem
     *
     * @param \AppBundle\Entity\ScheduleItem $scheduleItem
     * @return Asset
     */
    public function setScheduleItem(\AppBundle\Entity\ScheduleItem $scheduleItem = null)
    {
        $this->scheduleItem = $scheduleItem;

        return $this;
    }

    /**
     * Get scheduleItem
     *
     * @return \AppBundle\Entity\ScheduleItem 
     */
    public function getScheduleItem()
    {
        return $this->scheduleItem;
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
     * @return Asset
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
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * AssetImage
 *
 * @ORM\Table(name="asset_image", indexes={@ORM\Index(name="fk_asset_image_asset1_idx", columns={"asset_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class AssetImage
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
     * @var \AppBundle\Entity\Asset
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Asset")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asset_id", referencedColumnName="id")
     * })
     */
    private $asset;

    
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="asset_image", fileNameProperty="imageName", nullable=true)
     * 
     * @Vich\Uploadable
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    
     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     *
     * @return AssetImage
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }


    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return AssetImage
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
     * Set asset
     *
     * @param \AppBundle\Entity\Asset $asset
     * @return AssetImage
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
     * Set imageName
     *
     * @param string $imageName
     * @return AssetImage
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }
    

    /**
     * @return UploadedFile
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }
}

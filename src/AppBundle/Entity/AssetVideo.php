<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssetVideo
 *
 * @ORM\Table(name="asset_video", indexes={@ORM\Index(name="fk_asset_video_asset1_idx", columns={"asset_id"})})
 * @ORM\Entity
 */
class AssetVideo
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Asset")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asset_id", referencedColumnName="id")
     * })
     */
    private $asset;



    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return AssetVideo
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
     * @return AssetVideo
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
}

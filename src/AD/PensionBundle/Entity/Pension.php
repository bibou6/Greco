<?php

namespace AD\PensionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Pension
 *
 * @ORM\Table(name="gi_pension")
 * @ORM\Entity(repositoryClass="AD\PensionBundle\Repository\PensionRepository")
 * @Vich\Uploadable
 */
class Pension
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
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedAt;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var int
     *
     * @ORM\Column(name="minimumPrice", type="integer")
     */
    private $minimumPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="maximumPrice", type="integer")
     */
    private $maximumPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionSpanish", type="text", nullable=true)
     */
    private $descriptionSpanish;
    
    /**
     * @var string
     *
     * @ORM\Column(name="descriptionEnglish", type="text", nullable=true)
     */
    private $descriptionEnglish;
    
    /**
     * @var string
     *
     * @ORM\Column(name="descriptionFrench", type="text", nullable=true)
     */
    private $descriptionFrench;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="roomAmount", type="integer", nullable=true)
     */
    private $roomAmount;

    /**
     * @var bool
     *
     * @ORM\Column(name="full", type="boolean", nullable=true)
     */
    private $full;

    
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image="avatar.png";
    
    /**
     * @Vich\UploadableField(mapping="pension_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;
    
    /**
     * @var PensionImage[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AD\PensionBundle\Entity\PensionImage", mappedBy="pension", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $images;

    public function __construct()
    {
    	$this->images = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->enabled = true;
    }
    
    
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Pension
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
     * Set minimumPrice
     *
     * @param integer $minimumPrice
     *
     * @return Pension
     */
    public function setMinimumPrice($minimumPrice)
    {
        $this->minimumPrice = $minimumPrice;

        return $this;
    }

    /**
     * Get minimumPrice
     *
     * @return int
     */
    public function getMinimumPrice()
    {
        return $this->minimumPrice;
    }

    /**
     * Set maximumPrice
     *
     * @param integer $maximumPrice
     *
     * @return Pension
     */
    public function setMaximumPrice($maximumPrice)
    {
        $this->maximumPrice = $maximumPrice;

        return $this;
    }

    /**
     * Get maximumPrice
     *
     * @return int
     */
    public function getMaximumPrice()
    {
        return $this->maximumPrice;
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Pension
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
     * Set roomAmount
     *
     * @param integer $roomAmount
     *
     * @return Pension
     */
    public function setRoomAmount($roomAmount)
    {
        $this->roomAmount = $roomAmount;

        return $this;
    }

    /**
     * Get roomAmount
     *
     * @return int
     */
    public function getRoomAmount()
    {
        return $this->roomAmount;
    }

    public function setImageFile(File $image = null)
    {
    	$this->imageFile = $image;
    
    	// VERY IMPORTANT:
    	// It is required that at least one field changes if you are using Doctrine,
    	// otherwise the event listeners won't be called and the file is lost
    	if ($image) {
    		// if 'updatedAt' is not defined in your entity, use another property
    		$this->updatedAt = new \DateTime('now');
    	}
    }
    
    public function getImageFile()
    {
    	return $this->imageFile;
    }
    
    public function setImage($image)
    {
    	$this->image = $image;
    }
    
    public function getImage()
    {
    	return $this->image;
    }
    
    /**
     * Get images
     *
     * @return PensionImages[]|ArrayCollection
     */
    public function getImages()
    {
    	return $this->images;
    }
    
    /**
     * Add image
     *
     * @param PensionImage $image
     *
     * @return Room
     */
    public function addImage(PensionImage $image)
    {
    	$image->setPension($this);
    	$this->images[] = $image;
    
    	dump($image);
    
    	return $this;
    }
    
    /**
     * Remove image
     *
     * @param PensionImage $image
     */
    public function removeImage(PensionImage $image)
    {
    	$image->setPension(null);
    	$this->images->removeElement($image);
    }
    
    public function __toString()
    {
    	return (string) $this->name;
    }


    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Pension
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set full
     *
     * @param boolean $full
     *
     * @return Pension
     */
    public function setFull($full)
    {
        $this->full = $full;

        return $this;
    }

    /**
     * Get full
     *
     * @return boolean
     */
    public function getFull()
    {
        return $this->full;
    }

    /**
     * Set descriptionSpanish
     *
     * @param string $descriptionSpanish
     *
     * @return Pension
     */
    public function setDescriptionSpanish($descriptionSpanish)
    {
        $this->descriptionSpanish = $descriptionSpanish;

        return $this;
    }

    /**
     * Get descriptionSpanish
     *
     * @return string
     */
    public function getDescriptionSpanish()
    {
        return $this->descriptionSpanish;
    }

    /**
     * Set descriptionEnglish
     *
     * @param string $descriptionEnglish
     *
     * @return Pension
     */
    public function setDescriptionEnglish($descriptionEnglish)
    {
        $this->descriptionEnglish = $descriptionEnglish;

        return $this;
    }

    /**
     * Get descriptionEnglish
     *
     * @return string
     */
    public function getDescriptionEnglish()
    {
        return $this->descriptionEnglish;
    }

    /**
     * Set descriptionFrench
     *
     * @param string $descriptionFrench
     *
     * @return Pension
     */
    public function setDescriptionFrench($descriptionFrench)
    {
        $this->descriptionFrench = $descriptionFrench;

        return $this;
    }

    /**
     * Get descriptionFrench
     *
     * @return string
     */
    public function getDescriptionFrench()
    {
        return $this->descriptionFrench;
    }
}

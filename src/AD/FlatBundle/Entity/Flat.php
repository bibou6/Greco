<?php

namespace AD\FlatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Flat
 *
 * @ORM\Table(name="gi_flat")
 * @ORM\Entity(repositoryClass="AD\FlatBundle\Repository\FlatRepository")
 * @Vich\Uploadable
 */
class Flat
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
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;
    
    /**
     * @var int
     *
     * @ORM\Column(name="daily_price", type="integer", nullable=true)
     */
    private $dailyPrice;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isEnabled", type="boolean")
     */
    private $enabled;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isRented", type="boolean")
     */
    private $rented;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="summer", type="boolean")
     */
    private $summer;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isForSale", type="boolean")
     */
    private $forSale;

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
     * @ORM\Column(name="isFull", type="boolean", nullable=true)
     */
    private $isFull;

    
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image="avatar.png";
    
    /**
     * @Vich\UploadableField(mapping="flat_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;
    
    /**
     * @var FlatImage[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AD\FlatBundle\Entity\FlatImage", mappedBy="flat", cascade={"persist","remove"}, orphanRemoval=true)
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
     * @return Flat
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
     * Set maximumPrice
     *
     * @param integer $price
     *
     * @return Flat
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Set dailyPrice
     *
     * @param integer $dailyPrice
     *
     * @return Flat
     */
    public function setDailyPrice($dailyPrice)
    {
    	$this->dailyPrice = $dailyPrice;
    
    	return $this;
    }
    
    /**
     * Get dailyPrice
     *
     * @return int
     */
    public function getDailyPrice()
    {
    	return $this->dailyPrice;
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Flat
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
     * @return Flat
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

    /**
     * Set isFull
     *
     * @param boolean $isFull
     *
     * @return Flat
     */
    public function setIsFull($isFull)
    {
        $this->isFull = $isFull;

        return $this;
    }

    /**
     * Get isFull
     *
     * @return bool
     */
    public function getIsFull()
    {
        return $this->isFull;
    }
    
    /**
     * Set rented
     *
     * @param boolean $rented
     *
     * @return Flat
     */
    public function setRented($rented)
    {
    	$this->rented = $rented;
    	
    	return $this;
    }
    
    /**
     * Get rented
     *
     * @return bool
     */
    public function getRented()
    {
    	return $this->rented;
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
     * @return FlatImages[]|ArrayCollection
     */
    public function getImages()
    {
    	return $this->images;
    }
    
    /**
     * Add image
     *
     * @param FlatImage $image
     *
     * @return Room
     */
    public function addImage(FlatImage $image)
    {
    	$image->setFlat($this);
    	$this->images[] = $image;
    
    	dump($image);
    
    	return $this;
    }
    
    /**
     * Remove image
     *
     * @param FlatImage $image
     */
    public function removeImage(FlatImage $image)
    {
    	$image->setFlat(null);
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
     * @return Flat
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
     * Set summer
     *
     * @param boolean $summer
     *
     * @return Flat
     */
    public function setSummer($summer)
    {
    	$this->summer = $summer;
    
    	return $this;
    }
    
    /**
     * Get summer
     *
     * @return boolean
     */
    public function getSummer()
    {
    	return $this->summer;
    }

    /**
     * Set descriptionSpanish
     *
     * @param string $descriptionSpanish
     *
     * @return Flat
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
     * @return Flat
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
     * @return Flat
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

    /**
     * Set forSale
     *
     * @param boolean $forSale
     *
     * @return Flat
     */
    public function setForSale($forSale)
    {
        $this->forSale = $forSale;

        return $this;
    }

    /**
     * Get forSale
     *
     * @return boolean
     */
    public function getForSale()
    {
        return $this->forSale;
    }
}

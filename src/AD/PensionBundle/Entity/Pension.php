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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     * @Vich\UploadableField(mapping="pension_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;
    
    /**
     * @var PensionImage[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AD\PensionBundle\Entity\PensionImage", mappedBy="pension", cascade={"persist"})
     */
    private $images;

    public function __construct(){
    	$this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set description
     *
     * @param string $description
     *
     * @return Pension
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

    /**
     * Set isFull
     *
     * @param boolean $isFull
     *
     * @return Pension
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
}


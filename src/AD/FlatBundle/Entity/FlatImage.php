<?php

namespace AD\FlatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * FlatImage
 *
 * @ORM\Table(name="gi_flat_image")
 * @ORM\Entity(repositoryClass="AD\FlatBundle\Repository\FlatImageRepository")
 * @Vich\Uploadable
 */
class FlatImage
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
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;
    
    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     * @var integer
     */
    private $position;
    
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
     * @var Flat
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="AD\FlatBundle\Entity\Flat", inversedBy="images")
     */
    private $flat;

    
    public function __construct(){
    	$this->creationDate = new \DateTime('now');
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
     * Set alt
     *
     * @param string $alt
     *
     * @return FlatImage
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return FlatImage
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
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
     * Set flat
     *
     * @param Flat $flat
     *
     * @return FlatImage
     */
    public function setFlat(Flat $flat = null)
    {
    	$this->flat = $flat;
    
    	return $this;
    }
    
    /**
     * Get Flat
     *
     * @return Flat
     */
    public function getFlat()
    {
    	return $this->flat;
    }
    
    /*public function __toString()
    {
    	return (string) $this->image;
    }*/

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return FlatImage
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
}

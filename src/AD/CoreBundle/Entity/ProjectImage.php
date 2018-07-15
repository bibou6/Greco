<?php

namespace AD\PensionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use AD\CoreBundle\Entity\Project;

/**
 * ProjectImage
 *
 * @ORM\Table(name="gi_project_image")
 * @ORM\Entity(repositoryClass="AD\CoreBundle\Repository\ProjectImageRepository")
 * @Vich\Uploadable
 */
class ProjectImage
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
     * @var Project
     * @ORM\ManyToOne(targetEntity="AD\PensionBundle\Entity\Project", inversedBy="images")
     */
    private $project;

    
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
     * @return ProjectImage
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
     * @return ProjectImage
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
     * Set pension
     *
     * @param Pension $pension
     *
     * @return ProjectImage
     */
    public function setProject(Project $project = null)
    {
    	$this->project = $project;
    
    	return $this;
    }
    
    /**
     * Get Pension
     *
     * @return Pension
     */
    public function getPension()
    {
    	return $this->pension;
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
     * @return ProjectImage
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

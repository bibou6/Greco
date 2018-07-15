<?php

namespace AD\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="AD\CoreBundle\Repository\ProjectRepository")
 */
class Project
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
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
     * @Vich\UploadableField(mapping="pension_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;
    
    /**
     * @Vich\UploadableField(mapping="pension_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;
    
    
}


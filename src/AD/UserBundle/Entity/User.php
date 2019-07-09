<?php

namespace AD\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="gi_user")
 * @ORM\Entity(repositoryClass="AD\UserBundle\Repository\UserRepository")
 * @Vich\Uploadable
 */
class User extends BaseUser
{
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $image="avatar.png";
	
	/**
	 * @Vich\UploadableField(mapping="user_images", fileNameProperty="image")
	 * @var File
	 */
	private $imageFile;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 * @var \DateTime
	 */
	private $updatedAt;
	
	// ...
	
	public function __construct(){
		parent::__construct();
		$this->updatedAt = new \Datetime("now");
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
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
}

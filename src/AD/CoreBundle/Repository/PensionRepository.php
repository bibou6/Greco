<?php

namespace AD\CoreBundle\Repository;

/**
 * PensionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PensionRepository extends \Doctrine\ORM\EntityRepository
{
	public function findAll()
	{
		return $this->findBy(array(), array('images.position' => 'ASC'));
	}
	
}
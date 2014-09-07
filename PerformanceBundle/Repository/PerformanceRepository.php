<?php

namespace HegesApp\PerformanceBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * NodeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PerformanceRepository extends EntityRepository
{
	
	
	public function getgraphsfornode($nodeid)
	{
		return $this->getEntityManager()
		->createQuery('select a from HegesAppPerformanceBundle:Graph a,
				HegesAppNodeBundle:Node b
				where b.id= :id 
				and b.id = a.fknodeid
				')
		->setParameter('id', $nodeid)
		->getResult();
	
	}

	
	public function getgraphsforos($osid)
	{
		return $this->getEntityManager()
		->createQuery('select a from HegesAppPerformanceBundle:Graph a,
				HegesAppNodeBundle:Os b
				where b.id= :id
				and b.id = a.fkosid
				')
				->setParameter('id', $osid)
				->getResult();
	
	}
	
}



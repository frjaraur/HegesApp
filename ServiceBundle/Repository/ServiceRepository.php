<?php

namespace HegesApp\ServiceBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ServiceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ServiceRepository extends EntityRepository
{
	
	
	public function getconfiglinetypefromserviceid($id)
	{
            		 //print "[".$id."]\n";
           
//                    print "<H2>select * from MONITOR a, 
//                    CONFIGLINETYPE b, 
//                    SERVICE c 
//                    where c.id='".$id."'
//                    and c.fk_Monitor_id = a.id 
//                    and b.fk_Monitor = a.id</H2>";
		$result= $this->getEntityManager()
		->createQuery('select b from HegesAppMonitorBundle:Monitor a, 
                    HegesAppConfigFileBundle:Configlinetype b, 
                    HegesAppServiceBundle:Service c 
                    where c.id= :id 
                    and c.fkMonitor = a.id 
                    and b.fkMonitor = a.id  ')
		->setParameter('id', $id)
		->getOneOrNullResult();
                
                
                		//->getSingleResult();

		if (!$result) {
			//throw $this->createNotFoundException('getconfiglinetypefromserviceid: No existe un unico tipo para este servicio');
                    return false;
		}else{return $result;}
		
            print "ERROR2?¿?";
	}
	
	public function getdatafromserviceid($id)
	{
		return $this->getEntityManager()
		->createQuery('select a from HegesAppConfigFileBundle:Data a,
				HegesAppConfigFileBundle:Configline b
				where b.fkService= :id 
				and b.id = a.fkConfigline
				and b.linestatus is not null
				')
		->setParameter('id', $id)
		->getResult();
	
	}
	
	
	public function getfieldfromlinetypeidandfieldorder($linetypeid,$fieldorder)
	{
		return $this->getEntityManager()
		->createQuery('select a from HegesAppConfigFileBundle:Configfield a
				where a.fkConfiglinetype= :linetypeid
				and a.fieldorder = :fieldorder
				')
				->setParameter('linetypeid', $linetypeid)
				->setParameter('fieldorder', $fieldorder)
				->getSingleResult();
	
	}
	
	public function getduplicatelinewithfieldid($lineid,$fieldid)
	{
		return $this->getEntityManager()
		->createQuery('select a from HegesAppConfigFileBundle:Data a
				where a.fkConfigline= :lineid
				and a.fkConfigfield = :fieldid
				')
				->setParameter('lineid', $lineid)
				->setParameter('fieldid', $fieldid)
				->getResult();
				
	
					
	}


	public function getAllServicesByNodeName()
	{
		return $this->getEntityManager()
		->createQuery('select a from HegesAppServiceBundle:Service a, HegesAppNodeBundle:Node b where a.fkNode=b.id order by b.name ASC')
		->getResult();
	
	}
	
	
}




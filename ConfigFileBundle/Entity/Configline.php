<?php

namespace HegesApp\ConfigFileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HegesApp\ConfigFileBundle\Entity\Configline
 *
 * @ORM\Table(name="CONFIGLINE")
 * @ORM\Entity
 */
class Configline
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * @var fkService
     *
     * @ORM\ManyToOne(targetEntity="\HegesApp\ServiceBundle\Entity\Service")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_SERVICE_ID", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkService;

    /**
     * Inversa a Data
     *
     * @ORM\OneToMany(targetEntity="Data",mappedBy="fkConfigline")
     */

    public $fkConfigline;

    
    /**
     * @var integer linestatus
     *
     * @ORM\Column(name="linestatus", type="integer", nullable=true)
     */
    private $linestatus;
    
    
    
    
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set fkService
     *
     * @param HegesApp\ServiceBundle\Entity\Service $fkService
     */
    public function setFkService(\HegesApp\ServiceBundle\Entity\Service $fkService)
    {
        $this->fkService = $fkService;
    }

    /**
     * Get fkService
     *
     * @return HegesApp\ServiceBundle\Entity\Service 
     */
    public function getFkService()
    {
        return $this->fkService;
    }


    
    
    public function __construct()
    {
        $this->Data = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add Data
     *
     * @param HegesApp\ConfigFileBundle\Entity\Data $data
     */
    public function addData(\HegesApp\ConfigFileBundle\Entity\Data $data)
    {
        $this->Data[] = $data;
    }

    /**
     * Get Data
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getData()
    {
        return $this->Data;
    }

    /**
     * Get linestatus
     *
     * @return integer
     */
    public function getLinestatus()
    {
    	return $this->linestatus;
    }
    
    public function setLinestatus($linestatus)
    {
    	$this->linestatus=$linestatus;
    }

    public function __toString()
    {
    	return $this->fkService->getName();
        //$this->getId()
        
    }
    
}
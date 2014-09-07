<?php

namespace HegesApp\ConfigFileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HegesApp\ConfigFileBundle\Entity\Configlinetype
 *
 * @ORM\Table(name="CONFIGLINETYPE")
 * @ORM\Entity
 */
class Configlinetype
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
     * @var integer $name
     *
     * @ORM\Column(name="NAME", type="string", nullable=false)
     */
    private $name;

    /**
     * @var integer $fieldsnumber
     *
     * @ORM\Column(name="FIELDSNUMBER", type="integer", nullable=false)
     */
    private $fieldsnumber;    

    /**
     * @var string $delimiter
     *
     * @ORM\Column(name="DELIMITER", type="string", length=5, nullable=false)
     */
    private $delimiter;
    
    /**
     * @var fkMonitor
     *
     * @ORM\ManyToOne(targetEntity="\HegesApp\MonitorBundle\Entity\Monitor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_MONITOR", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkMonitor;
    
    
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
     * Set fieldsnumber
     *
     * @param integer $fieldsnumber
     */
    public function setFieldsnumber($fieldsnumber)
    {
        $this->fieldsnumber = $fieldsnumber;
    }

    /**
     * Get fieldsnumber
     *
     * @return integer 
     */
    public function getFieldsnumber()
    {
        return $this->fieldsnumber;
    }
    /**
     * Set delimiter
     *
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
    	$this->delimiter = $delimiter;
    }
    
    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter()
    {
    	return $this->delimiter;
    }
    /**
     * Set name
     *
     * @param string $delimiter
     */
    public function setName($name)
    {
    	$this->name = $name;
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
     * Set fkMonitor
     *
     * @param HegesApp\ConfigFileBundle\Entity\Configlinetype $fkMonitor
     */
    public function setFkMonitor(\HegesApp\MonitorBundle\Entity\Monitor $fkMonitor)
    {
    	$this->fkMonitor = $fkMonitor;
    }
    
    /**
     * Get fkConfiglinetype3
     *
     * @return HegesApp\ConfigFileBundle\Entity\Configlinetype
     */
    public function getFkMonitor()
    {
    	return $this->fkMonitor;
    }
    
    public function __toString()
    {
    	return $this->getName();
    }
}
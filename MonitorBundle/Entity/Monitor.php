<?php

namespace HegesApp\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HegesApp\MonitorBundle\Entity\Monitor
 *
 * @ORM\Table(name="MONITOR")
 * @ORM\Entity
 */
class Monitor
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
     * @var string $name
     *
     * @ORM\Column(name="NAME", type="string", length=45, nullable=false, unique=true)
     */
    private $name;    
           
    /**
     * @var string $execname
     *
     * @ORM\Column(name="EXECNAME", type="string", length=45, nullable=false)
     */
    private $execname;

    /**
     * @var text $params
     *
     * @ORM\Column(name="PARAMS", type="text", nullable=true)
     */
    private $params;

    /**
     * @var text $description
     *
     * @ORM\Column(name="DESCRIPTION", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string $lastversion
     *
     * @ORM\Column(name="LASTVERSION", type="string", length=45, nullable=true)
     */
    private $lastversion;


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
     * Set name
     *
     * @param string $name
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
     * Set execname
     *
     * @param string $execname
     */
    public function setExecname($execname)
    {
        $this->execname = $execname;
    }

    /**
     * Get execname
     *
     * @return string 
     */
    public function getExecname()
    {
        return $this->execname;
    }

    /**
     * Set params
     *
     * @param text $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * Get params
     *
     * @return text 
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set lastversion
     *
     * @param string $lastversion
     */
    public function setLastversion($lastversion)
    {
        $this->lastversion = $lastversion;
    }

    /**
     * Get lastversion
     *
     * @return string 
     */
    public function getLastversion()
    {
        return $this->lastversion;
    }
    

    
    public function __toString()
    {
    	return $this->getName();
    }
}
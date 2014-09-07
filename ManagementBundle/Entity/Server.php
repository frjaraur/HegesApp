<?php

namespace HegesApp\ManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HegesApp\ManagementBundle\Entity\Server
 *
 * @ORM\Table(name="SERVER")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="HegesApp\ManagementBundle\Repository\ServerRepository")
 */
class Server
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
     * @var text $description
     *
     * @ORM\Column(name="DESCRIPTION", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string $ip
     *
     * @ORM\Column(name="IP", type="string", length=16, nullable=true)
     */
    private $ip;

    /**
     * @var Nodetype
     *
     * @ORM\ManyToOne(targetEntity="\HegesApp\NodeBundle\Entity\Nodetype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_NODETYPE_ID", referencedColumnName="id")
     * })
     */
    private $fkNodetype;

    /**
     * @var Os
     *
     * @ORM\ManyToOne(targetEntity="\HegesApp\NodeBundle\Entity\Os")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_OS_ID", referencedColumnName="id")
     * })
     */
    private $fkOs;

    /**
     * @var ovostatus
     *  @ORM\Column(name="OVOSTATUS",type="string", length=255, nullable=true)
     * })
     */
    private $ovostatus;

    
    /**
     * @var serverurl
     *  @ORM\Column(name="SERVERURL",type="string", length=255, nullable=true)
     * })
     */
    private $serverurl;
    
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
     * Set ip
     *
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set fkNodetype
     *
     * @param HegesApp\NodeBundle\Entity\Nodetype $fkNodetype
     */
    public function setFkNodetype(\HegesApp\NodeBundle\Entity\Nodetype $fkNodetype)
    {
        $this->fkNodetype = $fkNodetype;
    }

    /**
     * Get fkNodetype
     *
     * @return HegesApp\NodeBundle\Entity\Nodetype 
     */
    public function getFkNodetype()
    {
        return $this->fkNodetype;
    }

    /**
     * Set fkOs
     *
     * @param HegesApp\NodeBundle\Entity\Os $fkOs
     */
    public function setFkOs(\HegesApp\NodeBundle\Entity\Os $fkOs)
    {
        $this->fkOs = $fkOs;
    }

    /**
     * Get fkOs
     *
     * @return HegesApp\NodeBundle\Entity\Os 
     */
    public function getFkOs()
    {
        return $this->fkOs;
    }
    
    /**
     * Set ovostatus
     *
     * @param string $ovostatus
     */
    public function setOvostatus($ovostatus)
    {
    	$this->ovostatus = $ovostatus;
    }
    
    /**
     * Get ovostatus
     *
     * @return string
     */
    public function getOvostatus()
    {
    	return $this->ovostatus;
    }
    
    
    /**
     * Set serverurl
     *
     * @param string $ovostatus
     */
    public function setServerurl($serverurl)
    {
    	$this->serverurl = $serverurl;
    }
    
    /**
     * Get serverurl
     *
     * @return string
     */
    public function getServerurl()
    {
    	return $this->serverurl;
    }
    
    
    
    public function __toString()
    {
    	return $this->getName();
    }
}
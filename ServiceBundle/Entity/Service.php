<?php

namespace HegesApp\ServiceBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * HegesApp\ServiceBundle\Entity\Service
 *
 * @ORM\Table(name="SERVICE",uniqueConstraints={@ORM\UniqueConstraint(name="Constraint_Service_Node",columns={"NAME","FK_NODE_ID"})})
 * @ORM\Entity
*  @ORM\Entity(repositoryClass="HegesApp\ServiceBundle\Repository\ServiceRepository")
 * 
 */

//@UniqueEntity ({"nombre","fkNode"})
class Service
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
     * @ORM\Column(name="NAME", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var text $description
     *
     * @ORM\Column(name="DESCRIPTION", type="text", nullable=true)
     */
    private $description;

    /**
     * @var text $servicetest
     *
     * @ORM\Column(name="SERVICETEST", type="text", nullable=true)
     */
    private $servicetest;

    /**
     * @var Node
     *
     * @ORM\ManyToOne(targetEntity="\HegesApp\NodeBundle\Entity\Node")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_NODE_ID", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkNode;

    /**
     * @var Monitor
     *
     * @ORM\ManyToOne(targetEntity="\HegesApp\MonitorBundle\Entity\Monitor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_MONITOR_ID", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkMonitor;

    /**
     * @var string $configfilename
     *
     * @ORM\Column(name="CONFIGFILENAME", type="string", length=45, nullable=true)
     */
    private $configfilename;



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
     * Set servicetest
     *
     * @param text $servicetest
     */
    public function setServicetest($servicetest)
    {
        $this->servicetest = $servicetest;
    }

    /**
     * Get servicetest
     *
     * @return text 
     */
    public function getServicetest()
    {
        return $this->servicetest;
    }

    /**
     * Set configfilename
     *
     * @param string $configfilename
     */
    public function setConfigfilename($configfilename)
    {
        $this->configfilename = $configfilename;
    }

    /**
     * Get configfilename
     *
     * @return string 
     */
    public function getConfigfilename()
    {
        return $this->configfilename;
    }

    /**
     * Set fkNode
     *
     * @param HegesApp\NodeBundle\Entity\Node $fkNode
     */
    public function setFkNode(\HegesApp\NodeBundle\Entity\Node $fkNode)
    {
        $this->fkNode = $fkNode;
    }

    /**
     * Get fkNode
     *
     * @return HegesApp\NodeBundle\Entity\Node 
     */
    public function getFkNode()
    {
        return $this->fkNode;
    }

    /**
     * Set fkMonitor
     *
     * @param HegesApp\MonitorBundle\Entity\Monitor $fkMonitor
     */
    public function setFkMonitor(\HegesApp\MonitorBundle\Entity\Monitor $fkMonitor)
    {
        $this->fkMonitor = $fkMonitor;
    }

    /**
     * Get fkMonitor
     *
     * @return HegesApp\MonitorBundle\Entity\Monitor 
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
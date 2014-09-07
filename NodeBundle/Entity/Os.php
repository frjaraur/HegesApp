<?php

namespace HegesApp\NodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HegesApp\NodeBundle\Entity\Os
 *
 * @ORM\Table(name="OS")
 * @ORM\Entity
 */
class Os
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
     * @var string $longname
     *
     * @ORM\Column(name="LONGNAME", type="string", length=45, nullable=false)
     */
    private $longname;


     /**
     * @var string $access
     *
     * @ORM\Column(name="ACCESS", type="string", length=45, nullable=true)
     */
    private $access;


    /**
     * Set id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

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
     * Set longname
     *
     * @param string $longname
     */
    public function setLongname($longname)
    {
        $this->longname = $longname;
    }

    /**
     * Get longname
     *
     * @return string 
     */
    public function getLongname()
    {
        return $this->longname;
    }
    /**
     * Set access
     *
     * @param string $access
     */    
    public function setAccess($access)
    {
        $this->access = $access;
    }

    /**
     * Get access
     *
     * @return string 
     */
    public function getAccess()
    {
        return $this->access;
    }    
    
    
    public function __toString()
    {
    	return $this->getName();
    }
}
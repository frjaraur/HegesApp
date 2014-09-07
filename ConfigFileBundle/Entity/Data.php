<?php

namespace HegesApp\ConfigFileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HegesApp\ConfigFileBundle\Entity\Data
 *
 * @ORM\Table(name="DATA")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="HegesApp\ConfigFileBundle\Repository\DataRepository")
 */
class Data
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
     * @var string $value
     *
     * @ORM\Column(name="VALUE", type="string", length=100, nullable=true)
     */
    private $value;

    /**
     * @var datetime $creationtime
     *
     * @ORM\Column(name="CREATIONTIME", type="datetime", nullable=false)
     */
    private $creationtime;

    /**
     * @var string $previousvalue
     *
     * @ORM\Column(name="PREVIOUSVALUE", type="string", length=45, nullable=true)
     */
    private $previousvalue;

    /**
     * @var datetime $updatetime
     *
     * @ORM\Column(name="UPDATETIME", type="datetime", nullable=false)
     */
    private $updatetime;

    /**
     * @var Configfield
     *
     * @ORM\ManyToOne(targetEntity="Configfield")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_CONFIGFIELD_ID", referencedColumnName="id")
     * })
     */
    private $fkConfigfield;

    /**
     * @var Configline
     *
     * @ORM\ManyToOne(targetEntity="Configline")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_CONFIGLINE_ID", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkConfigline;

    /**
     * @var fkCreationuser
     *
     * @ORM\ManyToOne(targetEntity="\HegesApp\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_CREATIONUSER", referencedColumnName="id")
     * })
     */
    private $fkCreationuser;

    /**
     * @var fkUpdateuser
     *
     * @ORM\ManyToOne(targetEntity="\HegesApp\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_UPDATEUSER", referencedColumnName="id")
     * })
     */
    private $fkUpdateuser;



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
     * Set value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set creationtime
     *
     * @param datetime $creationtime
     */
    public function setCreationtime($creationtime)
    {
        $this->creationtime = $creationtime;
    }

    /**
     * Get creationtime
     *
     * @return datetime 
     */
    public function getCreationtime()
    {
        return $this->creationtime;
    }

    /**
     * Set previousvalue
     *
     * @param string $previousvalue
     */
    public function setPreviousvalue($previousvalue)
    {
        $this->previousvalue = $previousvalue;
    }

    /**
     * Get previousvalue
     *
     * @return string 
     */
    public function getPreviousvalue()
    {
        return $this->previousvalue;
    }

    /**
     * Set updatetime
     *
     * @param datetime $updatetime
     */
    public function setUpdatetime($updatetime)
    {
        $this->updatetime = $updatetime;

    }

    /**
     * Get updatetime
     *
     * @return datetime 
     */
    public function getUpdatetime()
    {
        return $this->updatetime;
    }

    /**
     * Set fkConfigfield
     *
     * @param HegesApp\ConfigFileBundle\Entity\Configfield $fkConfigfield
     */
    public function setFkConfigfield(\HegesApp\ConfigFileBundle\Entity\Configfield $fkConfigfield)
    {
        $this->fkConfigfield = $fkConfigfield;
    }

    /**
     * Get fkConfigfield
     *
     * @return HegesApp\ConfigFileBundle\Entity\Configfield 
     */
    public function getFkConfigfield()
    {
        return $this->fkConfigfield;
    }

    /**
     * Set fkConfigline
     *
     * @param HegesApp\ConfigFileBundle\Entity\Configline $fkConfigline
     */
    public function setFkConfigline(\HegesApp\ConfigFileBundle\Entity\Configline $fkConfigline)
    {
        $this->fkConfigline = $fkConfigline;
    }

    /**
     * Get fkConfigline
     *
     * @return HegesApp\ConfigFileBundle\Entity\Configline 
     */
    public function getFkConfigline()
    {
        return $this->fkConfigline;
    }

    /**
     * Set fkCreationuser
     *
     * @param HegesApp\ConfigFileBundle\Entity\User $fkCreationuser
     */
    public function setFkCreationuser(\HegesApp\UserBundle\Entity\User $fkCreationuser)
    {
        $this->fkCreationuser = $fkCreationuser;
    }

    /**
     * Get fkCreationuser
     *
     * @return HegesApp\ConfigFileBundle\Entity\User 
     */
    public function getFkCreationuser()
    {
        return $this->fkCreationuser;
    }

    /**
     * Set fkUpdateuser
     *
     * @param HegesApp\ConfigFileBundle\Entity\User $fkUpdateuser
     */
    public function setFkUpdateuser(\HegesApp\UserBundle\Entity\User $fkUpdateuser)
    {
        $this->fkUpdateuser = $fkUpdateuser;
    }

    /**
     * Get fkUpdateuser
     *
     * @return HegesApp\ConfigFileBundle\Entity\User 
     */
    public function getFkUpdateuser()
    {
        return $this->fkUpdateuser;
    }
    
    public function __toString()
    {
    	return $this->getId();
    }
    
}
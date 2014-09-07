<?php

namespace HegesApp\ConfigFileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * HegesApp\ConfigFileBundle\Entity\Configfield
 *
 * @ORM\Table(name="CONFIGFIELD",uniqueConstraints={@ORM\UniqueConstraint(name="Constraint_Field_Line",columns={"FIELDORDER","FK_CONFIGLINETYPE_ID"})})
 * @ORM\Entity
 */
class Configfield
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
     * @var integer $fieldorder
     *
     * @ORM\Column(name="FIELDORDER", type="integer", nullable=false)
     */
    private $fieldorder;

    /**
     * @var string $fieldname
     *
     * @ORM\Column(name="FIELDNAME", type="string", length=45, nullable=false)
     */
    private $fieldname;

    /**
     * @var string $fielddesc
     *
     * @ORM\Column(name="FIELDDESC", type="text", nullable=false)
     */
    private $fielddesc;
    
    /**
     * @var Configlinetype
     *
     * @ORM\ManyToOne(targetEntity="Configlinetype")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="FK_CONFIGLINETYPE_ID", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $fkConfiglinetype;



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
     * Set fieldorder
     *
     * @param integer $fieldorder
     */
    public function setFieldorder($fieldorder)
    {
        $this->fieldorder = $fieldorder;
    }

    /**
     * Get fieldorder
     *
     * @return integer 
     */
    public function getFieldorder()
    {
        return $this->fieldorder;
    }

    /**
     * Set fieldname
     *
     * @param string $fieldname
     */
    public function setFieldname($fieldname)
    {
        $this->fieldname = $fieldname;
    }

    /**
     * Get fieldname
     *
     * @return string 
     */
    public function getFieldname()
    {
        return $this->fieldname;
    }

    /**
     * Set fielddesc
     *
     * @param text $fielddesc
     */
    public function setFielddesc($fielddesc)
    {
        $this->fielddesc = $fielddesc;
    }

    /**
     * Get fielddesc
     *
     * @return text 
     */
    public function getFielddesc()
    {
        return $this->fielddesc;
    }

    /**
     * Set fkConfiglinetype
     *
     * @param HegesApp\ConfigFileBundle\Entity\Configlinetype $fkConfiglinetype
     */
    public function setFkConfiglinetype(\HegesApp\ConfigFileBundle\Entity\Configlinetype $fkConfiglinetype)
    {
        $this->fkConfiglinetype = $fkConfiglinetype;
    }

    /**
     * Get fkConfiglinetype
     *
     * @return HegesApp\ConfigFileBundle\Entity\Configlinetype 
     */
    public function getFkConfiglinetype()
    {
        return $this->fkConfiglinetype;
    }
    
    public function __toString()
    {
    	return $this->getFieldname();
    }
}
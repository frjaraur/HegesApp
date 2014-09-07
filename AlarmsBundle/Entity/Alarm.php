<?php

namespace HegesApp\AlarmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HegesApp\AlarmsBundle\Entity\Alarm
 *
 * @ORM\Entity
* @ORM\Entity(repositoryClass="HegesApp\AlarmsBundle\Repository\AlarmRepository")
 */
class Alarm
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
     * @var string $alarmmsgid
     *
     * @ORM\Column(name="ALARMMSGID", type="string", length=255, nullable=false)
     */
    private $alarmmsgid;
    
    
    /**
     * @var string $alarmnode
     *
     * @ORM\Column(name="ALARMANODE", type="string", length=45, nullable=false)
     */
    private $alarmnode;    

    /**
     * @var string $alarmdupl
     *
     * @ORM\Column(name="ALARMDUPL", type="integer")
     */
    private $alarmdupl;
    
    
    /**
     * @var string $alarmowned
     *
     * @ORM\Column(name="ALARMOWNED", type="string", length=45, nullable=false)
     */
    private $alarmowned;

    /**
     * @var text $alarmfirst
     *
     * @ORM\Column(name="ALARMFIRST", type="string", length=45, nullable=false)
     */
    private $alarmfirst;

    /**
     * @var text $alarmlast
     *
     * @ORM\Column(name="ALARMLAST", type="string", length=45, nullable=false)
     */
    private $alarmlast;

    /**
     * @var string $alarmseverity
     *
     * @ORM\Column(name="ALARMSEVERITY", type="string", length=25)
     */
    private $alarmseverity;

    /**
     * @var string $alarmmsggrp
     *
     * @ORM\Column(name="ALARMMSGGRP", type="string", length=255)
     */
    private $alarmmsggrp;

    /**
     * @var string $alarmapp
     *
     * @ORM\Column(name="ALARMAPP", type="string", length=255)
     */
    private $alarmapp;
    
    /**
     * @var string $alarmobj
     *
     * @ORM\Column(name="ALARMOBJ", type="string", length=255)
     */
    private $alarmobj;
    
    /**
     * @var string $alarmtext
     *
     * @ORM\Column(name="ALARMTEXT", type="text")
     */
    private $alarmtext;

    /**
     * @var string $alarminstructions
     *
     * @ORM\Column(name="ALARMINSTRUCTIONS", type="text",nullable=true)
     */
    private $alarminstructions;

    
    
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
     * Set alarmmsgid
     *
     * @param string $alarmmsgid
     */
    public function setAlarmmsgid($alarmmsgid)
    {
    	$this->alarmmsgid = $alarmmsgid;
    }
    
    /**
     * Get alarmmsgid
     *
     * @return string
     */
    public function getAlarmmsgid()
    {
    	return $this->alarmmsgid;
    }
    
    /**
     * Set alarmnode
     *
     * @param string $alarmnode
     */
    public function setAlarmnode($alarmnode)
    {
    	$this->alarmnode = $alarmnode;
    }
    
    /**
     * Get alarmmsgid
     *
     * @return string
     */
    public function getAlarmnode()
    {
    	return $this->alarmnode;
    }

    /**
     * Set alarmdupl
     *
     * @param string $alarmdupl
     */
    public function setAlarmdupl($alarmdupl)
    {
    	$this->alarmdupl = $alarmdupl;
    }
    
    /**
     * Get alarmdupl
     *
     * @return string
     */
    public function getAlarmdupl()
    {
    	return $this->alarmdupl;
    }
    
    /**
     * Set alarmowned
     *
     * @param string $alarmdupl
     */
    public function setAlarmowned($alarmowned)
    {
    	$this->alarmowned = $alarmowned;
    }
    
    /**
     * Get alarmowned
     *
     * @return string
     */
    public function getAlarmowned()
    {
    	return $this->alarmowned;
    }
    
    /**
     * Set alarmfirst
     *
     * @param string alarmfirst
     */
    public function setAlarmfirst($alarmfirst)
    {
    	$this->alarmfirst = $alarmfirst;
    }
    
    /**
     * Get alarmfirst
     *
     * @return string
     */
    public function getAlarmfirst()
    {
    	return $this->alarmfirst;
    }
    
    /**
     * Set alarmlast
     *
     * @param string alarmlast
     */
    public function setAlarmlast($alarmlast)
    {
    	$this->alarmlast = $alarmlast;
    }
    
    /**
     * Get alarmlast
     *
     * @return string
     */
    public function getAlarmlast()
    {
    	return $this->alarmlast;
    }
    

    
    /**
     * Set alarmseverity
     *
     * @param string alarmseverity
     */
    public function setAlarmseverity($alarmseverity)
    {
    	$this->alarmseverity = $alarmseverity;
    }
    
    /**
     * Get alarmseverity
     *
     * @return string
     */
    public function getAlarmseverity()
    {
    	return $this->alarmseverity;
    }
    
    
    /**
     * Set alarmmsggrp
     *
     * @param string alarmmsggrp
     */
    public function setAlarmmsggrp($alarmmsggrp)
    {
    	$this->alarmmsggrp = $alarmmsggrp;
    }
    
    /**
     * Get alarmmsggrp
     *
     * @return string
     */
    public function getAlarmmsggrp()
    {
    	return $this->alarmmsggrp;
    }    

    
    
    /**
     * Set alarmapp
     *
     * @param string alarmapp
     */
    public function setAlarmapp($alarmapp)
    {
    	$this->alarmapp = $alarmapp;
    }
    
    /**
     * Get alarmapp
     *
     * @return string
     */
    public function getAlarmapp()
    {
    	return $this->alarmapp;
    }
    
    
    
    /**
     * Set alarmobj
     *
     * @param string alarmobj
     */
    public function setAlarmobj($alarmobj)
    {
    	$this->alarmobj = $alarmobj;
    }
    
    /**
     * Get alarmobj
     *
     * @return string
     */
    public function getAlarmobj()
    {
    	return $this->alarmobj;
    }
    
    
    
    
    /**
     * Set alarmtext
     *
     * @param text alarmtext
     */
    public function setAlarmtext($alarmtext)
    {
    	$this->alarmtext = $alarmtext;
    }
    
    /**
     * Get alarmtext
     *
     * @return string
     */
    public function getAlarmtext()
    {
    	return $this->alarmtext;
    }
    
    
    /**
     * Set alarminstructions
     *
     * @param string alarminstructions
     */
    public function setAlarminstructions($alarminstructions)
    {
    	$this->alarminstructions = $alarminstructions;
    }
    
    /**
     * Get alarminstructions
     *
     * @return string
     */
    public function getAlarminstructions()
    {
    	return $this->alarminstructions;
    }
    
    
}
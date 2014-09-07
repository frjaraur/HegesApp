<?php

namespace HegesApp\PerformanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HegesApp\PerformanceBundle\Entity\Graph
 *
 * @ORM\Table(name="GRAPH")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="HegesApp\PerformanceBundle\Repository\PerformanceRepository")
 */
class Graph
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
     * @var string $graphname
     *
     * @ORM\Column(name="GRAPHNAME", type="string", length=45, nullable=false, unique=true)
     */
    private $graphname;
       
    /**
     * @var text $graphdescription
     *
     * @ORM\Column(name="GRAPHDESCRIPTION", type="text", nullable=true)
     */
    private $graphdescription;

    /**
     * @var string graphurl
     *
     * @ORM\Column(name="GRAPHURL", type="string", length=255, nullable=true)
     */
    private $graphurl;

    /**
     * @var string $graphurluser
     *
     * @ORM\Column(name="GRAPHURLUSER", type="string", length=45, nullable=true)
     */
    private $graphurluser;
    
    /**
     * @var string $graphurlpasswd
     *
     * @ORM\Column(name="GRAPHURLPASSWD", type="string", length=45, nullable=true)
     */
    private $graphurlpasswd;
    
    
    /**
     * @var string $graphicon
     *
     * @ORM\Column(name="GRAPHICON", type="string", length=20, nullable=true)
     */
    private $graphicon;
    
    /**
     * @var $fknodeid
     *
     * @ORM\ManyToOne(targetEntity="\HegesApp\NodeBundle\Entity\Node")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_NODEID", referencedColumnName="id", nullable=true)
     * })
     */
    private $fknodeid;

    /**
     * @var $fkosid
     *
     * @ORM\ManyToOne(targetEntity="\HegesApp\NodeBundle\Entity\Os")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_OSID", referencedColumnName="id", nullable=true)
     * })
     */
    private $fkosid;

    /**
     * @var string graphurlmod
     *
     * @ORM\Column(name="GRAPHURLMOD", type="string", length=255, nullable=true)
     */
    private $graphurlmod;
    
    /**
     * @var string graphtemplate
     *
     * @ORM\Column(name="GRAPHTEMPLATE", type="string", length=255, nullable=true)
     */
    private $graphtemplate;

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
     * Set graphname
     *
     * @param string $graphname
     */
    public function setGraphname($graphname)
    {
        $this->graphname = $graphname;
    }

    /**
     * Get graphname
     *
     * @return string
     */
    public function getGraphname()
    {
        return $this->graphname;
    }

    /**
     * Get graphurluser
     *
     * @return string
     */
    public function getGraphurluser()
    {
    	return $this->graphurluser;
    }
    
    /**
     * Set graphurluser
     *
     * @param string $graphurluser
     */
    public function setGraphurluser($graphurluser)
    {
    	$this->graphurluser = $graphurluser;
    }
    
    /**
     * Get graphurlpasswd
     *
     * @return string
     */
    public function getGraphurlpasswd()
    {
    	return $this->graphurlpasswd;
    }
    
    /**
     * Set graphurlpasswd
     *
     * @param string $graphurlpasswd
     */
    public function setGraphurlpasswd($graphurlpasswd)
    {
    	$this->graphurlpasswd = $graphurlpasswd;
    }
    
    /**
     * Set graphdescription
     *
     * @param text $graphdescription
     */
    public function setGraphdescription($graphdescription)
    {
        $this->graphdescription = $graphdescription;
    }

    /**
     * Get graphdescription
     *
     * @return text 
     */
    public function getGraphdescription()
    {
        return $this->graphdescription;
    }

    /**
     * Set graphurl
     *
     * @param string $graphurl
     */
    public function setGraphurl($graphurl)
    {
        $this->graphurl = $graphurl;
    }

    /**
     * Get graphurl
     *
     * @return string 
     */
    public function getGraphurl()
    {
        return $this->graphurl;
    }

    /**
     * Set graphicon
     *
     * @param string $graphicon
     */
    public function setGraphicon($graphicon)
    {
    	$this->graphicon = $graphicon;
    }
    
    /**
     * Get graphicon
     *
     * @return string
     */
    public function getGraphicon()
    {
    	return $this->graphicon;
    }
    
    
    /**
     * Set fknodeid
     *
     * @param HegesApp\NodeBundle\Entity\Node $fknodeid
     */
    public function setFknodeid(\HegesApp\NodeBundle\Entity\Node $fknodeid = null)
    {
        $this->fknodeid = $fknodeid;
    }

    /**
     * Get fknodeid
     *
     * @return HegesApp\NodeBundle\Entity\Node 
     */
    public function getFknodeid()
    {
        return $this->fknodeid;
    }

    /**
     * Set fkosid
     *
     * @param HegesApp\NodeBundle\Entity\Os $fkosid
     */
    public function setFkosid(\HegesApp\NodeBundle\Entity\Os $fkosid = null)
    {
        $this->fkosid = $fkosid;
    }

    /**
     * Get fkosid
     *
     * @return HegesApp\NodeBundle\Entity\Os 
     */
    public function getFkosid()
    {
        return $this->fkosid;
    }

    /**
     * Set graphurlmod
     *
     * @param string $graphurlmod
     */
    public function setGraphurlmod($graphurlmod)
    {
    	$this->graphurlmod = $graphurlmod;
    }
    
    /**
     * Get graphtemplate
     *
     * @return string
     */
    public function getGraphtemplate()
    {
    	return $this->graphtemplate;
    }
    
    /**
     * Set graphtemplate
     *
     * @param string $graphtemplate
     */
    public function setGraphtemplate($graphtemplate)
    {
    	$this->graphtemplate = $graphtemplate;
    }
    
    /**
     * Get graphurlmod
     *
     * @return string
     */
    public function getGraphurlmod()
    {
    	return $this->graphurlmod;
    }
    
    
    public function __toString()
    {
    	return $this->getGraphName();
    }
    
    public function drawGraph($nodename,$graphname,$graphntemplate,$start=0,$end=0)
    {
    	$SymfonyDir="/opt/Symfony/";
    	$HegesAppTemplateDir=$SymfonyDir."src/HegesApp/PerformanceBundle/GraphTemplates/";
    
    	$defaultgraphtemplatefile=$HegesAppTemplateDir."DEFAULT.template";
    
    	$graphtemplatefile=$HegesAppTemplateDir.$graphntemplate.".template";
    
    	$rrdgraphoptions=array();
    	
    	

    	
    	
    	########### OJO !!!! FECHA INICIAL POR DEFECTO AHORA - 4 HORAS 

    	if ($start == "0"){
    	 		$rrdgraphoptions=array("--start","now-4h");
    	}else{
    		$rrdgraphoptions=array("--start",$start);
    	}

    	if ($end != "0"){
    		array_push($rrdgraphoptions,"--end",$end);
    	}
    	
    	if (file_exists($graphtemplatefile) && is_readable($graphtemplatefile)){
    		
    	
    		
    		$graphtemplate=fopen($graphtemplatefile,"rb");
    		while(!feof($graphtemplate)){
    			$templateline=fgets($graphtemplate);
                        //$templateline=trim($templateline);
    			if (preg_match("/^#/",$templateline) ){
    				continue;
    			}

    			
    			$templateline=str_replace("NODENAME",$nodename,$templateline);
    			
    			array_push($rrdgraphoptions,rtrim($templateline));
    		}
    		fclose($graphtemplate);
 
    	}else{
    
    			
    		######### GRAFICA POR DEFECTO
    		   		
    		$graphtemplate=fopen($defaultgraphtemplatefile,"r");
    		while(!feof($graphtemplate)){
    			$templateline=fgets($graphtemplate);
    			if (preg_match("/^#/",$templateline) ){
    				continue;
    			}
    			$templateline=str_replace("NODENAME",$nodename,$templateline);

    			array_push($rrdgraphoptions,rtrim($templateline));
    		}
    		fclose($graphtemplate);
    
    	}
    
    	

    	$HegesAppWebDir=$SymfonyDir."web/tmp/";
    
    	$imagename=$nodename.".".$graphntemplate.".png";
    
    
    	$rrdgraphimageoutput=$HegesAppWebDir.$imagename;
    	if(is_readable($rrdgraphimageoutput)){
    		unlink($rrdgraphimageoutput);
    	}
    	
    	
    	
    	
    	
    	########### ESTANDAR DE HdG
    	 
    	 
    	array_push($rrdgraphoptions,"--watermark");
    	array_push($rrdgraphoptions,"Herramientas de Gestion - Produccion de Sistemas - Sistemas de Información");
    	array_push($rrdgraphoptions,"--title");
    	array_push($rrdgraphoptions,$graphname);
    	array_push($rrdgraphoptions,"--width");
    	array_push($rrdgraphoptions,"800");
    	array_push($rrdgraphoptions,"--height");
    	array_push($rrdgraphoptions,"500");
    	array_push($rrdgraphoptions,"--grid-dash");
    	array_push($rrdgraphoptions,"0:0");    	
    	array_push($rrdgraphoptions,"--font");
    	array_push($rrdgraphoptions,"DEFAULT:6:Arial");    	 
    	
    	if (preg_match("/h/",$start) ){
    		array_push($rrdgraphoptions,"--x-grid");
    		array_push($rrdgraphoptions,"MINUTE:15:HOUR:1:HOUR:1:0:%H:%M");
    	}
    	
    	if (preg_match("/d/",$start) ){
    		array_push($rrdgraphoptions,"--x-grid");
    		array_push($rrdgraphoptions,"HOUR:6:DAY:1:DAY:1:86400:%d/%m %H:%M");
    	}
    	
    	if (preg_match("/m/",$start) ){
    		array_push($rrdgraphoptions,"--x-grid");
    		array_push($rrdgraphoptions,"DAY:1:DAY:5:DAY:7:1:%d/%m %H:%M");
    	}    	 
    	 
    	
    	
    	//print "$rrdgraphimageoutput, $rrdgraphoptions, count($rrdgraphoptions)";
    	$rrdgraphobj = rrd_graph($rrdgraphimageoutput, $rrdgraphoptions, count($rrdgraphoptions));
    	$error="";  
    	if ( ! is_array($rrdgraphobj) )
    	{
    		$error = rrd_error();
    		//echo "rrd_graph() ERROR: $err\n";
    		
    		//print "ERROR: No se pudo crear la gráfica solicitada.";
    		$graphname="NONE";
    	}
    
    	return array(
    	'graphname' => $graphname,
    	'nodename'      => $nodename,
    	'imagename'      => $imagename,
    	'error' => $error
    	);
    }
    
    
}
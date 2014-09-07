<?php
namespace HegesApp\MainBundle\HegesAppClasses;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HegesAppLog
 *
 * @author symfony
 */
class HegesAppLog {
    
    //put your code here
    
    private $_logfile;
    private $_logusername;
    private $_logsource;
    //private $_logmessage;

    public function __construct ($logfile, $logusername, $logsource)
    {
        $this->_logfile = $logfile;
        $this->_logusername = $logusername;         
        $this->_logsource = $logsource;
        //$this->_logmessage = $logmessage;
    }
   
    private function HegesAppLogManagement ($logfile)
    {        			   			

        $logfilemaxsize=536870912;

        
        //print "LOGFILE: [".$logfile."]";
                        if (file_exists($logfile)){
                            
                            if(filesize($logfile) >= $logfilemaxsize){
                                if (file_exists($logfile.".OLD")){
                                    if(!rename($logfile.".OLD",$logfile.".OLD1")){return false;}
                                }
                                
                                if(!rename($logfile,$logfile.".OLD")){
                                    return false;
                                 }

                                $filehandle=fopen($logfile, 'w');
                                
                                if(!$filehandle){
                                    return false;
                                }                                else{
                                    $filehandle = fclose($filehandle);
                                    
                                }
                            }
                           
                        }else{
                            
                            $filehandle=fopen($logfile, 'w');
                                
                                if(!$filehandle){
                                    return false;
                                }else{
                                    $filehandle = fclose($filehandle);
                                    
                                }
                            
                        }
                        return true;
    }
    
    public function HegesAppLogWriteToLog ($logmessage)
    {
        $this->HegesAppLogManagement($this->_logfile);

        $logmessage = date("Y-m-d H:i:s")." :: ".$this->_logsource." :: ".$this->_logusername." :: ".$logmessage;
        
        $filehandle=fopen($this->_logfile,"a");
        if($filehandle){
            fwrite($filehandle,$logmessage."\n");
         }else{
            return false;
         }
        $filehandle = fclose($filehandle);
    			
        return true;
    }  
}


//                    //TEST
//                $logsource="hegesapp_log_app";
//                $hegesapplogentry = new HegesAppLog(
//                    $this->container->getParameter('hegesapp_log_dir').$this->container->getParameter($logsource),
//                    date("Y-m-d H:i:s"),
//                    $this->container->get('security.context')->getToken()->getUser(),
//                    $logsource);
//                
//                $hegesapplogentry->HegesAppLogWriteToLog("Login de usuario.");

?>


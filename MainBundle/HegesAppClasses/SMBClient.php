<?php
namespace HegesApp\MainBundle\HegesAppClasses;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SMBClient
 *
 * @author symfony
 */
class SMBClient {
    //put your code here
    
    private $_smbservice;
    private $_smbdomain;
    private $_smbusername;
    private $_smbpassword;
    private $_smbcmd;

    public function __construct ($service, $username, $domain, $password)
    {
        $this->_smbservice = $service;
        $this->_smbdomain = $domain;
        $this->_smbusername = $username;         
        $this->_smbpassword = $password;
    }
   

    public function execute ($cmd)
    {
        $this->build_full_cmd($cmd);
       
        $outfile = tempnam(".", "cmd");
        $errfile = tempnam(".", "cmd");
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("file", $outfile, "w"),
            2 => array("file", $errfile, "w")
        );
        $proc = proc_open($this->_smbcmd, $descriptorspec, $pipes);
      
        if (!is_resource($proc)) return 255;
   
        fclose($pipes[0]);    //Don't really want to give any input
   
        $exit = proc_close($proc);
      
   
        unlink($outfile);
        unlink($errfile);
       
        if ($exit)
        {
            return false;
        }
        return true;
    }   
   
    private function build_full_cmd ($cmd = '')
    {
        $this->_smbcmd = "smbclient ";
        $this->_smbcmd .= " --user='" . $this->_smbusername . "'";
          $this->_smbcmd .= " --workgroup='" . $this->_smbdomain . "'";

          $this->_smbcmd .= " '" . $this->_smbservice . "'";

        if ($cmd)
        {
            $this->_smbcmd .= " -c '$cmd'";

          }
            $this->_smbcmd .= " " . $this->_smbpassword ;

          //print "EJECUCION: [".$this->_smbcmd."]\n";
     }



//$smbc = new SMBClient ('//172.23.2.36/C$', 'MYUSERNAME','ONO', 'MYPASSWORD');
//
//if (!$smbc->execute ('md TEST;exit;'))
//{
//               print "Ejecucion erronea.\n";
//}else{
//     print "Ejecucion correcta....TOMA!!!!.\n";
//}

}

?>

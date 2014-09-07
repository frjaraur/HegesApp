<?php

namespace HegesApp\AlarmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {

    		$dbh=new \PDO('oci:dbname=172.31.207.100/ovp1','opc_report','opc_report');
    		$th = 0; // Table Header
    	    	$query = "select decode (A.ASSIGN_FLAG,4,'x',0,'-') as O,
    	A.DUPL_COUNT as DUPL,
    	C.NODE_NAME as NODO,
    	to_char(A.LOCAL_RECEIVING_TIME,'dd-mm-yyyy HH24:MI') as RECEPCION,
    	to_char(A.LOCAL_LAST_TIME_RECEIVED,'dd-mm-yy HH24:MI') as ULTIMA,
    	decode (A.SEVERITY, 2, 'Normal',4,'Warning',16,'Minor',32,'Major',8, 'Critical',1,'Unknown') as SEVERIDAD,
    	A.APPLICATION as APP,
    	A.OBJECT as OBJ,
    	A.MESSAGE_GROUP AS MSGGRP,
    	B.TEXT_PART AS TEXTO
    	from OPC_ACT_MESSAGES A,
    	OPC_NODE_NAMES C, OPC_MSG_TEXT B,
    	OPC_OP_REALM F,OPC_NODES_IN_GROUP D,OPC_USER_DATA E, OPC_NODES Z
    	where E.NAME='p_operador'
    	and E.USER_ID=F.USER_ID
    	and A.MESSAGE_GROUP=F.MSG_GROUP_NAME
    	and F.NODE_GROUP_ID=D.NODE_GROUP_ID 
    	and A.NODE_ID=D.NODE_ID
    	AND A.NODE_ID=C.NODE_ID
    	AND A.NODE_ID=Z.NODE_ID
    	and Z.node_type<>1
    	AND A.MESSAGE_NUMBER=B.MESSAGE_NUMBER
    	AND ACKN_FLAG=0
    	order by A.LOCAL_LAST_TIME_RECEIVED DESC";
    	
    		$s=$dbh->prepare($query);
    		$s->execute();
    		$results=$s->fetchAll();
    		
    	
    	return $this->render('HegesAppMainBundle:Default:opealarms.html.twig', array(
            'entities'      => $results,));
    	
    }
}

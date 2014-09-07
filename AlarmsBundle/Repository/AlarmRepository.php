<?php

namespace HegesApp\AlarmsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use HegesApp\AlarmsBundle\Entity\Alarm;
use HegesApp\AlarmsBundle\Entity\AlarmType;

/**
 * NodeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AlarmRepository extends EntityRepository
{
	
//	
//	public function getOperatoralarms1()
//	{
//                $param_ovo_db_host = $this->container->getParameter('ovo_db_host');
//                $param_ovo_db_instance = $this->container->getParameter('ovo_db_instance');
//                $param_ovo_db_user = $this->container->getParameter('ovo_db_user');
//                $param_ovo_db_passwd = $this->container->getParameter('ovo_db_passwd');
//            
//		//$dbh=new \PDO('oci:dbname=172.31.207.100/ovp1','opc_report','opc_report');
//                
//                $dbh=new \PDO('oci:dbname='.$param_ovo_db_host.'/'.$param_ovo_db_instance, $param_ovo_db_user, $param_ovo_db_passwd);
//		$th = 0; // Table Header
//		$query = "select decode (A.ASSIGN_FLAG,4,'x',0,'-') as O,
//		A.DUPL_COUNT as DUPL,
//		C.NODE_NAME as NODO,
//		to_char(A.LOCAL_RECEIVING_TIME,'dd-mm-yyyy HH24:MI') as RECEPCION,
//		to_char(A.LOCAL_LAST_TIME_RECEIVED,'dd-mm-yy HH24:MI') as ULTIMA,
//		decode (A.SEVERITY, 2, 'Normal',4,'Warning',16,'Minor',32,'Major',8, 'Critical',1,'Unknown') as SEVERIDAD,
//		A.APPLICATION as APP,
//		A.OBJECT as OBJ,
//		A.MESSAGE_GROUP AS MSGGRP,
//		B.TEXT_PART AS TEXTO
//		from OPC_ACT_MESSAGES A,
//		OPC_NODE_NAMES C, OPC_MSG_TEXT B,
//		OPC_OP_REALM F,OPC_NODES_IN_GROUP D,OPC_USER_DATA E, OPC_NODES Z
//		where E.NAME='p_operador'
//		and E.USER_ID=F.USER_ID
//		and A.MESSAGE_GROUP=F.MSG_GROUP_NAME
//		and F.NODE_GROUP_ID=D.NODE_GROUP_ID
//		and A.NODE_ID=D.NODE_ID
//		AND A.NODE_ID=C.NODE_ID
//		AND A.NODE_ID=Z.NODE_ID
//		and Z.node_type<>1
//		AND A.MESSAGE_NUMBER=B.MESSAGE_NUMBER
//		AND ACKN_FLAG=0
//		order by A.LOCAL_LAST_TIME_RECEIVED DESC";
//		 
//		$s=$dbh->prepare($query);
//		$s->execute();
//		$results=$s->fetchAll();
//		return $results;
//	
//	}
	
	public function getOvoalarms($param_ovo_db_host,$param_ovo_db_instance,$param_ovo_db_user,$param_ovo_db_passwd,$ovoprofile)
	{
		//$dbh=new \PDO('oci:dbname=172.31.207.100/ovp1','opc_report','opc_report');

            
		//$dbh=new \PDO('oci:dbname=172.31.207.100/ovp1','opc_report','opc_report');
                
                $dbh=new \PDO('oci:dbname='.$param_ovo_db_host.'/'.$param_ovo_db_instance, $param_ovo_db_user, $param_ovo_db_passwd);
                
		$query = $dbh->prepare("select A.MESSAGE_NUMBER as MSGID, decode (A.ASSIGN_FLAG,4,'x',0,'-') as O,
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
				where E.NAME='".$ovoprofile."'
				and E.USER_ID=F.USER_ID
				and A.MESSAGE_GROUP=F.MSG_GROUP_NAME
				and F.NODE_GROUP_ID=D.NODE_GROUP_ID
				and A.NODE_ID=D.NODE_ID
				AND A.NODE_ID=C.NODE_ID
				AND A.NODE_ID=Z.NODE_ID
				and Z.node_type<>1
				AND A.MESSAGE_NUMBER=B.MESSAGE_NUMBER
				AND ACKN_FLAG=0
				order by A.LOCAL_LAST_TIME_RECEIVED DESC, A.MESSAGE_NUMBER ASC");
		$query->execute();
		$entities=array();$previous_msgid="";$previous_msgtext="";
		while ($data = $query->fetch(\PDO::FETCH_ASSOC)) {

			if ($data['MSGID'] <> $previous_msgid){
				$entity = new Alarm();
				$entity->setAlarmnode($data['NODO']);
				$entity->setAlarmmsgid($data['MSGID']);
				$entity->setAlarmdupl($data['DUPL']);
				$entity->setAlarmowned($data['O']);
				$entity->setAlarmfirst($data['RECEPCION']);
				$entity->setAlarmlast($data['ULTIMA']);
				$entity->setAlarmseverity($data['SEVERIDAD']);
				$entity->setAlarmmsggrp($data['MSGGRP']);
				$entity->setAlarmapp($data['APP']);
				$entity->setAlarmobj($data['OBJ']);
				$entity->setAlarmtext($data['TEXTO']);
				$entity->setAlarminstructions("INSTRUCCIONES");
				array_push($entities,$entity);
				$previous_msgid=$data['MSGID'];
				$previous_msgtext=$data['TEXTO'];
			}else{
				array_pop($entities);
				$entity = new Alarm();
				$entity->setAlarmnode($data['NODO']);
				$entity->setAlarmmsgid($data['MSGID']);
				$entity->setAlarmdupl($data['DUPL']);
				$entity->setAlarmowned($data['O']);
				$entity->setAlarmfirst($data['RECEPCION']);
				$entity->setAlarmlast($data['ULTIMA']);
				$entity->setAlarmseverity($data['SEVERIDAD']);
				$entity->setAlarmmsggrp($data['MSGGRP']);
				$entity->setAlarmapp($data['APP']);
				$entity->setAlarmobj($data['OBJ']);
				$entity->setAlarmtext($previous_msgtext.$data['TEXTO']);
				$entity->setAlarminstructions("INSTRUCCIONES");
				array_push($entities,$entity);
				$previous_msgid=$data['MSGID'];
				$previous_msgtext=$data['TEXTO'];
			}
		
		}
		return $entities;
	
	}
	
//	public function getOperatoralarms3()
//	{
//$param_ovo_db_host = $this->container->getParameter('ovo_db_host');
//                $param_ovo_db_instance = $this->container->getParameter('ovo_db_instance');
//                $param_ovo_db_user = $this->container->getParameter('ovo_db_user');
//                $param_ovo_db_passwd = $this->container->getParameter('ovo_db_passwd');
//            
//		//$dbh=new \PDO('oci:dbname=172.31.207.100/ovp1','opc_report','opc_report');
//                
//                $dbh=new \PDO('oci:dbname='.$param_ovo_db_host.'/'.$param_ovo_db_instance, $param_ovo_db_user, $param_ovo_db_passwd);
//                
//		$query = $dbh->prepare("select decode (A.ASSIGN_FLAG,4,'x',0,'-') ||'|'|| 
//				A.DUPL_COUNT  ||'|'|| 
//				C.NODE_NAME  ||'|'|| 
//				to_char(A.LOCAL_RECEIVING_TIME,'dd-mm-yyyy HH24:MI')  ||'|'|| 
//				to_char(A.LOCAL_LAST_TIME_RECEIVED,'dd-mm-yy HH24:MI')  ||'|'|| 
//				decode (A.SEVERITY, 2, 'Normal',4,'Warning',16,'Minor',32,'Major',8, 'Critical',1,'Unknown')  ||'|'|| 
//				A.APPLICATION  ||'|'|| 
//				A.OBJECT  ||'|'|| 
//				A.MESSAGE_GROUP ||'|'|| 
//				B.TEXT_PART ||'|'|| 
//				from OPC_ACT_MESSAGES A,
//				OPC_NODE_NAMES C, OPC_MSG_TEXT B,
//				OPC_OP_REALM F,OPC_NODES_IN_GROUP D,OPC_USER_DATA E, OPC_NODES Z
//				where E.NAME='p_operador'
//				and E.USER_ID=F.USER_ID
//				and A.MESSAGE_GROUP=F.MSG_GROUP_NAME
//				and F.NODE_GROUP_ID=D.NODE_GROUP_ID
//				and A.NODE_ID=D.NODE_ID
//				AND A.NODE_ID=C.NODE_ID
//				AND A.NODE_ID=Z.NODE_ID
//				and Z.node_type<>1
//				AND A.MESSAGE_NUMBER=B.MESSAGE_NUMBER
//				AND ACKN_FLAG=0
//				order by A.LOCAL_LAST_TIME_RECEIVED DESC");
//		$query->execute();
//		$results=array();
//		while ($data = $query->fetch(\PDO::FETCH_ASSOC)) {
//			
//			array_push($results,$data);
//		}
//	
//		return $results;
//	
//	}
//	
//	
	public function getOvonodeactalarms($param_ovo_db_host,$param_ovo_db_instance,$param_ovo_db_user,$param_ovo_db_passwd,$nodename)
	{
		//$dbh=new \PDO('oci:dbname=172.31.207.100/ovp1','opc_report','opc_report');
                
                $dbh=new \PDO('oci:dbname='.$param_ovo_db_host.'/'.$param_ovo_db_instance, $param_ovo_db_user, $param_ovo_db_passwd);
		$query = $dbh->prepare("SELECT B.MESSAGE_NUMBER as MSGID, decode (A.ASSIGN_FLAG,4,'x',0,'-') as O, a.dupl_count as DUPL,c.node_name as NODO,
		to_char(a.local_receiving_time,'dd-mm-yyyy HH24:MI') as RECEPCION,to_char(a.local_last_time_received,'dd-mm-yy HH24:MI') as ULTIMA,
		decode (a.severity, 2, 'Normal',4,'Warning',16,'Minor',32,'Major',8, 'Critical',1,'Unknow') as SEVERIDAD,
		a.application as APP,a.object as OBJ,a.message_group as MSGGRP,SUBSTR(b.text_part,0,256) as TEXTO
		FROM opc_act_messages a, opc_node_names c, opc_msg_text b
		WHERE node_name='".$nodename."'
		AND a.node_id=c.node_id
		AND a.message_number=b.message_number
		ORDER BY a.local_last_time_received ASC, a.local_receiving_time ASC");
	
		$query->execute();
		$entities=array();$previous_msgid="";$previous_msgtext="";
		while ($data = $query->fetch(\PDO::FETCH_ASSOC)) {
	
			if ($data['MSGID'] <> $previous_msgid){
				$entity = new Alarm();
				$entity->setAlarmnode($data['NODO']);
				$entity->setAlarmmsgid($data['MSGID']);
				$entity->setAlarmdupl($data['DUPL']);
				$entity->setAlarmowned($data['O']);
				$entity->setAlarmfirst($data['RECEPCION']);
				$entity->setAlarmlast($data['ULTIMA']);
				$entity->setAlarmseverity($data['SEVERIDAD']);
				$entity->setAlarmmsggrp($data['MSGGRP']);
				$entity->setAlarmapp($data['APP']);
				$entity->setAlarmobj($data['OBJ']);
				$entity->setAlarmtext($data['TEXTO']);
				$entity->setAlarminstructions("INSTRUCCIONES");
				array_push($entities,$entity);
				$previous_msgid=$data['MSGID'];
				$previous_msgtext=$data['TEXTO'];
			}else{
				array_pop($entities);
				$entity = new Alarm();
				$entity->setAlarmnode($data['NODO']);
				$entity->setAlarmmsgid($data['MSGID']);
				$entity->setAlarmdupl($data['DUPL']);
				$entity->setAlarmowned($data['O']);
				$entity->setAlarmfirst($data['RECEPCION']);
				$entity->setAlarmlast($data['ULTIMA']);
				$entity->setAlarmseverity($data['SEVERIDAD']);
				$entity->setAlarmmsggrp($data['MSGGRP']);
				$entity->setAlarmapp($data['APP']);
				$entity->setAlarmobj($data['OBJ']);
				$entity->setAlarmtext($previous_msgtext.$data['TEXTO']);
				$entity->setAlarminstructions("INSTRUCCIONES");
				array_push($entities,$entity);
				$previous_msgid=$data['MSGID'];
				$previous_msgtext=$data['TEXTO'];
			}
	
		}
		return $entities;
	
	}
	
	public function getOvonodehistalarms($param_ovo_db_host,$param_ovo_db_instance,$param_ovo_db_user,$param_ovo_db_passwd,$nodename)
	{

                //$dbh=new \PDO('oci:dbname=172.31.207.100/ovp1','opc_report','opc_report');
                
                $dbh=new \PDO('oci:dbname='.$param_ovo_db_host.'/'.$param_ovo_db_instance, $param_ovo_db_user, $param_ovo_db_passwd);
                
		$query = $dbh->prepare("SELECT b.MESSAGE_NUMBER as MSGID, a.dupl_count as DUPL, c.node_name as NODO,
		to_char(a.local_receiving_time,'dd-mm-yyyy HH24:MI') as RECEPCION,
		to_char(a.local_last_time_received,'dd-mm-yy HH24:MI') as ULTIMA,
		decode (a.severity, 2, 'Normal',4,'Warning',16,'Minor',32,'Major',8, 'Critical',1,'Unknow')  as SEVERIDAD,
		a.application as APP,
		a.object as OBJ,
		a.message_group as MSGGRP,
		b.text_part as TEXTO,
		a.ackn_user as USUARIO
		FROM opc_hist_messages a, opc_node_names c, opc_hist_msg_text b
		WHERE node_name='".$nodename."'
		AND a.node_id=c.node_id
		AND a.message_number=b.message_number
		AND to_char (a.local_last_time_received,'dd-mm-yyyy') >= (SELECT to_char(SYSDATE - 1,'dd-mm-yyyy') FROM dual)
		ORDER BY a.local_last_time_received ASC, a.local_receiving_time ASC");

		
		
	
		$query->execute();
		$entities=array();$previous_msgid="";$previous_msgtext="";
		while ($data = $query->fetch(\PDO::FETCH_ASSOC)) {
	
			if ($data['MSGID'] <> $previous_msgid){
				$entity = new Alarm();
				$entity->setAlarmnode($data['NODO']);
				$entity->setAlarmmsgid($data['MSGID']);
				$entity->setAlarmdupl($data['DUPL']);
				$entity->setAlarmowned($data['USUARIO']);
				$entity->setAlarmfirst($data['RECEPCION']);
				$entity->setAlarmlast($data['ULTIMA']);
				$entity->setAlarmseverity($data['SEVERIDAD']);
				$entity->setAlarmmsggrp($data['MSGGRP']);
				$entity->setAlarmapp($data['APP']);
				$entity->setAlarmobj($data['OBJ']);
				$entity->setAlarmtext($data['TEXTO']);
				$entity->setAlarminstructions("INSTRUCCIONES");
				array_push($entities,$entity);
				$previous_msgid=$data['MSGID'];
				$previous_msgtext=$data['TEXTO'];
			}else{
				array_pop($entities);
				$entity = new Alarm();
				$entity->setAlarmnode($data['NODO']);
				$entity->setAlarmmsgid($data['MSGID']);
				$entity->setAlarmdupl($data['DUPL']);
				$entity->setAlarmowned($data['USUARIO']);
				$entity->setAlarmfirst($data['RECEPCION']);
				$entity->setAlarmlast($data['ULTIMA']);
				$entity->setAlarmseverity($data['SEVERIDAD']);
				$entity->setAlarmmsggrp($data['MSGGRP']);
				$entity->setAlarmapp($data['APP']);
				$entity->setAlarmobj($data['OBJ']);
				$entity->setAlarmtext($previous_msgtext.$data['TEXTO']);
				$entity->setAlarminstructions("INSTRUCCIONES");
				array_push($entities,$entity);
				$previous_msgid=$data['MSGID'];
				$previous_msgtext=$data['TEXTO'];
			}
	
		}
		return $entities;
	
	}
}



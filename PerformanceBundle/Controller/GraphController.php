<?php

namespace HegesApp\PerformanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HegesApp\PerformanceBundle\Entity\Graph;
use HegesApp\PerformanceBundle\Form\GraphType;
use HegesApp\MainBundle\HegesAppClasses\BrowserInfo;

/**
 * Graph controller.
 *
 */
class GraphController extends Controller
{
    /**
     * Lists all Graph entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('HegesAppPerformanceBundle:Graph')->findAll();

        return $this->render('HegesAppPerformanceBundle:Graph:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Graph entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppPerformanceBundle:Graph')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('GraphController:: showAction :: No existe la grafica con id '.$id);
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppPerformanceBundle:Graph:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Graph entity.
     *
     */
    public function newAction()
    {
        $entity = new Graph();
        $form   = $this->createForm(new GraphType(), $entity);

        return $this->render('HegesAppPerformanceBundle:Graph:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Graph entity.
     *
     */
    public function createAction()
    {
        $entity  = new Graph();
        $request = $this->getRequest();
        $form    = $this->createForm(new GraphType(), $entity);
        $form->bindRequest($request);
        $original_url=$entity->getGraphurl();
        if (stripos($original_url,"USERNAME:PASSWORD")){
        	$original_url=str_replace("USERNAME",$entity->getGraphurluser(),$original_url);
        	$original_url=str_replace("PASSWORD",$entity->getGraphurlpasswd(),$original_url);
        }
        
        $entity->setGraphurlmod($original_url);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
            return $this->redirect($this->generateUrl('graph_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HegesAppPerformanceBundle:Graph:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Graph entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppPerformanceBundle:Graph')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('GraphController:: editAction :: No existe la grafica con id '.$id);
        }

        $editForm = $this->createForm(new GraphType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HegesAppPerformanceBundle:Graph:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Graph entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HegesAppPerformanceBundle:Graph')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('GraphController:: updateAction :: No existe la grafica con id '.$id);
        }

        $editForm   = $this->createForm(new GraphType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);
        
        $original_url=$entity->getGraphurl();
        if (stripos($original_url,"USERNAME:PASSWORD")){
        	$original_url=str_replace("USERNAME",$entity->getGraphurluser(),$original_url);
        	$original_url=str_replace("PASSWORD",$entity->getGraphurlpasswd(),$original_url);
        }
        
        $entity->setGraphurlmod($original_url);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');

            return $this->redirect($this->generateUrl('graph_edit', array('id' => $id)));
        }else{
        	throw $this->createNotFoundException('GraphController:: updateAction :: No se que pasa ... '.$id);
        }

        return $this->render('HegesAppPerformanceBundle:Graph:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Graph entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HegesAppPerformanceBundle:Graph')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('GraphController:: deleteAction :: No existe la grafica con id '.$id);
            }

            $em->remove($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', 'Los cambios se realizaron correctamente.');
        }

        return $this->redirect($this->generateUrl('graph'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    public function mainAction()
    {
    	 
    	$em = $this->getDoctrine()->getEntityManager();
    	$entities = $em->getRepository('HegesAppNodeBundle:Node')
    	->getAllNodes();
    
    	return $this->render('HegesAppPerformanceBundle:Graph:main.html.twig', array(
    			'entities' => $entities
    	));
    
    }
    
    
    public function graphsfornodeAction($nodeid)
    {
    
    	$Browser = new BrowserInfo();
    	$BrowserInfo = $Browser->getBrowserInfo();
    	$BrowserName = $BrowserInfo['name'];
/*     	$versionBrowserVersion    = $BrowserInfo['version']; */
    	
    	//throw $this->createNotFoundException($navegador.' --- '.$versionB);
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	$specific_node_graphs = $em->getRepository('HegesAppPerformanceBundle:Graph')
    	->getgraphsfornode($nodeid);
    	
    	$node_entity = $em->getRepository('HegesAppNodeBundle:Node')->findOneById($nodeid);
    	
    	if (!$node_entity) {
    		throw $this->createNotFoundException('GraphController:: graphsfornodeAction :: No existen nodos para el id '.$nodeid);
    	}
    	$osid=$node_entity->getfkOs();
    	$nodename=$node_entity->getName();
    	$os_node_graphs = $em->getRepository('HegesAppPerformanceBundle:Graph')
    	->getgraphsforos($osid);
    	
    	if (!$specific_node_graphs and !$os_node_graphs ) {
    		//throw $this->createNotFoundException('GraphController:: graphsfornodeAction :: No existen graficas para el nodo '.$node_entity->getName());
    		$entities = $em->getRepository('HegesAppNodeBundle:Node')
    		->getAllNodes();
    		$this->get('session')->setFlash('error', 'No existen gráficas para el nodo indicado '.$nodename);
    		return $this->render('HegesAppPerformanceBundle:Graph:main.html.twig', array(
    				'entities' => $entities));
    	}
    	
    	foreach ( $specific_node_graphs as $entity){
    		$original_url=$entity->getGraphurlmod();
    		$modified_url=$original_url;
    		if($BrowserName == "Internet Explorer"){
    			$modified_url=$entity->getGraphurl();
    		    $this->get('session')->setFlash('error', 'Su navegador no admite redirecciones con usuario@password. Se pedira usuario y password para las URLs externas.');
    		    $modified_url=str_replace("USERNAME:","",$modified_url);
    		    $modified_url=str_replace("PASSWORD@","",$modified_url);
    		}
    		$modified_url=str_replace("HOSTNAME",$nodename,$modified_url);
/*     		$graph_username=$entity->getGraphurluser();
    		$graph_password=$entity->getGraphurlpasswd();
    		$modified_url=str_replace("USERNAME",$graph_username,$modified_url);
    		$modified_url=str_replace("PASSWORD",$graph_password,$modified_url); */
    		
    		$entity->setGraphurl($modified_url);
    		
    		
    	}
    	foreach ( $os_node_graphs as $entity){
    		$original_url=$entity->getGraphurlmod();
    		$modified_url=$original_url;
    		if($BrowserName == "Internet Explorer"){
    			$modified_url=$entity->getGraphurl();
    		    $this->get('session')->setFlash('error', 'Su navegador no admite redirecciones con usuario@password. Se pedirá usuario y password para las URLs externas.');
    		    $modified_url=str_replace("USERNAME:","",$modified_url);
    		    $modified_url=str_replace("PASSWORD@","",$modified_url);
    		}
    		$modified_url=str_replace("HOSTNAME",$nodename,$modified_url);
/*     		$graph_username=$entity->getGraphurluser();
    		$graph_password=$entity->getGraphurlpasswd();
    		$modified_url=str_replace("USERNAME",$graph_username,$modified_url);
    		$modified_url=str_replace("PASSWORD",$graph_password,$modified_url);
 */    		$entity->setGraphurl($modified_url);
    	}    	
    	return $this->render('HegesAppPerformanceBundle:Graph:graphsfornode.html.twig', array(
    			'specific_node_graphs' => $specific_node_graphs,
    			'os_node_graphs' => $os_node_graphs,
    			'node_name'=> $nodename
    	));
    
    }


    public function drawsimplegraphAction ($nodename,$graphname,$start=0,$end=0)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$graphentity = $em->getRepository('HegesAppPerformanceBundle:Graph')->findOneByGraphname($graphname);
    	
    	if (!$graphentity) {
    		throw $this->createNotFoundException('GraphController :: drawsimplegraphAction :: No existe la gráfica '.$graphname);
    	}
    	$mygraphtemplate=$graphentity->getGraphtemplate();
    	
    	$mygrah     = new Graph();
    	$mydrawgraph  = $mygrah->drawGraph($nodename,$graphname,$mygraphtemplate,$start,$end);
    	$mygraphname  = $mydrawgraph['graphname'];
    	$myimagename  = $mydrawgraph['imagename'];
    	$myerror      = $mydrawgraph['error'];

    	if ($mygraphname == "NONE"){
    		$entities = $em->getRepository('HegesAppNodeBundle:Node')
    		->getAllNodes();
    		$this->get('session')->setFlash('error', 'Error en la generación de la grafica ('.$myerror.')');
    		return $this->render('HegesAppPerformanceBundle:Graph:error.html.twig', array(
    				'graphname' => $mygraphname,
    				'imagename' => $myimagename,
    				'nodename'=> $nodename
    				));
    		
    	}else{
    		$this->get('session')->setFlash('notice', 'Generación de gráfica correcta.');
    	}
    	
    		return $this->render('HegesAppPerformanceBundle:Graph:simplegraphfornode.html.twig', array(
    				'graphname' => $mygraphname,
    				'imagename' => $myimagename,
    				'nodename'=> $nodename
    				));
    }

    
    public function CopyAction($id)
    {
    	 
    	$em = $this->getDoctrine()->getEntityManager();
    	 
    	$original_entity = $em->getRepository('HegesAppPerformanceBundle:Graph')->findOneById($id);
    	 
    	if (!$original_entity) {
    		throw $this->createNotFoundException('GraphController :: CopyAction :: No existe la gráfica con id '.$id);
    	}
    
    	$copy_entity  = new Graph();
    	$request = $this->getRequest();
    	$form    = $this->createForm(new GraphType(), $copy_entity);
    	$form->bindRequest($request);
    
    	//cargamos las propiedades de la grafica original
    	 
    	$em = $this->getDoctrine()->getEntityManager();
    
    	$copy_entity->setGraphname('Copy of '.$original_entity->getGraphname());
    	$copy_entity->setGraphdescription($original_entity->getGraphdescription());
    	$copy_entity->setGraphurluser($original_entity->getGraphurlpasswd());
    	$copy_entity->setGraphurlpasswd($original_entity->getGraphurlpasswd());
    	$copy_entity->setGraphicon($original_entity->getGraphicon());
    	$copy_entity->setGraphtemplate($original_entity->getGraphtemplate());
    	$copy_entity->setFkosid();
    	$copy_entity->setFknodeid();
    	$copy_entity->setGraphurl($original_entity->getGraphurl());
    	$copy_entity->setGraphurlmod($original_entity->getGraphurlmod());    	    
    
    	//Guardamos la copia de la gráfica original
    
    	$em->persist($copy_entity);
    
    	$em->flush();
    	$this->get('session')->setFlash('notice', 'Copia de Gráfica realizada correctamente. No olvides asignarla!!!');
    	return $this->redirect($this->generateUrl('graph_show', array('id' => $copy_entity->getId())));
    	 
    }
    
    private function createCopyForm($id)
    {
    	return $this->createFormBuilder(array('id' => $id))
    	->add('id', 'hidden')
    	->getForm()
    	;
    }
    
    public function drawcustomgraphAction ($nodename,$graphname,$startdate,$enddate)
    {
    	
    	$request = $this->getRequest();
    	
    	$startdate=$request->request->get('startdate');
    	$enddate=$request->request->get('enddate');

    	
    	

     	$em = $this->getDoctrine()->getEntityManager();
    	$graphentity = $em->getRepository('HegesAppPerformanceBundle:Graph')->findOneByGraphname($graphname);
    	 
    	if (!$graphentity) {
    		throw $this->createNotFoundException('GraphController :: drawsimplegraphAction :: No existe la gráfica '.$graphname);
    	}
    	$mygraphtemplate=$graphentity->getGraphtemplate();
    	 
    	$mygrah     = new Graph();
    	$mydrawgraph  = $mygrah->drawGraph($nodename,$graphname,$mygraphtemplate,$startdate,$enddate);
    	$mygraphname  = $mydrawgraph['graphname'];
    	$myimagename  = $mydrawgraph['imagename'];
    	$myerror      = $mydrawgraph['error'];
    
    	if ($mygraphname == "NONE"){
    		$entities = $em->getRepository('HegesAppNodeBundle:Node')
    		->getAllNodes();
    		$this->get('session')->setFlash('error', 'Error en la generación de la grafica ('.$myerror.')');
    		return $this->render('HegesAppPerformanceBundle:Graph:error.html.twig', array(
    				'graphname' => $mygraphname,
    				'imagename' => $myimagename,
    				'nodename'=> $nodename
    		));
    
    	}else{
    		$this->get('session')->setFlash('notice', 'Generación de gráfica correcta.');
    	}
    	//print "$nodename,$graphname,$startdate,$enddate";
    	return $this->render('HegesAppPerformanceBundle:Graph:simplegraphfornode.html.twig', array(
    			'graphname' => $mygraphname,
    			'imagename' => $myimagename,
    			'nodename'=> $nodename
    	));

    }

    
    
}

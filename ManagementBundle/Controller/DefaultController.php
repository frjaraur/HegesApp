<?php

namespace HegesApp\ManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('HegesAppManagementBundle:Default:index.html.twig', array('name' => $name));
    }
}

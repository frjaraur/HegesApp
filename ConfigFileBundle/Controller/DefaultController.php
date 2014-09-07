<?php

namespace HegesApp\ConfigFileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('HegesAppConfigFileBundle:Default:index.html.twig', array('name' => $name));
    }
}

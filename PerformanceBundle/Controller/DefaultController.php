<?php

namespace HegesApp\PerformanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('HegesAppPerformanceBundle:Default:index.html.twig', array('name' => $name));
    }
}

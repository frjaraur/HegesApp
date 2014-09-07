<?php

namespace HegesApp\MonitorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('HegesAppMonitorBundle:Default:index.html.twig', array('name' => $name));
    }
}

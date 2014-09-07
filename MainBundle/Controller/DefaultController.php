<?php

namespace HegesApp\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HegesApp\MainBundle\HegesAppClasses\HegesAppLog;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
    		return $this->render('HegesAppMainBundle:Default:index.html.twig');

    }
    
    
}

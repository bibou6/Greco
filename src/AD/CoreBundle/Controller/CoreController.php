<?php

namespace AD\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
    	
    	
    	
    	
        return $this->render('CoreBundle:Core:index.html.twig',array(
        		'menu' => 'home'
        ));
    }
}

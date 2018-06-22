<?php

namespace AD\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction(Request $request)
    {
    	
    	
    	
        return $this->redirectToRoute('core_homepage',array(
        		'_locale' => $request->getLocale()
        ));
    }
    
    public function projectAction()
    {
    	return $this->render('CoreBundle:Project:project.html.twig',array(
    			'menu' => 'project'
    	));
    }
    
    public function indexWithLocaleAction()
    {
    	 
    	return $this->render('CoreBundle:Core:index.html.twig',array(
    			'menu' => 'home'
    	));
    }
}

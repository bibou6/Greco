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
    	return $this->render('CoreBundle:Company:project.html.twig',array(
    			'menu' => 'company'
    	));
    }
    
    public function teamAction()
    {
    	return $this->render('CoreBundle:Company:team.html.twig',array(
    			'menu' => 'company'
    	));
    }
    
    public function administrationAction()
    {
    	return $this->render('CoreBundle:Company:administration.html.twig',array(
    			'menu' => 'company'
    	));
    }
    
    public function indexWithLocaleAction()
    {
    	 
    	return $this->render('CoreBundle:Core:index.html.twig',array(
    			'menu' => 'home'
    	));
    }
    
    public function termsAction()
    {
    	return $this->render('CoreBundle:Core:terms.html.twig',array(
    			'menu' => 'home'
    	));
    }
    
}

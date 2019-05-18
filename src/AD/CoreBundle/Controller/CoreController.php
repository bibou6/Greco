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
    	
    	$backgroundUrl=$this->container->get('assets.packages')->getUrl("bundles/core/img/background/ABS3.jpg");
    	
    	
    	return $this->render('CoreBundle:Company:project.html.twig',array(
    			'menu' => 'company',
    			'backgroundUrl' => $backgroundUrl
    	));
    }
    
    public function teamAction()
    {
    	$backgroundUrl=$this->container->get('assets.packages')->getUrl("bundles/core/img/background/ABS3.jpg");
    	
    	return $this->render('CoreBundle:Company:team.html.twig',array(
    			'menu' => 'company',
    			'backgroundUrl' => $backgroundUrl,
    			'pictures' => true
    	));
    }
    
    public function administrationAction()
    {
    	$backgroundUrl=$this->container->get('assets.packages')->getUrl("bundles/core/img/background/ABS3.jpg");
    	
    	return $this->render('CoreBundle:Company:administration.html.twig',array(
    			'menu' => 'company',
    			'backgroundUrl' => $backgroundUrl
    	));
    }
    
    public function indexWithLocaleAction()
    {
    	$backgroundUrl=$this->container->get('assets.packages')->getUrl("bundles/core/img/background/abstracto.jpg");
    	 
    	
    	return $this->render('CoreBundle:Core:index.html.twig',array(
    			'menu' => 'home',
    			'backgroundUrl' => $backgroundUrl
    	));
    }
    
    public function termsAction()
    {
    	
    	return $this->render('CoreBundle:Core:terms.html.twig',array(
    			'menu' => 'home'
    	));
    }
    
}

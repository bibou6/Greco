<?php

namespace AD\PensionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PensionController extends Controller
{
    public function indexAction()
    {
        return $this->render('PensionBundle:Default:index.html.twig');
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteImageAction(Request $request){
    	
    	$pensionImageId = $request->query->get('id');
    	$em = $this->getDoctrine()->getManager();
    	$pension = $em->getRepository('PensionBundle:PensionImage')->find($pensionImageId);
    	$em->remove($pension);
    	$em->flush();
    	
    	// redirect to the 'list' view of the given entity
    	return $this->redirectToRoute('easyadmin', array(
    			'action' => 'list',
    			'entity' => $request->query->get('entity'),
    	));
    	
    }
}

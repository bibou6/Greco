<?php

namespace AD\FlatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FlatController extends Controller
{
    public function indexAction()
    {
        return $this->render('PensionBundle:Default:index.html.twig');
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteImageAction(Request $request){
    	
    	$flatImageId = $request->query->get('id');
    	$em = $this->getDoctrine()->getManager();
    	$flat = $em->getRepository('FlatBundle:FlatImage')->find($flatImageId);
    	$em->remove($flat);
    	$em->flush();
    	
    	// redirect to the 'list' view of the given entity
    	return $this->redirectToRoute('easyadmin', array(
    			'action' => 'list',
    			'entity' => $request->query->get('entity'),
    	));
    	
    }
}

<?php

namespace AD\PensionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AD\PensionBundle\Entity\PensionImage;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function uploadPensionImageAction($id, Request $request){
    
    	$logger = $this->get('logger');
    	$em = $this->getDoctrine()->getManager();
    	 
    	//Retrieving flat on which you add the file
    	 
    	$pension = $em->getRepository('PensionBundle:Pension')->find($id);
    	$uploaded_file = $request->files->get('file');
    	
    	$logger->info('File upload for Pension : '.$pension->getName());
    	
    	if($request->isMethod("POST")){
    		if($uploaded_file !== null){
    			$logger->info('File upload for Pension : '.$pension->getName());
    			$pensionImage = new PensionImage();
    			$pensionImage->setAlt(null);
    			$pensionImage->setPension($pension);
    			$pensionImage->setImageFile($uploaded_file);
    			$em->persist($pensionImage);
    	   
    			$pension->addImage($pensionImage);
    	   
    			$em->flush();
    		}
    		// redirect to the 'list' view of the given entity
    		return new JsonResponse(array('success' => true));
    	}
    
    	// redirect to the 'list' view of the given entity
    	return new JsonResponse(array('success' => false));
	}
}
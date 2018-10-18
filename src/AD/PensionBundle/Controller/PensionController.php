<?php

namespace AD\PensionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AD\PensionBundle\Entity\PensionImage;
use Symfony\Component\HttpFoundation\JsonResponse;
use AD\PensionBundle\Entity\Pension;

class PensionController extends Controller
{
    public function listAction()
    {
    	$backgroundUrl=$this->container->get('assets.packages')->getUrl("bundles/core/img/background/ACC2.jpg");
    	
    	$em = $this->getDoctrine()->getManager();
    	$pensions = $em->getRepository('PensionBundle:Pension')->findBy(array(
            'enabled' => true,
    		'summer' => false
    	));
    	
    	
        return $this->render('PensionBundle::list.html.twig', array(
        		'menu' => 'pension',
        		'pensions' => $pensions,
    			'backgroundUrl' => $backgroundUrl
        ));
    }
    
    public function showAction(Pension $pension)
    {
    	$backgroundUrl=$this->container->get('assets.packages')->getUrl("bundles/core/img/background/ADD.jpg");
    	
    	if($pension == null || !$pension->getEnabled()){
    		return $this->redirectToRoute('pension_list');
    	}
    	
    	return $this->render('PensionBundle::show.html.twig', array(
    			'menu' => 'pension',
    			'pension' => $pension,
    			'backgroundUrl' => $backgroundUrl
    	));
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
    	
    	$logger->info('Image upload for Pension : '.$pension->getName());
    	
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
	
	
	/**
	 * Resorts an item using it's doctrine sortable property
	 * @param integer $id
	 * @param integer $position
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function sortAction($id, $position)
	{
		$em = $this->getDoctrine()->getManager();
		$pensionImage = $em->getRepository('PensionBundle:PensionImage')->find($id);
		if($pensionImage != null){
			$pensionImage->setPosition($position);
			$em->persist($pensionImage);
			$em->flush();
		}
		return $this->redirectToRoute('easyadmin', array(
				'action' => 'list',
				'entity' => 'Pension',
		));
		
		
		
	}
}

<?php

namespace AD\PensionBundle\Controller;

use AD\PensionBundle\Entity\Pension;
use AD\PensionBundle\Entity\PensionImage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AD\PensionBundle\Service\PdfPensionService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PensionController extends Controller
{
    public function listAction()
    {
    	$backgroundUrl=$this->container->get('assets.packages')->getUrl("bundles/core/img/background/ACC2.jpg");
    	
    	$em = $this->getDoctrine()->getManager();
    	$pensions = $em->getRepository('PensionBundle:Pension')->findBy(array(
            'enabled' => true
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
	
	public function publishAction()
	{
		
		$em = $this->getDoctrine()->getManager();
		$pensions = $em->getRepository('PensionBundle:Pension')->findBy(array(
				'enabled' => true,
		));
		
		shuffle($pensions);
		
		return $this->render('PensionBundle::publish.html.twig', array(
				'pensions' => $pensions,
		));
	}
	
	/**
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function pdfDetailsAction(){
		$em = $this->getDoctrine()->getManager();
		$pensions = $em->getRepository('PensionBundle:Pension')->findBy(array(
				'enabled' => true,
		));
	
		
		$pdfService = $this->container->get ( 'core_bundle.pdf' );
		
		$pdf = $pdfService->generatePensionRecapPdf($pensions);
		
		return new Response($pdf->Output(null,"Inventario_departamento_Greco.pdf",
				true), 200, array(
						'Content-Type' => 'application/pdf')
				);
		
	}
	
	
	
	
}

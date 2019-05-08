<?php

namespace AD\FlatBundle\Controller;

use AD\FlatBundle\Entity\Flat;
use AD\FlatBundle\Entity\FlatImage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AD\FlatBundle\Service\PdfFlatService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FlatController extends Controller
{
	public function listSaleAction()
	{
		$backgroundUrl=$this->container->get('assets.packages')->getUrl("bundles/core/img/background/ABS4.jpg");
		
		$em = $this->getDoctrine()->getManager();
		$flats = $em->getRepository('FlatBundle:Flat')->findBy(array(
				'enabled' => true,
				'forSale' => true
		),array(
				'rented' => 'ASC'
		));
		 
		 
		return $this->render('FlatBundle::list.html.twig', array(
				'menu' => 'flat',
				'flats' => $flats,
    			'backgroundUrl' => $backgroundUrl
		));
	}
	
	public function listRentAction()
	{
		$backgroundUrl=$this->container->get('assets.packages')->getUrl("bundles/core/img/background/ABS4.jpg");
	
		$em = $this->getDoctrine()->getManager();
		$flats = $em->getRepository('FlatBundle:Flat')->findBy(array(
				'enabled' => true,
				'forSale' => false
		),array(
				'rented' => 'ASC'
		));
			
			
		return $this->render('FlatBundle::list.html.twig', array(
				'menu' => 'flat',
				'flats' => $flats,
				'backgroundUrl' => $backgroundUrl
		));
	}
	
	public function showAction(Flat $flat)
	{
		$backgroundUrl=$this->container->get('assets.packages')->getUrl("bundles/core/img/background/ABS6.jpg");
		
		if($flat == null || !$flat->getEnabled()){
			return $this->redirectToRoute('pension_list');
		}
		 
		return $this->render('FlatBundle::show.html.twig', array(
				'menu' => 'flat',
				'flat' => $flat,
    			'backgroundUrl' => $backgroundUrl
		));
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
    
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function uploadFlatImageAction($id, Request $request){
    	 
    	$logger = $this->get('logger');
    	$em = $this->getDoctrine()->getManager();
    	
    	//Retrieving flat on which you add the file
    	
	 	$flat = $em->getRepository('FlatBundle:Flat')->find($id);
    	$uploaded_file = $request->files->get('file');
    	
    	if($request->isMethod("POST")){
    		if($uploaded_file !== null){
	    		$logger->info('Image upload for Flat : '.$flat->getName());
	    		$flatImage = new FlatImage();
	    		$flatImage->setAlt(null);
	    		$flatImage->setFlat($flat);
	    		$flatImage->setImageFile($uploaded_file);
	    		$em->persist($flatImage);
	    		
	    		$flat->addImage($flatImage);
	    		
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
    	$pensionImage = $em->getRepository('FlatBundle:FlatImage')->find($id);
    	if($pensionImage != null){
    		$pensionImage->setPosition($position);
    		$em->persist($pensionImage);
    		$em->flush();
    	}
    	return $this->redirectToRoute('easyadmin', array(
    			'action' => 'list',
    			'entity' => 'Flat',
    	));
    
    
    
    }
    
    
    public function listSummerRentAction()
    {
    	$backgroundUrl=$this->container->get('assets.packages')->getUrl("bundles/core/img/background/ABS4.jpg");
    
    	$em = $this->getDoctrine()->getManager();
    	$flats = $em->getRepository('FlatBundle:Flat')->findBy(array(
    			'enabled' => true,
    			'forSale' => false,
    			'summer' => true
    	),array(
    			'rented' => 'ASC'
    	));
    		
    		
    	return $this->render('FlatBundle::summer_list.html.twig', array(
    			'menu' => 'summer_flat',
    			'flats' => $flats,
    			'backgroundUrl' => $backgroundUrl
    	));
    }
    
    public function showSummerAction(Flat $flat)
    {
    	$backgroundUrl=$this->container->get('assets.packages')->getUrl("bundles/core/img/background/ABS6.jpg");
    
    	if($flat == null || !$flat->getEnabled()){
    		return $this->redirectToRoute('pension_list');
    	}
    		
    	return $this->render('FlatBundle::summer_show.html.twig', array(
    			'menu' => 'summer_flat',
    			'flat' => $flat,
    			'backgroundUrl' => $backgroundUrl
    	));
    }
    
    public function publishAction(){
    	$em = $this->getDoctrine()->getManager();
    	$flats = $em->getRepository('FlatBundle:Flat')->findBy(array(
    			'enabled' => true,
    			'summer' => false,
    			'rented' => false
    	));
    	
    	shuffle($flats);
    	
    	
    	return $this->render('FlatBundle::publish.html.twig', array(
    			'flats' => $flats
    	));
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function pdfDetailsAction(){
    	$em = $this->getDoctrine()->getManager();
    	$flats = $em->getRepository('FlatBundle:Flat')->findBy(array(
    			'enabled' => true,
    			'summer' => false,
    			'rented' => false
    	));
    	
    	
    	$pdfService = $this->container->get ( 'core_bundle.pdf' );
    	
    	$pdf = $pdfService->generateFlatRecapPdf($flats);
    	
    	dump($pdf);
    	
    	return new Response($pdf->Output(null,"Inventario_departamento_Greco.pdf",
    			true), 200, array(
    					'Content-Type' => 'application/pdf')
    			);
    	
    }
    
    
}

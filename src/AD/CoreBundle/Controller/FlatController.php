<?php

namespace AD\CoreBundle\Controller;

use AD\CoreBundle\Entity\Flat;
use AD\CoreBundle\Entity\FlatImage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FlatController extends Controller
{
	public function listSaleAction()
	{
		
		$em = $this->getDoctrine()->getManager();
		$flats = $em->getRepository('CoreBundle:Flat')->findBy(array(
				'enabled' => true,
				'forSale' => true
		),array(
				'rented' => 'ASC',
				'uploadedDate' => 'DESC'
		));
		 
		 
		return $this->render('CoreBundle:Flat:list.html.twig', array(
				'menu' => 'flat',
				'flats' => $flats,
		));
	}
	
	public function listRentAction()
	{
	
		$em = $this->getDoctrine()->getManager();
		$flats = $em->getRepository('CoreBundle:Flat')->findBy(array(
				'enabled' => true,
				'forSale' => false,
				'summer' => false
		),array(
				'rented' => 'ASC',
				'uploadedDate' => 'DESC'
		));
			
			
		return $this->render('CoreBundle:Flat:list.html.twig', array(
				'title' => 'Depa',
				'menu' => 'flat',
				'flats' => $flats,
		));
	}
	
	public function showAction(Flat $flat)
	{
		
		if($flat == null || !$flat->getEnabled()){
			return $this->redirectToRoute('pension_list');
		}
		
		if($flat->getSummer() == true){
			$menu = 'summer_flat';
		}else{
			$menu = 'flat';
		}
		 
		return $this->render('CoreBundle:Building:building_show_item.html.twig', array(
				'title' => 'Depa',
				'menu' => $menu,
				'isFlat' => true,
				'building' => $flat,
		));
	}
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteImageAction(Request $request){
    	
    	$flatImageId = $request->query->get('id');
    	$em = $this->getDoctrine()->getManager();
    	$flat = $em->getRepository('CoreBundle:FlatImage')->find($flatImageId);
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
    	
	 	$flat = $em->getRepository('CoreBundle:Flat')->find($id);
	 	dump($request->files);
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
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function uploadFlatMainImageAction($id, Request $request){
    	
    	$logger = $this->get('logger');
    	$em = $this->getDoctrine()->getManager();
    	
    	//Retrieving flat on which you add the file
    	
    	$flat = $em->getRepository('CoreBundle:Flat')->find($id);
    	$uploaded_file = $request->files->get('file');
    	
    	if($request->isMethod("POST")){
    		if($uploaded_file !== null){
    			$logger->info('Image upload for Flat : '.$flat->getName());
    			
    			$flat->setImageFile($uploaded_file);
    			
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
    	$pensionImage = $em->getRepository('CoreBundle:FlatImage')->find($id);
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
    
    	$em = $this->getDoctrine()->getManager();
    	$flats = $em->getRepository('CoreBundle:Flat')->findBy(array(
    			'enabled' => true,
    			'forSale' => false,
    			'summer' => true
    	),array(
    			'rented' => 'ASC'
    	));
    		
    		
    	return $this->render('CoreBundle:Flat:summer_list.html.twig', array(
    			'menu' => 'summer_flat',
    			'flats' => $flats,
    	));
    }
    
    public function showSummerAction(Flat $flat)
    {
    
    	if($flat == null || !$flat->getEnabled()){
    		return $this->redirectToRoute('pension_list');
    	}
    		
    	return $this->render('CoreBundle:Building:building_show_item.html.twig', array(
    			'title' => 'Depa',
    			'menu' => 'summer_flat',
    			'isFlat' => true,
    			'building' => $flat,
    	));
    }
    
    public function publishAction(){
    	$em = $this->getDoctrine()->getManager();
    	$flats = $em->getRepository('CoreBundle:Flat')->findBy(array(
    			'enabled' => true,
    			'summer' => false,
    			'rented' => false
    	),array(
    		'uploadedDate' => 'DESC'
    	));
    	
    	$pensions = $em->getRepository('CoreBundle:Pension')->findBy(array(
    			'enabled' => true,
    	));
    	
    	
    	$result = array_merge($pensions,$flats);
    	
    	
    	return $this->render('CoreBundle:Flat:publish.html.twig', array(
    			'flats' => $result
    	));
    }
    
    
    
    
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function pdfDetailsAction(){
    	$em = $this->getDoctrine()->getManager();
    	$flats = $em->getRepository('CoreBundle:Flat')->findBy(array(
    			'enabled' => true,
    			'summer' => false,
    			'rented' => false
    	));
    	
    	
    	$pdfService = $this->container->get ( 'core_bundle.pdf' );
    	
    	$pdf = $pdfService->generateFlatRecapPdf($flats);
    	
    	return new Response($pdf->Output(null,"Inventario_departamento_Greco.pdf",
    			true), 200, array(
    					'Content-Type' => 'application/pdf')
    			);
    	
    }
    
    public function compress($source, $destination, $quality) {
    	
    	$info = getimagesize($source);
    	dump($info);
    	
    	if ($info['mime'] == 'image/jpeg')
    		$image = imagecreatefromjpeg($source);
    		
    		elseif ($info['mime'] == 'image/gif')
    		$image = imagecreatefromgif($source);
    		
    		elseif ($info['mime'] == 'image/png')
    		$image = imagecreatefrompng($source);
    		
    		return imagejpeg($image,$destination, $quality);
    		
    }
    
    
    
}

<?php

namespace AD\CoreBundle\Controller;

use AD\CoreBundle\Entity\Flat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends BaseAdminController
{
	protected function initialize(Request $request)
	{
		$this->get('translator')->setLocale('es');
		parent::initialize($request);
	}
	
	
	public function zipPhotosAction(){
		
		ob_start();
		
		dump($this->request->query);
		$id = $this->request->query->get('id');
		$entity = $this->em->getRepository('CoreBundle:Flat')->find($id);
		
		$zip=new \ZipArchive();
		$zipname=str_replace(' ','_',$entity->getName()."_fotos.zip");

		if ($zip->open($zipname,\ZipArchive::CREATE)!==TRUE){
			\Doctrine\Common\Util\Debug::dump("Impossible d'ouvrir le fichier");
		}else{
			
			$directory=$this->container->get('kernel')->getRootdir()."/../web".$this->getParameter('app.path.flat_images');
			
			
			
			
			foreach ($entity->getImages() as $key => $value){
				$nom_fichier=$key.'.'.substr($value->getImage(), strpos($value->getImage(), '.') + 1);
				
				if (strcmp(".", $value->getImage())!=0||strcmp("..", $value->getImage())!=0){
					if (!$zip->addFile($directory."/".$value->getImage(),$nom_fichier)){
					}//à faire pour les états des stocks des conso.
				}
			}
			
			
			
			$zip->close();
			ob_end_clean();
			$zip=fopen($zipname, "r");//astuce ici
			$content=stream_get_contents($zip);// et ici
			//application/zip
			return new Response($content, 200, array(
					'Content-Transfert-encoding: binary',
					'Content-Type' => 'application/zip',
					'Content-Disposition' => 'attachment; filename='.$zipname.'',
					'Content-Length: '.filesize($zipname)
			));
		}
		
	}
}
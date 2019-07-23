<?php

namespace AD\CoreBundle\Service;

use AD\CoreBundle\Entity\Flat;
use AD\CoreBundle\Entity\Pension;
use Exception;
use setasign\Fpdi\Fpdi;

class ZipService {
	protected $kernel;
	protected $path;
	
	public function __construct($kernel,$path){
		$this->kernel = $kernel;
		$this->path = $path;
	}
	
	/*
	 *
	 * ############################################################
	 * # GENERATION FOCNTION PDF
	 * ############################################################
	 *
	 */
	public function zipFlatPhotos(Flat $flat) {
		
		ob_start();
		
		$zip=new \ZipArchive();
		$zipname=str_replace(' ','_',$flat->getName()."_fotos.zip");
		$zipname=str_replace(',','_',$zipname);
		$webDir = $this->kernel->getRootdir()."/../web";
		
		if(!file_exists($webDir.'/zip/'.$zipname)){
		
			if ($zip->open('zip/'.$zipname,\ZipArchive::CREATE)!==TRUE){
				\Doctrine\Common\Util\Debug::dump("Impossible d'ouvrir le fichier");
			}else{
				
				$directory=$webDir.$this->path;
				
				
				foreach ($flat->getImages() as $key => $value){
					$nom_fichier=$key.'.'.substr($value->getImage(), strpos($value->getImage(), '.') + 1);
					
					if (strcmp(".", $value->getImage())!=0||strcmp("..", $value->getImage())!=0){
						if (!$zip->addFile($directory."/".$value->getImage(),$nom_fichier)){
						}//à faire pour les états des stocks des conso.
					}
				}
				
				
				
				$zip->close();
				ob_end_clean();
				
				try{
					rename($webDir.'/'.$zipname,$webDir."/zip/".$zipname);
				}catch(Exception $e){
					
				}
			}
		}
		return $zipname;
	}
}
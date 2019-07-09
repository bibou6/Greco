<?php

namespace AD\CoreBundle\Service;

use AD\CoreBundle\Entity\Flat;
use AD\UserBundle\Entity\User;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Environment;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Swift_Attachment;
use setasign\Fpdi\Fpdi;




class MailConstructorService {
	public $translator;
	public $twig;
	public $helper;
	public $webRoot;
	protected $zip;
	protected $mailer;
	
	public function __construct(\Swift_Mailer $mailer,TranslatorInterface $translator, Environment $twig, $rootDir, ZipService $zip) {
		$this->mailer = $mailer;
		$this->translator = $translator;
		$this->twig = $twig;
		$this->zip = $zip;
		
		$this->webRoot = realpath($rootDir . '/../web');
	}

	
	
	public function sendPhotoNewFlat(Flat $flat){
		
		$message = (new \Swift_Message ("Un departamento ha sido agregado !"));
		$message->setFrom ( "no-reply@grecoinmobiliaria.com", "no-reply@grecoinmobiliaria.com" );
		
		$message->addTo("adriendurot3@hotmail.com", "Adrien Durot");
		$message->addTo("gis.greco@gmail.com", "Giselle Durot");
		
		
		//Body
		$message->setBody ( $this->twig->render (
				'CoreBundle:mail:new_flat.html.twig',
				[
						'flat' => $flat
				] ), 'text/html' );
		
		
		$pathToFile = $this->webRoot."/zip/".$this->zip->zipFlatPhotos($flat);;
		$message->attach(Swift_Attachment::fromPath($pathToFile));
		
		
		
		
		
		// Add the pdf part
		return $message;
	}
}
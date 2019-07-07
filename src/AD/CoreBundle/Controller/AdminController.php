<?php

namespace AD\CoreBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use AD\CoreBundle\Entity\Flat;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends BaseAdminController {
	protected function initialize(Request $request) {
		$this->get ( 'translator' )->setLocale ( 'es' );
		parent::initialize ( $request );
	}
	public function zipPhotosAction() {
		$id = $this->request->query->get ( 'id' );
		$entity = $this->em->getRepository ( 'CoreBundle:Flat' )->find ( $id );

		$zipname = $this->container->get ( 'core_bundle.zip' )->zipFlatPhotos ( $entity );

		$zip = fopen ( 'zip/' . $zipname, "r" ); // astuce ici
		$content = stream_get_contents ( $zip ); // et ici
		                                         // application/zip
		return new Response ( $content, 200, array (
				'Content-Transfert-encoding: binary',
				'Content-Type' => 'application/zip',
				'Content-Disposition' => 'attachment; filename=' . $zipname . '',
				'Content-Length: ' . filesize ( 'zip/' . $zipname )
		) );
	}
	public function validateFlatAction() {
		$id = $this->request->query->get ( 'id' );
		$entity = $this->em->getRepository ( 'CoreBundle:Flat' )->find ( $id );

		$mail = $this->container->get ( 'core_bundle.mail' )->sendPhotoNewFlat ( $entity );

		if ($this->get ( 'mailer' )->send ( $mail )) {
			$this->addFlash ( "success", "La propiedad " . $entity->getName () . " ha sido validada !" );
		} else {
			$this->addFlash ( "danger", "Un error occurio :S" );
		}

		return $this->redirectToRoute ( 'easyadmin', array (
				'action' => 'list',
				'entity' => 'FlatActivated',
				'id' => $entity->getId ()
		) );
	}
	
}
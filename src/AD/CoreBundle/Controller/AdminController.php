<?php

namespace AD\CoreBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends BaseAdminController
{
	protected function initialize(Request $request)
	{
		$this->get('translator')->setLocale('es');
		parent::initialize($request);
	}
}
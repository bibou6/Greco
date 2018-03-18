<?php

namespace AD\CoreBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
	protected function initialize(Request $request)
	{
		$this->get('translator')->setLocale('fr');
		parent::initialize($request);
	}
}
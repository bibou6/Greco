<?php

namespace AD\PensionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PensionBundle:Default:index.html.twig');
    }
}

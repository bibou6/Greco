<?php

namespace AD\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function accountAction()
    {

    	$user = $this->getUser();
    	
        return $this->render('UserBundle::my-account.html.twig', array("user"=>$user));
        
    }
}

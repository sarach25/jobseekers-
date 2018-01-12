<?php

namespace MyApp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
       return $this->render('MyAppUserBundle:Default:index.html.twig');
    }
    public function mmAction()
    {
        return $this->render('MyAppUserBundle:Default:membre.html.twig');
    }
    public function payAction()
    {
        return $this->render('MyAppUserBundle:Profile:layoutpayement.html.twig');
    }

}

<?php

namespace RegistreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RegistreBundle:Default:index.html.twig');
    }
}

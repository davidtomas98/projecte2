<?php
namespace RegistreBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RegistreBundle\Entity\User;
use RegistreBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Session\Session;
class CdrController extends Controller
{   
    
    public function entradesAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT e FROM RegistreBundle:Cdr e";
        $query = $em->createQuery($dql);
 
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                15
        );
 
        return $this->render('RegistreBundle:Cdr:index.html.twig',array
		('pagination' => $pagination
	));
    }


}
                
                    

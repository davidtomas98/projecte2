<?php
namespace RegistreBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RegistreBundle\Entity\User;
use RegistreBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Session\Session;
class UserController extends Controller
{   
    private $session;
	
    public function __construct() {
	$this->session=new Session();
    }
   
    public function loginAction(Request $request){
		$authenticationUtils = $this->get("security.authentication_utils");
		$error = $authenticationUtils->getLastAuthenticationError();
		$lastUsername = $authenticationUtils->getLastUsername();
                
                $user = new User();
		$form = $this->createForm(UserType::class,$user);
		
                    $em=$this->getDoctrine()->getEntityManager();
                    $user_repo=$em->getRepository("RegistreBundle:User");
                    $user = $user_repo->findOneBy(array("usuari"=>$form->get("usuari")->getData()));
                    
                
		return $this->render("RegistreBundle:User:login.html.twig", array(
			"error" => $error,
			"lastUsername" => $lastUsername,
                        "form" => $form->createView()
		)); 
	}
}            
                    

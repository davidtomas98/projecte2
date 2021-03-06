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
		
		$form->handleRequest($request);
                if($form->isValid()){
                    $em=$this->getDoctrine()->getEntityManager();
                    $user_repo=$em->getRepository("RegistreBundle:User");
                    $user = $user_repo->findOneBy(array("email"=>$form->get("email")->getData()));
				
                    if(count($user)==0){
                        $user = new User();
                        $user->setName($form->get("name")->getData());
                        $user->setSurname($form->get("surname")->getData());
                        $user->setEmail($form->get("email")->getData());
                        $factory = $this->get("security.encoder_factory");
                        $encoder = $factory->getEncoder($user);
                        $password = $encoder->encodePassword($form->get("password")->getData(), $user->getSalt());
                        $user->setPassword($password);
                        $user->setRole("ROLE_USER");
                        $em = $this->getDoctrine()->getEntityManager();
                        $em->persist($user);
                        $flush = $em->flush();
                        if($flush==null){
                            $status = "Usuari creat correctame		nt";
                        }else{
                            $status = "Alguna cosa ha fallat. Torna-ho a intentar";
                        }
                    //}else{
                        //$status = "No te has registrado correctamente";
                        $this->session->getFlashBag()->add("status",$status);
                    }
                    else{
                        $status = "Aquest usuari ja existeix";
                        $this->session->getFlashBag()->add("status",$status);
                    }
		}
                
                
		return $this->render("RegistreBundle:User:login.html.twig", array(
			"error" => $error,
			"lastUsername" => $lastUsername,
                        "form" => $form->createView()
		)); 
	}
}            
                    

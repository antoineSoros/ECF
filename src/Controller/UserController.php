<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController 
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/login", name="login")
     */
    public function logIn(Request $req, UserRepository $userRepo, UserPasswordEncoderInterface $encode){
         
        $dto= new User();
            $form = $this->createForm(\App\Form\UserLogInType::class,$dto);
        $form->handleRequest($req);
      
      
         if ($form->isSubmitted() && $form->isValid()) {
          
          $login=$userRepo->findBy(['userName'=>$dto->getUserName()
              ]);
          
          if(count($login)!=0){
          
             if($encode->isPasswordValid($login[0], $dto->getPassword())){
             $req->getSession()->set("userName", $dto->getUserName());
             }
         }
         return $this->redirectToRoute('home');
         }
        return $this->render('user/login.html.twig',["loginForm"=>$form->createView()]);
    }
    /**
     * 
     * @Route("/signup", name="signup")
     */
    public function signUp(Request $req,UserPasswordEncoderInterface $encode){
        
         $dto= new User();
            $form = $this->createForm(\App\Form\UserSignUpType::class,$dto);
           
        $form->handleRequest($req);
          if ($form->isSubmitted() && $form->isValid()) {
               $password = $encode->encodePassword($dto, $dto->getUserPassword());
            $dto->setUserPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dto);
            $entityManager->flush();
             $req->getSession()->set("userName", $dto->getUserName());

            return $this->redirectToRoute('home');
        }
        return $this->render('user/signup.html.twig',["signUpForm"=>$form->createView()]);
    }
    /**
     * 
     *@Route("/logout", name="logout")
     */
    public function logOut(Request $req){
         $req->getSession()->invalidate();
        return $this->redirectToRoute('home');
    }


}

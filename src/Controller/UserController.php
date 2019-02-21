<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;

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
    public function logIn(Request $req, UserRepository $userRepo){
         
        $dto= new User();
            $form = $this->createForm(\App\Form\UserLogInType::class,$dto);
        $form->handleRequest($req);
         if ($form->isSubmitted() && $form->isValid()) {
          $userRepo->findBy(['user_name'=>$dto->getUserName(),])
          
             
            $req->getSession()->set("userName", $dto->getUserName()); 
         }
        return $this->render('user/login.html.twig',["loginForm"=>$form->createView()]);
    }
    /**
     * 
     * @Route("/signup", name="signup")
     */
    public function signUp(Request $req){
        
         $dto= new User();
            $form = $this->createForm(\App\Form\UserSignUpType::class,$dto);
        $form->handleRequest($req);
          if ($form->isSubmitted() && $form->isValid()) {
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

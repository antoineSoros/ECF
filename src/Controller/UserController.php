<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

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
    public function login(Request $req){
         
        $dto= new User();
            $form = $this->createForm(\App\Form\UserLogInType::class,$dto);
        $form->handleRequest($req);
        return $this->render('user/login.html.twig',["loginForm"=>$form->createView()]);
    }
}

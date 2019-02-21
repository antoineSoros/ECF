<?php

namespace App\Controller;

use App\Entity\SecureUser;
use App\Form\SecureUserType;
use App\Repository\SecureUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/secure/user")
 */
class SecureUserController extends AbstractController
{
    /**
     * @Route("/", name="secure_user_index", methods={"GET"})
     */
    public function index(SecureUserRepository $secureUserRepository): Response
    {
        return $this->render('secure_user/index.html.twig', [
            'secure_users' => $secureUserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="secure_user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $secureUser = new SecureUser();
        $form = $this->createForm(SecureUserType::class, $secureUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($secureUser);
            $entityManager->flush();

            return $this->redirectToRoute('secure_user_index');
        }

        return $this->render('secure_user/new.html.twig', [
            'secure_user' => $secureUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="secure_user_show", methods={"GET"})
     */
    public function show(SecureUser $secureUser): Response
    {
        return $this->render('secure_user/show.html.twig', [
            'secure_user' => $secureUser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="secure_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SecureUser $secureUser): Response
    {
        $form = $this->createForm(SecureUserType::class, $secureUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('secure_user_index', [
                'id' => $secureUser->getId(),
            ]);
        }

        return $this->render('secure_user/edit.html.twig', [
            'secure_user' => $secureUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="secure_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SecureUser $secureUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$secureUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($secureUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('secure_user_index');
    }
}

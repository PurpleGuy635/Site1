<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class ListeUserController extends AbstractController
{
    #[Route('/liste-user', name: 'liste_user')]
    public function index(): Response
    {
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $users = $repoUser->findAll();

        return $this->render('liste_user/liste-user.html.twig', [
            'users' => $users
        ]);
    }
}

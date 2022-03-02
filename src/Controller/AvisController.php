<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Avis;

class AvisController extends AbstractController
{
    #[Route('/liste-avis', name: 'liste-avis')]
    public function listeAvis(): Response
    {

        $repoAvis = $this->getDoctrine()->getRepository(Avis::class);
        $avis = $repoAvis->findAll();

        return $this->render('avis/liste-avis.html.twig', [
            'controller_name' => 'AvisController',
            'avis' => $avis
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/accueil.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[Route('/bureau', name: 'app_bureau')]
    public function bureau(): Response
    {
        return $this->render('accueil/bureau.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[Route('/etage1', name: 'etage')]
    public function etageun(): Response
    {
        return $this->render('accueil/etage1.html.twig');
    }

    #[Route('/carteAfrique', name: 'carte')]
    public function carteA(): Response
    {
        return $this->render('accueil/carteAfrique.html.twig');
    }

    #[Route('/color', name: 'color')]
    public function color(): Response
    {
        return $this->render('accueil/color.html.twig');
    }
}

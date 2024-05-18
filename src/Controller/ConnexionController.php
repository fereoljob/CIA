<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConnexionController extends AbstractController
{
    #[Route('/connexion', name: 'app_connexion')]
    public function connexion(Request $request): Response
    {
        $admin = new Admin();
        $fom = $this->createForm(AdminFormType::class);
        $fom->handleRequest($request);
        if($fom->isSubmitted() && $fom->isValid()){
            return $this->redirectToRoute('app_search');
        }
        return $this->render('connexion/connexion.html.twig', [
            'controller_name' => 'ConnexionController',
            'form' => $fom
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BureauController extends AbstractController
{
    #[Route('/bureau/{num_bureau}', name: 'app_info_bureau')]
    public function infoBureau(): Response
    {
        return $this->render('bureau/index.html.twig', [
            'controller_name' => 'BureauController',
        ]);
    }
}

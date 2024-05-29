<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Bureau;
use App\Entity\Personnel;

class AdministrationController extends AbstractController
{
    #[Route('/administration', name: 'app_administration')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {

        $bureaux = $em->getRepository(Bureau::class)->findAll();       
        return $this->render('administration/administration.html.twig', [
            'controller_name' => 'AdministrationController',
            'bureaux' => $bureaux,
        ]);
    }
    #[Route('administration/infoBureau', name:'app_admin_dispo_bureau')]
    public function displayBureauCapacity(Request $request, EntityManagerInterface $em): Response
    {
        $id = $request->get('bureau');
        $bureaux = $em->getRepository(Bureau::class)->findAll();
        $bureau = $em->getRepository(Bureau::class)->find($id);
        $capacityMax = $bureau->getCapaciteMax();
        $total = $em->getRepository(Personnel::class)->findTotalPersonnelByBureau($id);
        $total = $total[0]['total'];
        $numBureau = $bureau->getNumBureau();
        return $this->render('administration/administration.html.twig', [
            'controller_name' => 'AdministrationController',
            'bureauInfo' => $numBureau,
            'capaciteMax'=> $capacityMax,
            'nbreTotal'=> $total,
            'bureaux' => $bureaux,
        ]);

    }
}

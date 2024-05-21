<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PersonnelRepository;
use DateTime;
use App\Entity\Personnel;

class AccueilController extends AbstractController
{
    private $personnelRepository;

    public function __construct(PersonnelRepository $personnelRepository){
        $this->personnelRepository = $personnelRepository;
    }

    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/accueil.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[Route('/etage1/bureau/{id}', name: 'etage')]
    public function getBureauInfo(string $id): JsonResponse {
      $personnes = $this ->personnelRepository->findBy(['bureau' => $id]);
 
      /*
      $donneesPersonne = [
        ['nom' => 'Doe', 'prenom' => 'John', 'statut' => 'Doctorant', 'dateStart' => new DateTime('2023-01-01'), 'dateEnd' => null],
        ['nom' => 'Smith', 'prenom' => 'Jane', 'statut' => 'Doctorant', 'dateStart' => new DateTime('2022-06-15'), 'dateEnd' => new DateTime('2023-12-31')],
        
    ];

    $personnes = [];
    foreach ($donneesPersonne as $donnees) {
        $personne = new Personnel();
        $personne->setNom($donnees['nom']);
        $personne->setPrenom($donnees['prenom']);
   //     $personne->setStatut($donnees['statut']);
        $personne->setDateStart($donnees['dateStart']);
        $personne->setDateEnd($donnees['dateEnd']);
        
        $personnes[] = $personne;
    }
    */
         $data = [];
 
         foreach ($personnes as $personne) {
             $data[] = [
                 'nom' => $personne->getNom(),
                 'prenom' => $personne->getPrenom(),
                 'statut' => $personne->getStatut(),
                 'dateStart' => $personne->getDateStart('Y-m-d H:i:s'),
                 'dateEnd' => $personne->getDateEnd() ? $personne->getDateEnd()->format('Y-m-d H:i:s') : '',
             ];
         }
 
         return new JsonResponse($data);
     }
}

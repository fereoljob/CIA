<?php

namespace App\Controller;

use App\Repository\PersonnelRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class TriListController extends AbstractController
{
    #[Route('/Pers', name: 'app_listUser')]
    public function listPersonne(Request $request, PersonnelRepository $repository,PaginatorInterface $paginator): Response
    {
         $filterType = $request->request->get('filterType');
         $orderBy = $request->request->get('orderBy');
         $result = [];
         $error = null;
         if ($request->isMethod('POST')) {
             if (empty($filterType) || empty($orderBy)) {
                 $error = "Veillez selectionnner un type ";

             } else {

                 if ($filterType === 'personnes') {
                     $result = $repository->listPersonnelOdered($orderBy);
                 } else if ($filterType === 'bureauPersonne') {
                     $result = $repository->listPersonnelGroupedByBureau($orderBy);
                 } else if ($filterType === 'dateEndPersonne') {
                     $result = $repository->listPersonnelOrderedByDateEnd($orderBy);
                 } else {
                     $result = $repository->findAll();
                 }
             }
         }
         else {
             $result = $repository->findAll();
         }
        // $personnes = $repository->listPersonnel();

        $pagination = $paginator->paginate(
            $result,
            $request->query->getInt('page', 1),
            5/*limit per page*/
        );
        return $this->render('trilist/triListPersonnel.html.twig', [
            'personnes' => $pagination,
            'filterType' => $filterType,
            'orderBy' => $orderBy,
            'pagination' => $pagination,
            'error' => $error,
        ]);
    }


/*
    #[Route('/Bureau', name: 'app_listBureau')]
    public function listBureau(PersonnelRepository $repository): Response
    {
        $groupedByBureau = $repository->listPersonnelGroupedByBureau();
        return $this->render('tri_list/listBureau.html.twig', [
            'groupedByBureau' => $groupedByBureau,
        ]);
    }

    #[Route('/Pers', name: 'app_listUser')]
    public function listPersonneOrderedByDate(Request $request ,PersonnelRepository $repository): Response
    {
        $form = $this->createForm(FilterType::class);
        $form->handleRequest($request);
        $orderededByDateEnd= $repository->listPersonnelOrderedByDateEnd();
        return $this->render('tri_list/listPersonnel.html.twig', [
            'orderededByDateEnd' => $orderededByDateEnd,
            'form' => $form->createView(),
        ]);
    }

*/


}

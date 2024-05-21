<?php

namespace App\Controller;

use App\Form\StatutType;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Statut;


class AdminStatutController extends AbstractController
{
    #[Route('/admin/statut/add', name: 'admin_add_statut')]
    public function ajouter(Request $request,EntityManagerInterface $em): Response
    {
        $statut = new Statut();
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($statut);
            $em->flush();
            $this->addFlash('success','Ajout reussi!');
            return $this->redirectToRoute('app_administration');   
        }

        return $this->render('administration/statutAdministration/ajout.html.twig', [
            'controller_name' => 'AdminStatutController','form'=> $form
        ]);
    }
    #[Route('/admin/selectstatut', name:'admin_select_statut')]
    public function select(StatutRepository $statutRepository, EntityManagerInterface $em): Response
    {
        $statuts = $statutRepository->findAll();
        return $this->render('administration/statutAdministration/select.html.twig',['statuts'=> $statuts]);
    }
    #[Route('/admin/modifystatut/', name:'admin_modify_statut')]
    public function modify(Request $request, EntityManagerInterface $em): Response
    {
        $id = $request->query->get('statut');
        $statut = $em->getRepository(Statut::class)->find($id);
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success','Modification reussie!');
            return $this->redirectToRoute('app_administration');
        }
        return $this->render('administration/statutAdministration/modify.html.twig', [
            'controller_name' => 'AdminStatutController','form'=> $form
        ]);
    }
}

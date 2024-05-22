<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Personnel;
use App\Form\PersonnelType;

class AdminPersonnelController extends AbstractController
{
    #[Route('/admin/personnel/add', name: 'admin_add_personnel')]
    public function ajouter(Request $request,EntityManagerInterface $em): Response
    {
        $personnel = new Personnel();
        $form = $this->createForm(PersonnelType::class, $personnel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($personnel);
            $em->flush();
            $this->addFlash('success','Ajout reussi!');
            return $this->redirectToRoute('app_administration');   
        }

        return $this->render('administration/personnelAdministration/ajout.html.twig', [
            'controller_name' => 'AdminPersonnelController','form'=> $form
        ]);
    }
    #[Route('/admin/personnel/{id}/edit', name:'admin_edit_personnel')]
    public function modify(Personnel $personnel,Request $request,EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PersonnelType::class, $personnel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($personnel);
            $em->flush();
            $this->addFlash('success','Modification reussie!');
            return $this->redirectToRoute('app_administration');   
        }

        return $this->render('administration/personnelAdministration/modify.html.twig', [
            'controller_name' => 'AdminPersonnelController','form'=> $form
        ]);

    }
    #[Route('/admin/personnel/{id}/', name:'admin_delete_personnel')]
    public function delete(Personnel $personnel, Request $request, EntityManagerInterface $em): Response
    {
        $em->remove($personnel);
        $em->flush();
        $this->addFlash('success','Suppression reussie');
        return $this->redirectToRoute('app_administration');
    }
}

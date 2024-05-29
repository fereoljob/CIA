<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Personnel;
use App\Form\PersonnelType;
use App\Entity\Bureau;

class AdminPersonnelController extends AbstractController
{
    #[Route('/admin/personnel/add', name: 'admin_add_personnel')]
    public function ajouter(Request $request,EntityManagerInterface $em): Response
    {
        $personnel = new Personnel();
        $form = $this->createForm(PersonnelType::class, $personnel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($personnel->getDateStart() > $personnel->getDateEnd()) {
                $this->addFlash('notice',"La date de départ ne doit pas être inférieure à la date d'arrivée" );
                $form = $this->createForm(PersonnelType::class,$personnel);
                return $this->render('administration/personnelAdministration/ajout.html.twig', [
                    'controller_name' => 'AdminPersonnelController','form'=> $form
                ]);

            }else{
                $total = $em->getRepository(Personnel::class)->findTotalPersonnelByBureau($personnel->getBureau()->getId());
                $total = $total[0]['total'];
                $capacitebureau = ($em->getRepository(Bureau::class)->findBy(['id'=>$personnel->getBureau()->getId()])[0])->getCapaciteMax();
                if($total < $capacitebureau){
                    $em->persist($personnel);
                    $em->flush();  
                    $this->addFlash('success','Ajout reussi!');
                    return $this->redirectToRoute('app_administration'); 
                }else{
                    $this->addFlash('notice','Echec: Capacité max bureau atteinte !');
                    return $this->redirectToRoute('app_administration');   
                }
            }
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
            if($personnel->getDateStart() > $personnel->getDateEnd()) {
                $this->addFlash('notice',"La date de départ ne doit pas être inférieure à la date d'arrivée" );
                $form = $this->createForm(PersonnelType::class,$personnel);
                return $this->render('administration/personnelAdministration/modify.html.twig', [
                    'controller_name' => 'AdminPersonnelController','form'=> $form
                ]);

            }else{
                $total = $em->getRepository(Personnel::class)->findTotalPersonnelByBureau($personnel->getBureau()->getId());
                $total = $total[0]['total'];
                $capacitebureau = ($em->getRepository(Bureau::class)->findBy(['id'=>$personnel->getBureau()->getId()])[0])->getCapaciteMax();
                if($total < $capacitebureau){
                    $em->persist($personnel);
                    $em->flush();  
                    $this->addFlash('success','Modification reussie!');
                    return $this->redirectToRoute('app_administration'); 
                }else{
                    $this->addFlash('notice','Echec: Capacité max bureau atteinte !');
                    return $this->redirectToRoute('app_administration');   
                }
            }
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

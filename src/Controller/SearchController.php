<?php

namespace App\Controller;

use App\Repository\PersonnelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search(Request $request, PersonnelRepository $repository): Response
    {
        $search = $request->query->get('search', '');
        $users = $repository->searchUser($search);

        return $this->render('search/search.html.twig', [
            'users' => $users,
        ]);
    }


}

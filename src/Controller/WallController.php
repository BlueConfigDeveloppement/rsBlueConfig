<?php

namespace App\Controller;

use App\Repository\UserProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WallController extends AbstractController
{
    #[Route('/wall', name: 'wall')]
    public function index(UserProfilRepository $userProfilRepository): Response
    {

        return $this->render('wall/index.html.twig', [
            'user_profils' => $userProfilRepository->findAll(),
        ]);
    }
}

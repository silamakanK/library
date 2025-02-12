<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class lastAdminController extends AbstractController
{
    #[Route('/lastadmin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('lastadmin/index.html.twig', [
            'controller_name' => 'lastAdminController',
        ]);
    }

    #[Route('/lastadmin/user', name: 'app_admin_user')]
    public function showUser(UserRepository $userRepository): Response
    {
        return $this->render('lastadmin/show_user.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}

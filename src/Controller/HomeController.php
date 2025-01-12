<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(BookRepository $bookRepository): Response
    {

//        $books = $bookRepository->findAll();
        return $this->render('home.html.twig', [
            'controller_name' => 'HomeController',
//            'books' => $books,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('main/index.html.twig');
    }

    public function dropdownCategories(CategoryRepository $categoryRepository): Response
    {
        return $this->render('main/_dropdownCategories.html.twig', [
            'categories' => $categoryRepository->findAll()
        ]);
    }
}

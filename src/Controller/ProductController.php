<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/product', name: 'app_list_product')]
    public function listProducts(): Response
    {
        $title = 'Liste des produits';

        return $this->render('product/listProducts.html.twig', [
            'title' => $title,
        ]);
    }

    #[Route('/product/{id}', name: 'app_view_product')]
    public function viewProduct(int $id): Response
    {
        return $this->render('product/viewProducts.html.twig', [
            'id' => $id,
        ]);
    }
}

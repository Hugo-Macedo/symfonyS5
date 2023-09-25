<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Slugify;

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
    #[Route('/product/slug', name: 'app_slug_product')]
    public function slugProducts(Slugify $slugify): Response
    {
        $texte = $slugify->generateSlug('(Voici une phrase en français)');
        dd($texte);
        return $this->render('product/slugProducts.html.twig', [
            'texte' => $texte,
        ]);
    }

    #[Route('/product/{id</d+>}', name: 'app_view_product')]
    public function viewProduct(int $id): Response
    {
        return $this->render('product/viewProducts.html.twig', [
            'id' => $id,
        ]);
    }

    
}

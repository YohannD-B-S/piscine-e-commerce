<?php

namespace App\Controller\guest;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController{

    #[Route('/products', name: 'products')]
    public function displayProduct(ProductRepository $productRepository){

        $productPublished=$productRepository->findAll();

        return $this->render('guest/products/list-products.html.twig', [
            'products' => $productPublished,
        ]);
        

    }

    #[Route('/details-product/{id}', name: 'product')]
    public function displayProductById(ProductRepository $productRepository, $id){

        $product=$productRepository->find($id);

        return $this->render('guest/products/details-product.html.twig', [
            'product' => $product,
        ]);
    }
}
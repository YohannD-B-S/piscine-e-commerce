<?php

namespace App\Controller\guest;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController{

    #[Route('/products', name: 'products')]
    public function displayProduct(ProductRepository $productRepository):Response{

        $productPublished=$productRepository->findAll();

        return $this->render('guest/products/list-products.html.twig', [
            'products' => $productPublished,
        ]);
        

    }

    #[Route('/details-product/{id}', name: 'product')]
    public function displayProductById(ProductRepository $productRepository,int $id):Response{


        

        $product=$productRepository->find(id: $id);
        
       if (!$product){
            return $this->redirectToRoute('guest_404');
       }
       

        return $this->render('guest/products/details-product.html.twig', [
            'product' => $product,
        ]);
    }
}

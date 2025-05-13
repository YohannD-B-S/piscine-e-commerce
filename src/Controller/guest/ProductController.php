<?php

namespace App\Controller\guest;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController{

    #[Route('/products', name: 'products', methods: ['GET'])]
    public function displayProduct(ProductRepository $productRepository):Response{

        $productPublished=$productRepository->findAll();

        return $this->render('guest/products/list-products.html.twig', [
            'products' => $productPublished,
        ]);
        

    }

    #[Route('/details-product/{id}', name: 'product', methods: ['GET'])]
    public function displayProductById(ProductRepository $productRepository,int $id):Response{


        

        $product=$productRepository->find(id: $id);
        
       if (!$product){
            return $this->redirectToRoute('guest_404');
       }
       

        return $this->render('guest/products/details-product.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route(path: '/resultats-recherche', name:'product-search-results', methods: ['GET'])]
	public function displayResultsSearchProducts(Request $request, ProductRepository $productRepository) {
        
        $search = $request->query->get('search');
		
		$productFound= $productRepository->findByTitleContain($search);

        dd($productFound);

		
    }
}

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

#[Route(path: '/resultats-recherche', name:'product-search-results', methods: ['GET'])] // Déclare une route accessible via une requête GET à l'URL "/resultats-recherche"

public function displayResultsSearchProducts(Request $request, ProductRepository $productRepository) { // Fonction pour afficher les résultats de la recherche

    $search = $request->query->get('search'); // Récupère le paramètre "search" depuis l'URL

    $productsFound = $productRepository->findByTitleContain($search); // Recherche dans la base de données les produits dont le titre contient la valeur de $search

    return $this->render('guest/products/search-results.html.twig', [ // Rend la vue "search-results.html.twig"
        'search' => $search, // Transmet le terme recherché à la vue
        'productsFound' => $productsFound // Transmet la liste des produits trouvés à la vue
    ]);
}
}


<?php

namespace App\Controller\admin;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductsController extends AbstractController
{

    #[Route('/admin/create-product', name: 'admin-create-product', methods: ['GET', 'POST'])]
    public function displayCreateProduct(CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $entityManager ):Response{

        if ($request->isMethod('POST')){
            $title=$request->request->get('title');
            $description=$request->request->get('description');
            $price=$request->request->get('price');
            $categoryId=$request->request->get('category-id');
            // 'category-id' est le name de l'input select dans le formulaire
            //on récupère la valeur de l'input select dans le formulaire

            if ($request->request->get('isPublished')==='on'){
                $isPublished=true;
            } else{
                $isPublished=false;
            };



            $category=$categoryRepository->find($categoryId);

            try {
				$product = new Product($title, $description, $price, $isPublished, $category);

				$entityManager->persist($product);
				$entityManager->flush();
                $this->addFlash('success', 'Produit créé !');
			} catch (\Exception $exception) {
				$this->addFlash('error', $exception->getMessage());
			}

        }

        $categories=$categoryRepository->findAll();
        return $this->render('admin/products/create-product.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/admin/list-products', name: 'admin-list-products', methods: ['GET'])]
	public function displayListProducts(ProductRepository $productRepository):Response {

		$products = $productRepository->findAll();

		return $this->render('admin/products/list-products.html.twig', [
			'products' => $products
		]);
	}

    
	#[Route('/admin/delete-product/{id}', name:'admin-delete-product', methods: ['GET', 'POST'])]
	public function deleteProduct($id, ProductRepository $productRepository, EntityManagerInterface $entityManager):Response{

        $product=$productRepository->find($id);

        if (!$product){
            return $this->redirectToRoute('admin_404');
        }
      try {
			$entityManager->remove($product);
			$entityManager->flush();

			$this->addFlash('success', 'Produit supprimé !');

		} catch(Exception $exception) {

			$this->addFlash('error', 'Impossible de supprimer le produit');
		}

		return $this->redirectToRoute('admin-list-products');
	}

    
	#[Route('/admin/update-product/{id}', name: 'admin-update-product', methods: ['GET', 'POST'])]
	public function displayUpdateProduct($id, ProductRepository $productRepository, CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $entityManager):RedirectResponse|Response {

		$product = $productRepository->find($id);

            if (!$product){
            return $this->redirectToRoute('admin_404');
        }

        if ($request->isMethod('POST')) {
            $title = $request->request->get('title');
            $description = $request->request->get('description');
            $price = $request->request->get('price');
            $categoryId = $request->request->get('category-id');

            if ($request->request->get('isPublished') === 'on') {
                $isPublished = true;
            } else {
                $isPublished = false;
            }

            $category = $categoryRepository->find($categoryId);

            // on peut ecrre les proprité dans le controller
            //ce qui implique de ne pas utiliser le constructeur
            // et de tout écrire dans le controller :

            //$product->setTitle($title);
            //$product->setDescription($description);
            //$product->setPrice($price);
            //$product->setIsPublished($isPublished);
            //$product->setCategory($category);
            //$product->setUpdatedAt(new \DateTime());

            // ou on peut utiliser le constructeur de l'entity Product
            // la function update est dans l'entity Product
            // et on l'appel ici dans le controller.

            	try {
				$product->update($title, $description, $price, $isPublished, $category);	

				$entityManager->persist($product);
				$entityManager->flush();
                $this->addFlash('success', 'Le produit a bien été modifié');
			} catch (\Exception $exception) {
				$this->addFlash('error', $exception->getMessage());
			}

        }

		$categories = $categoryRepository->findAll();

		return $this->render('admin/products/update-product.html.twig', [
			'categories' => $categories,
			'product' => $product
		]);
	}




}
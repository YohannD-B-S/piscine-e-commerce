<?php

namespace App\Controller\guest;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController{


    #[Route('/categories', name: 'categories', methods: ['GET'])]
         public function displayCategory(CategoryRepository $categoryRepository):Response {
    
        $category=$categoryRepository->findAll();
    
            return $this->render('guest/categories/list-categories.html.twig', [
                'categories' => $category,
            ]);
        }

        #[Route('/details-category/{id}', name: 'category', methods: ['GET'])]         
        public function displayCategoryById(CategoryRepository $categoryRepository, int $id):Response{
    
            $category=$categoryRepository->find($id);

              if (!$category){
            return $this->redirectToRoute('guest_404');
       }
    
            return $this->render('guest/categories/details-category.html.twig', [
                'category' => $category,
            ]);
        }
}
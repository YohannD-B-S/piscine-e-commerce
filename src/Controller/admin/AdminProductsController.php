<?php

namespace App\Controller\admin;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductsController extends AbstractController
{

    #[Route('/admin/create-product', name: 'admin-create-product')]
    public function displayCreateProduct(CategoryRepository $categoryRepository, Request $request){

        if ($request->isMethod('POST')){
            $title=$request->request->get('title');
            $description=$request->request->get('description');
            $price=$request->request->get('price');
            $categoryId=$request->request->get('categoryId');

            if ($request->request->get('isPublished')==='on'){
                $isPublished=true;
            } else{
                $isPublished=false;
            };

            dump($title, $description, $price, $isPublished, $categoryId);die;

        }

        $categories=$categoryRepository->findAll();
        return $this->render('admin/products/create-product.html.twig', [
            'categories' => $categories,
        ]);
    }



}
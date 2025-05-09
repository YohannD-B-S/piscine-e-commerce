<?php

namespace App\Controller\admin;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductsController extends AbstractController
{

    #[Route('/admin/create-product', name: 'admin-create-product')]
    public function displayCreateProduct(CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $entityManager){

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

            //on créé une instance Poduct lié au construct de l'entity Product
            //on lui passe les valeurs récupérées dans le formulaire
            $product= new Product($title, $description, $price, $isPublished, $category);
            
            //persist permet de dire à Doctrine que l'on veut sauvegarder l'entité dans la base de données
            //flush permet d'exécuter la requête SQL pour insérer l'entité dans la base de données
            $entityManager->persist($product);
            $entityManager->flush();

        }

        $categories=$categoryRepository->findAll();
        return $this->render('admin/products/create-product.html.twig', [
            'categories' => $categories,
        ]);
    }



}
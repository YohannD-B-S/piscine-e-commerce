<?php

namespace App\Controller\admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{


    #[Route('/admin/create-admin', name: 'admin-create-admin')]
    public function displayCreateUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
if ($request->isMethod('POST')) { // Vérifie si la requête est de type POST
            $email = $request->request->get('email'); // Récupère l'email depuis la requête
            $password = $request->request->get(key: 'password'); // Récupère le mot de passe depuis la requête
            
            $user = new User(); // Crée une nouvelle instance de l'utilisateur
            
            $passwordHashed = $userPasswordHasher->hashPassword($user, $password); // Hashage du mot de passe pour la sécurité
            
            $user->createAdmin($email, $passwordHashed); // Crée un administrateur avec l'email et le mot de passe sécurisé
            
            $entityManager->persist($user); // Prépare l’utilisateur pour l’enregistrement en base de données
            $entityManager->flush(); // Sauvegarde les modifications dans la base de données
            
            $this->addFlash('success','Admin créé'); // Ajoute un message flash pour informer que l’admin a été créé
        } // Fin du bloc conditionnel

        return $this->render('/admin/user/create-user.html.twig'); // Affiche la page de création d’utilisateur
    } // Fin de la méthode
} // Fin de la classe
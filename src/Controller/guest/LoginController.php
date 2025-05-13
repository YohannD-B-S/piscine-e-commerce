<?php

namespace App\Controller\guest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController

{
    #[Route('/login', name: 'login')]
    public function displayLogin(AuthenticationUtils $authentication):Response
    {
         

        return $this->render('guest/login.html.twig');
    }

    #[Route('/logout', name: 'logout')]
    public function displayLogout(){


    }

}
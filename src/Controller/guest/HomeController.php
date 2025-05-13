<?php


namespace App\Controller\guest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{

    #[Route('/', name: 'home', methods: ['GET'])]
    public function displayHome(){
       return $this->render('guest/home.html.twig', [
        ]);
    }

   #[Route('/guest/404', name: 'guest_404', methods: ['GET'])]
	public function displayAdmin404():Response
	{
		$html = $this->renderView('guest/404.html.twig');
		
		return new Response($html, '404');
	}

}
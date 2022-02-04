<?php

namespace App\Controller;

use DateTime;
use App\Repository\DishRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function homePage(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            
        ]);
    }
    #[Route('/cgu', name: 'cgu')]
    public function cgu(){
        
        return $this->render('home/cgu.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

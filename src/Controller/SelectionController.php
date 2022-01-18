<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\DishRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SelectionController extends AbstractController
{
    #[Route('/selection', name: 'selection')]
    public function selection(DishRepository $dishRespository, CategoryRepository $catRepo, Request $request): Response
    {
        $limit = 9;

        $page = (int)$request->query->get('page', 1);

        $filters = $request->get("category");
        
        $dishes = $dishRespository->getPaginatedDishes($page, $limit, $filters);

        $total = $dishRespository->getTotalDishes($filters);

        $categories = $catRepo->findAll();
        
        if($request->get("ajax")){
            return new JsonResponse([
                'content' => $this->renderView('selection/content.html.twig', compact('dishes', 'limit', 'page','total'))
            ]);
        }

        return $this->render('selection/index.html.twig', compact('dishes', 'limit', 'page','total', 'categories'));
    }
}

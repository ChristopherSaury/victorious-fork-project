<?php

namespace App\Controller\Admin;

use App\Entity\Dishes;
use App\Form\DishType;
use App\Repository\DishesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DishController extends AbstractController
{
    #[Route('/admin/dish', name: 'all_dish')]
    public function retrieveDish(DishesRepository $dishes): Response
    {
        $dishes = $dishes->findAll();
        return $this->render('admin/dish/dish-list.html.twig', [
            'controller_name' => 'AdminController',
            'dishes' => $dishes,
        ]);
    }
    #[Route('/admin/dish/new', name: 'add_dish')]
    public function addDish(EntityManagerInterface $em, Request $request){
        $dish = new Dishes;
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $dish->setActive(true);
            $em->persist($dish);
            $em->flush();

            return $this->redirectToRoute('all_dish');
        }else{
            return $this->render('admin/dish/add.html.twig',[
                'dishForm' => $form->createView()
            ]);
        }
    }
    #[Route('/admin/dish/{id}', name: 'one_dish')]
    public function displayOneDish($id, DishesRepository $dish){
        $dish = $dish->find($id);

        return $this->render('admin/dish/oneDish.html.twig', [
            'dish' => $dish,
        ]);
    }
    #[Route('/admin/dish/update/{id}', name: 'update_dish')]
    public function updateDish(Dishes $dish, Request $request, EntityManagerInterface $em){
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($dish);
            $em->flush();

            return $this->redirectToRoute('all_dish');
        }else{
            return $this->render('admin/dish/add.html.twig',[
                'dishForm' => $form->createView()
            ]);
        }
    }
    #[Route('/admin/activate/dish/{id}', name: 'activate_dish')]
    public function activateDish(Dishes $dish, EntityManagerInterface $em){
        $dish->setActive(($dish->getActive())? false : true);
        $em->persist($dish);
        $em->flush();

        return new Response("true");
    }

    #[Route('/admin/dish/delete/{id}', name: 'delete_dish')]
    public function deleteDish(Dishes $dish, EntityManagerInterface $em){
        $em->remove($dish);
        $em->flush();

        return $this->redirectToRoute('all_dish');
    }
}

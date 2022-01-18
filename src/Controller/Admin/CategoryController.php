<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'category')]
    public function index(CategoryRepository $categories): Response
    {
        $categories = $categories->findAll();

        return $this->render('admin/category/categories-list.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
        ]);
    }
    #[Route('/admin/category/new', name: 'add_category')]
    public function addCategory(Request $request, EntityManagerInterface $em){
        $category = new Category;
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category');
        }else{
            return $this->render('admin/category/add-category.html.twig',[
                'categoryForm' => $form->createView(),
            ]);
        }
    }
    #[Route('/admin/category/update/{id}', name: 'update_category')]
    public function updateCategory(Category $category, Request $request, EntityManagerInterface $em){
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category');
        }else{
            return $this->render('admin/category/update-category.html.twig',[
                'categoryForm' => $form->createView()
            ]);
        }
    }
    #[Route('/admin/category/delete/{id}', name: 'delete_category')]
    public function deleteCategory(Category $category, EntityManagerInterface $em){
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('category');
    }
}

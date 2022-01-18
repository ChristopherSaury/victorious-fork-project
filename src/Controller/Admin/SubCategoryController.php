<?php

namespace App\Controller\Admin;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubCategoryController extends AbstractController
{
    #[Route('/admin/sub-category', name: 'sub-category')]
    public function index(SubCategoryRepository $subCategories): Response
    {
        $subCategories = $subCategories->findAll();
        return $this->render('admin/sub_category/sub-categories-list.html.twig', [
            'controller_name' => 'SubCategoryController',
            'subCategories' => $subCategories,
        ]);
    }
    #[Route('/admin/sub-category/new', name: 'add_sub-category')]
    public function addSubCategory(Request $request, EntityManagerInterface $em){
        $subCategory = new SubCategory;
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($subCategory);
            $em->flush();

            return $this->redirectToRoute('sub-category');
        }else{
            return $this->render('admin/sub_category/add_sub-category.html.twig',[
                'subCategoryForm' => $form->createView(),
            ]);
        }
    }
    #[Route('/admin/sub-category/update/{id}', name: 'update_sub-category')]
    public function updateSubCategory(SubCategory $subCategory, Request $request, EntityManagerInterface $em){
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($subCategory);
            $em->flush();

            return $this->redirectToRoute('sub-category');
        }else{
            return $this->render('admin/sub_category/update_sub-category.html.twig',[
                'subCategoryForm' => $form->createView()
            ]);
        }
    }
    #[Route('/admin/sub-category/delete/{id}', name: 'delete_sub-category')]
    public function deleteCategory(SubCategory $subCategory, EntityManagerInterface $em){
        $em->remove($subCategory);
        $em->flush();

        return $this->redirectToRoute('sub-category');
    }
}

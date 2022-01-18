<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/admin/user', name: 'all_user')]
    public function userList(UserRepository $users): Response
    {
        $users = $users->findAll();
        return $this->render('admin/user/list.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
        ]);
    }
    #[Route('/admin/delete/user/{id}', name: 'delete_user')]
    public function deleteUser(User $user, EntityManagerInterface $em){
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('all_user');
    }
}

<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Dishes;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Form\OrderValidationType;
use App\Repository\DishesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session, DishesRepository $dishesRepository): Response
    {
        $cart = $session->get("cart", []);

        $cartData = [];
        $total = 0;

        foreach($cart as $id => $quantity){
            $dish = $dishesRepository->find($id);
            $cartData[] = [
                "dish" => $dish,
                "quantity" => $quantity,
            ];
            $total += $dish->getPrice() * $quantity;
        }
        return $this->render('cart/index.html.twig', compact("cartData", "total"));
    }
    /**
     * @Route("/add/{id}", name="add")
     */
    public function add (Dishes $dish, SessionInterface $session){
        $cart = $session->get("cart", []);
        $id = $dish->getId();
        
        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }

        $session->set("cart", $cart);
        $this->addFlash('message', ' plat ajouté à la commande');
        return $this->redirectToRoute("selection");
    }
    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Dishes $dish, SessionInterface $session){
        $cart = $session->get("cart", []);
        $id = $dish->getId();
        
        if(!empty($cart[$id])){
            if($cart[$id] > 1){
                $cart[$id]--;
            }else{
                unset($cart[$id]);
            }
        }

        $session->set("cart", $cart);
        
        return $this->redirectToRoute("cart_index");
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Dishes $dish, SessionInterface $session){
        $cart = $session->get("cart", []);
        $id = $dish->getId();
        
        if(!empty($cart[$id])){
            unset($cart[$id]);
            }

            $session->set("cart", $cart);
            
            return $this->redirectToRoute("cart_index");
    }
    /**
     * @Route("/validation", name="validation")
     */
    public function cartValidation (SessionInterface $session, Request $request, EntityManagerInterface $em){
        $cart = $session->get("cart", []);
        $new_order = new Order;
        $form = $this->createForm(OrderValidationType::class, $new_order);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($new_order);
            $em->flush();
        }
        
        return $this->render('cart/validation.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/delete-all", name="delete_all")
     */
    public function deleteCart(SessionInterface $session){
        $cart = $session->get("cart", []);
        
            unset($cart);

            $session->remove("cart", []);
            
            return $this->redirectToRoute("cart_index");
        }
}



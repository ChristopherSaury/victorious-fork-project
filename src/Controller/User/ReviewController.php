<?php

namespace App\Controller\User;

use DateTime;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewController extends AbstractController
{
    /**
     * @Route("/review", name="review")
     */
    public function index(ReviewRepository $reviewRepo, Request $request, EntityManagerInterface $em): Response
    {    
        if($this->getUser()){

            $userPseudo = $this->getUser()->getAccountIdentifier();
            $userId = $this->getUser()->getId();
        }else{
            $userPseudo = null;
            $userId = null;
        }
        $form = $this->createForm(ReviewType::class);
         return $this->render('review/review.html.twig', [
                'reviews' => $reviewRepo->findAll(),
                'userPseudo' => $userPseudo,
                'userId' => $userId,
                'form' => $form->createView()
            ]);
        }
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/review/new", name="create_review")
     */
    public function createReview(Request $request, EntityManagerInterface $em){
        $new_review = new Review;
        $form = $this->createForm(ReviewType::class, $new_review);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $new_review->setUser($this->getUser());
            $new_review->setPublicationDate(new DateTime());
            $em->persist($new_review);
            $em->flush();

            return $this->redirectToRoute('review');
        }else{
            return $this->render('review/review.html.twig',[
                'form' => $form->createView(),
            ]);
        }
    }
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/user/review/delete/{id}", name="delete_review")
     */
    public function deleteReview(Review $review, EntityManagerInterface $em){
        $em->remove($review);
        $em->flush();

        $this->addFlash('message', 'commentaire effacé avec succès');
        return $this->redirectToRoute('review');
        
    }

    
}

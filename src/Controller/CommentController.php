<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Ouvrage;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentController extends Controller
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index()
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * @Route("/comment/add/{id}", name="addComment")
     */
    public function addCommentAction(Ouvrage $ouvrage, Request $request){

        $comment = new Comment();
        $entityManager = $this->getDoctrine()->getManager();
////
        $form  = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){

            $entityManager->persist($comment);
            $entityManager->flush();

        }


        return $this->render('ouvrage/show.html.twig', [
//            'form' => $form->createView(),
//            'ouvrage' => $ouvrage
        ]);
    }
}

<?php
//src/Controller/DefaultController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Entity\Ouvrage;
use App\Entity\Task;
use App\Form\TaskType;
//use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

// src/Controller/SecurityController.php
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
//    /**
//     * @Route("default/new", name="task_success")
//     */
//    public function new(Request $request)
//    {
//        $task = new Task();
//        $form = $this->createForm(TaskType::class, $task);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()){
//            $task = $form->getData();
//            return $this->redirectToRoute('task_success');
//        }
//        else {
//            return $this->render('default/new.html.twig', array(
//                'form' => $form->createView(),
//            ));
//        }
//
//
//
//    }

//    /**
//     * @Route("base/admin")
//     */
//    public function base_admin (){
//        return $this->render('default/base_admin.html.twig');
//    }

//    /**
//     * @Route("lucky/homes", name="lucky_home")
//     */
//    public function home(){
//
//        $Title_book = "LIEUX SECRETS";
//        $Sub_Title_book ="Merveilles insolite de l'humanité";
//        $Cat_name = "Voyage";
//        $Resume = "Après le succès de Terre secrète et ses merveilles, Patrick Baud, créateur de la chaîne Youtube Axolot,
//                    vous propose un tour du monde à la découverte de cent lieux étranges et souvent méconnus : le puits mystique du palais de la Regaleira au Portugal,
//                    l'incroyable musée sous-marin de Cancun au Mexique, les mystérieux tombeaux de Myre en Turquie, la mosquée multicolore Nasir-ol-Molk en Iran,
//                    ou encore les jardins suspendus futuristes de Singapour... A chaque fois, une magnifique photographie accompagne la description du site et son
//                    étonnante histoire. Vous pouvez plonger dans ce livre et le lire d'une seule traite, ou bien le déguster au gré de vos envies, pour découvrir
//                    les lieux les plus secrets de notre planète !";
//        $Author = "Patrick Baud";
//        $Editor = "DUNOD";
//        $Isbn = 9782100763818;
//        $Classification = "";
////        $Comments = array('pseudo' => "Pierre",'body' => "blabla");
//        $Comments = array("blaba", "lorem", "test");
//
//
//
//
//        return $this->render('lucky/home.html.twig', array(
//            'Title_book' => $Title_book,
//            'Sub_Title_book' => $Sub_Title_book,
//            'Cat_name' => $Cat_name,
//            'Resume' => $Resume,
//            'Author' => $Author,
//            'Editor' => $Editor,
//            'Isbn' => $Isbn,
//            'Classification' => $Classification,
//            'comments' => $Comments
//        ));
//    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin(){
        return new Response('<html><body>Admin page!</body></html>');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('default/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

}
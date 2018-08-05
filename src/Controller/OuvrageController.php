<?php

namespace App\Controller;

use App\Entity\Ouvrage;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\OuvrageType;
use App\Service\ReservationManager;
use DateTime;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class OuvrageController extends Controller
{
    /**
     * @Route("/ouvrage", name="ouvrage")
     */
    public function index()
    {
        return $this->render('ouvrage/index.html.twig', [
            'controller_name' => 'OuvrageController',
        ]);
    }

    /**
     * @Route("/admin/ouvrage/ajout", name="ouvrage_add")
     */
    public function addAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $ouvrage = new Ouvrage();



        $form  = $this->createForm(OuvrageType::class, $ouvrage);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){


            $file = $ouvrage->getPicture();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('pictures_directory'),
                $fileName
            );

            $ouvrage->setPicture($fileName);

            $entityManager->persist($ouvrage);
            $entityManager->flush();


            return $this->redirectToRoute('ouvrage_showAll');
        }

        return $this->render('ouvrage/add.html.twig', [
            'mainNavGestBooks' => true,
            'form' => $form->createView()
        ]);
    }

    //On verifie si il y a une réservation (une date)
    //si oui alors on détermine l'interval entre cette date et la date actuel
    //si l'interval est sup à 12h alors on efface la réservation
    //si il n'y a pas de réservation alors ont fait rien
    /**
     * @Route("/ouvrage/{id}", name="ouvrage_show")
     */
    public function showAction(Ouvrage $ouvrage, ReservationManager $reservationManager)
    {
        $reservationManager->CheckIfReservationIsFinish($ouvrage, $this);
        return $this->render('ouvrage/show.html.twig', [
            'mainNavBooks' => true,
            'ouvrage' => $ouvrage
        ]);
    }

    /**
     * @Route("/admin/ouvrage/{id}", name="admin_ouvrage_show")
     */
    public function adminShowAction(Ouvrage $ouvrage, ReservationManager $reservationManager, Request $request)
    {
        $reservationManager->CheckIfReservationIsFinish($ouvrage, $this);

        return $this->render('ouvrage/admin_show.html.twig', [
            'mainNavBooks' => true,
            'ouvrage' => $ouvrage
        ]);
    }

    /**
     * @Route("/ouvrage/show/all", name="ouvrage_showAll")
     */
    public function showAllAction(ReservationManager $reservationManager){

        $entityManager = $this->getDoctrine()->getManager();
        $ouvrages = $entityManager->getRepository(Ouvrage::class)->findAll();

        foreach ($ouvrages as $ouvrage){
            $reservationManager->CheckIfReservationIsFinish($ouvrage, $this);
        }

        if (!$ouvrages){
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }

        return $this->render('ouvrage/showAll.html.twig', [
            'mainNavBooks' => true,
            'ouvrages' => $ouvrages
        ]);
    }

    /**
     * @Route("/admin/ouvrage/management/all", name="admin_ouvrage_managementAll")
     */
    public function adminShowAllAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $ouvrages = $entityManager->getRepository(Ouvrage::class)->findAll();

        if (!$ouvrages){
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }

        return $this->render('ouvrage/admin_ouvrage_managementAll.html.twig', [
            'mainNavGestBooks' => true,
            'ouvrage' => $ouvrages
        ]);
    }

    /**
     * @Route("/admin/ouvrage/classic/show/all", name="admin_ouvrage_classic_showAll")
     */
    public function adminClassicShowAllAction(ReservationManager $reservationManager){

        $entityManager = $this->getDoctrine()->getManager();
        $ouvrages = $entityManager->getRepository(Ouvrage::class)->findAll();

        foreach ($ouvrages as $ouvrage){
            $reservationManager->CheckIfReservationIsFinish($ouvrage, $this);
        }

        if (!$ouvrages){
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }

        return $this->render('ouvrage/admin_classic_showAll.html.twig', [
            'mainNavBooks' => true,
            'ouvrages' => $ouvrages
        ]);
    }

    /**
     * @Route("/admin/ouvrage/edit/{id}", name="ouvrage_edit")
     */
    public function edit2Action(Ouvrage $ouvrage , Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $oldFile = $ouvrage->getPicture();
        $ouvrage->setPicture(
            new File($this->getParameter('pictures_directory').'/'.$ouvrage->getPicture())
        );

        $form = $this->createForm(OuvrageType::class, $ouvrage);

        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){

            $file = $ouvrage->getPicture();
            var_dump('submit '.$file);

            $info = $form->getData();

            var_dump($info);

            if($info->getPicture() != null){
                $file = $info->getPicture();
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('pictures_directory'),
                    $fileName
                );

                $ouvrage->setPicture($fileName);
            } else {
                $ouvrage->setPicture($oldFile);
            }


            $entityManager->flush();


            return $this->redirectToRoute('ouvrage_showAll');
        }

        return $this->render('ouvrage/edit.html.twig', [
            'mainNavGestBooks' => true,
            'form' =>$form->createView(),
            'ouvrage' => $ouvrage
        ]);
    }

    /**
     * @Route("/admin/ouvrage/delete/{id}", name="ouvrage_delete")
     */
    public function deleteAction(Ouvrage $ouvrage)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($ouvrage);
        $entityManager->flush();

        $this->addFlash(
            'notice', 'L\'ouvrage a été supprimé'
        );

        return $this->redirectToRoute('admin_ouvrage_managementAll');
    }

    private function generateUniqueFileName ()
    {
        return md5(uniqid());
    }

    //on vérifie si il y a déja une date de réservation (donc une réservation possible en cours)
    //si oui on calcule l'interval entre cette date et la date actuel
    //si l'interval est supérieur au temps max de réservation alors on déclenche la réservation
    //si elle est inférieur on annule la réservation (une réservation est déja en cour)
    //si il n'y a pas de date de réservation alors on déclenche la réservation
    /**
     * @Route("/user/ouvrage/reservation/{id}", name="ouvrage_reservation")
     */
    public function reservationdAction(Ouvrage $ouvrage, AuthorizationCheckerInterface $authChecker, ReservationManager $reservationManager){

        $reservationManager->CheckIfReservationIsFinish($ouvrage, $this);

//        $reservationManager->AddReservationInDataBase($ouvrage, $this);
        if ($reservationManager->CheckIfReservationIsFinish($ouvrage, $this)){
            $entityManager = $this->getDoctrine()->getManager();
            $ouvrage->setUser($this->getUser());
            $date = new DateTime();
            $date->format('Y-m-d H:i:s');
            $ouvrage->setDateReservation($date);
            $entityManager->persist($ouvrage);
            $entityManager->flush();

            $this->addFlash('notice', 'Ouvrage reservé , vous avez 12h pour le récupérer');
        }

        if($authChecker->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('admin_ouvrage_show', array(
                'id' => $ouvrage->getId()
            ));
        }
        return $this->redirectToRoute('ouvrage_show', array(
            'id' => $ouvrage->getId()
        ));
    }


    /**
     * @Route("/user/ouvrage/cancel/reservation/{id}", name="cancel_reservation")
     */
    public function cancelReservationAction(Ouvrage $ouvrage){
        $entityManager = $this->getDoctrine()->getManager();
        $ouvrage->setDateReservation(null);
        $ouvrage->setUser(null);
        $entityManager->flush();
    }

    /**
     * @Route("/user/ouvrage/cancel/manual/reservation/{id}", name="cancel_manual_reservation")
     */
    public function cancelManualReservationAction(Ouvrage $ouvrage){
        $entityManager = $this->getDoctrine()->getManager();
        $ouvrage->setDateReservation(null);
        $ouvrage->setUser(null);
        $entityManager->flush();

        $this->addFlash('notice', 'Votre réservation est annulée');
        return $this->redirectToRoute('user_profil');
    }


    /**
     * @Route("/admin/ouvrage/reservation/users/{id}")
     */
    public function myOuvrage(Ouvrage $ouvrage, ReservationManager $reservationManager){

        $reservationManager->CheckIfReservationIsFinish($ouvrage, $this);
        return $this->render('user/my_ouvrage.html.twig', [
            'ouvrage' => $ouvrage,
            'myOuvrage' => $ouvrage->getUser()
        ]);
    }

    /**
     * @Route("/admin/ouvrage/show/all/reservation", name="ouvrage_showAllReservation")
     */
    public function showAllReservationAction(ReservationManager $reservationManager){


        $entityManager = $this->getDoctrine()->getManager();
        $ouvrages = $entityManager->getRepository(Ouvrage::class)->findAll();

        foreach ($ouvrages as $ouvrage){
            $reservationManager->CheckIfReservationIsFinish($ouvrage, $this);
        }

        if (!$ouvrages){
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }
        return $this->render('ouvrage/admin_show_all_reservation.html.twig', [
            'mainNavGestBooks' => true,
            'ouvrages' => $ouvrages
        ]);
    }

    /**
     * @Route("/user/ouvrage/add/comment/{id}", name="ouvrage_addComment")
     */
//    public function addCommentAction(Ouvrage $ouvrage,Request $request){
//
//        $entityManager = $this->getDoctrine()->getManager();
//
//
//        $form  = $this->createForm(CommentType::class, $ouvrage);
//        $form->handleRequest($request);
//
//        if($form->isSubmitted()&&$form->isValid()){
//
//            $entityManager->persist($ouvrage);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('ouvrage_show');
//        }
//
//
//        return $this->render('ouvrage/admin_show.html.twig', [
//            'form' => $form->createView(),
//            'ouvrage' => $ouvrage
//        ]);
//    }


    /*   public function empruntAction(Ouvrage $ouvrage, User $user, Request $request){
           if(($ouvrage->getRerservation == false) && ($ouvrage->getEmprunt() == false) ){
               $entityManager = $this->getDoctrine()->getManager();

               $form = $this->createForm(EmpruntType::class, $ouvrage);

               $form->handleRequest($request);

               if($form->isSubmitted()&&$form->isValid()){

                   $user->setUser($this->getUser());
                   $entityManager->persist($ouvrage);
                   $entityManager->flush();


                   return $this->redirectToRoute('ouvrage_showAll');
               }


               $this->render('ouvrage/emprunt.html.twig',[
                   'form' => $form->createView()
               ]);
           }
       }*/

//public function returnBookAction($ouvrage, $user){
//
//}

}
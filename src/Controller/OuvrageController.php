<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Ouvrage;
use App\Entity\Rent;
use App\Entity\SearchBook;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\EmpruntType;
use App\Form\OuvrageType;
use App\Form\SearchBookType;
use App\Service\ReservationManager;
use DateTime;
use Doctrine\ORM\Query\Expr\Select;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
     * @Route("/admin/ouvrage/add", name="ouvrage_add")
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
            $ouvrage->setStatus('free');

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
    public function showAction(Ouvrage $ouvrage, ReservationManager $reservationManager, Request $request, AuthorizationCheckerInterface $authChecker)
    {
        $comment = new Comment();
        $form  = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){

            $this->addCommentAction($ouvrage, $comment, $request, $authChecker);
        }

        $reservationManager->CheckIfReservationIsFinish($ouvrage, $this);

        return $this->render('ouvrage/show.html.twig', [
            'form' => $form->createView(),
            'mainNavBooks' => true,
            'ouvrage' => $ouvrage,
            'comments' => $ouvrage->getComments()
        ]);
    }

    /**
     * @Route("/admin/ouvrage/show/{id}", name="admin_ouvrage_show")
     */
    public function adminShowAction(Ouvrage $ouvrage, ReservationManager $reservationManager, Request $request, AuthorizationCheckerInterface $authChecker)
    {
        $comment = new Comment();
        $form  = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){

            $this->addCommentAction($ouvrage, $comment, $request, $authChecker);
        }

        $reservationManager->CheckIfReservationIsFinish($ouvrage, $this);

        return $this->render('ouvrage/admin_show.html.twig', [
            'form' => $form->createView(),
            'mainNavBooks' => true,
            'ouvrage' => $ouvrage,
            'comments' => $ouvrage->getComments()
        ]);
    }

    /**
     * @Route("/ouvrage/show/all", name="ouvrage_showAll")
     */
    public function showAllAction(ReservationManager $reservationManager, Request $request ){


        /*$ouvrages = $repo->getAllOuvrages($currentPage);

        $totalPostReturned = $ouvrages->getIterator()->count();

        $totalPost = $ouvrages->count();
        $iterator = $ouvrages->getIterator();

        $limit = 5 ;
        $maxPages = ceil ( $paginator -> count () / $limit );
        $thisPage = $page ;
        // Pass through the 3 above variables to calculate pages in twig
        return $this -> render ( 'view.twig.html' , compact ( 'categories' , 'maxPages' , 'thisPage' ));*/


        $searchBook = new SearchBook();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(SearchBookType::class, $searchBook);
        $form->handleRequest($request);
        $search[0] = '';

                if($form->isSubmitted()&& $form->isValid()) {
                    $search = $searchBook->getOuvrage();


                }
//                    $entityManager = $this->getDoctrine()->getManager();
        $ouvrages = $entityManager->getRepository(Ouvrage::class)->findAll();
//        $ouvrages = $entityManager->getRepository(Ouvrage::class)->getOuvrages(0);

//        $ouvrage = new Ouvrage();
//        $form = $this->createForm(OuvrageType::class, $ouvrage);

//        $form->handleRequest($request);
        foreach ($ouvrages as $ouvrage){
            $reservationManager->CheckIfReservationIsFinish($ouvrage, $this);
        }

        if (!$ouvrages){
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }

        return $this->render('ouvrage/showAll.html.twig', [
            'form' => $form->createView(),
            'search' => $search,
            'mainNavBooks' => true,
            'ouvrages' => $ouvrages
        ]);
    }

    /**
     * @Route("/admin/ouvrage/management/all", name="admin_ouvrage_managementAll")
     */
    public function adminOuvrageManagementAllAction(){
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
    public function adminClassicShowAllAction(ReservationManager $reservationManager, Request $request){

        $searchBook = new SearchBook();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(SearchBookType::class, $searchBook);
        $form->handleRequest($request);
        $search[0] = '';

        if($form->isSubmitted()&& $form->isValid()) {
            $search = $searchBook->getOuvrage();
        }

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
            'form' => $form->createView(),
            'search' => $search,
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


            $info = $form->getData();



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


            return $this->redirectToRoute('admin_ouvrage_classic_showAll');
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
            $ouvrage->setStatus('reservation');
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
        $ouvrage->setStatus('free');
        $entityManager->flush();
    }

    /**
     * @Route("/user/ouvrage/cancel/manual/reservation/{id}", name="cancel_manual_reservation")
     */
    public function cancelManualReservationAction(Ouvrage $ouvrage, AuthorizationCheckerInterface $authChecker){
        $entityManager = $this->getDoctrine()->getManager();
        $ouvrage->setDateReservation(null);
        $ouvrage->setUser(null);
        $ouvrage->setStatus('free');
        $entityManager->flush();

        $this->addFlash('notice', 'Votre réservation est annulée');
        if($authChecker->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('user_profil_admin');
        }
        return $this->redirectToRoute('user_profil');
    }

    /**
     * @Route("/user/ouvrage/cancel/manual/rent/{id}", name="cancel_manual_rent")
     */
    public function cancelManualRentAction(Ouvrage $ouvrage){
        $entityManager = $this->getDoctrine()->getManager();
        $ouvrage->setDateReservation(null);
        $ouvrage->setUser(null);
        $ouvrage->setStatus('free');
        $entityManager->flush();

        $this->addFlash('notice', 'L\'ouvrage est à nouveau disponible');
        return $this->redirectToRoute('admin_ouvrage_managementAll');
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
    public function addCommentAction(Ouvrage $ouvrage, Comment $comment, Request $request, AuthorizationCheckerInterface $authChecker){

        $entityManager = $this->getDoctrine()->getManager();

        $dateToday = new DateTime();
        $dateToday->format('Y-m-d H:i:s');

        $comment->setDate($dateToday);
        $comment->setNameUser($this->getUser());
        $comment->setNameOuvrage($ouvrage);
        $entityManager->persist($comment);
        $entityManager->flush();

        if($authChecker->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('admin_ouvrage_show',[
                'id' => $ouvrage->getId()
            ]);
        }
        return $this->redirectToRoute('ouvrage_show',[
            'id' => $ouvrage->getId()
        ]);
    }

//public function searchAction(Ouvrage $ouvrage, SearchType $searchType, Request $request){
//        $entityManager = $this->getDoctrine()->getManager();
//
//        $form = $this->createForm(SearchType::class, $searchType);
//        $form->handleRequest($request);
//        $titreTape = "test";
//
//        $titreToSearch = $entityManager->getRepository(Ouvrage::class)->findOneBy(array('title' => $titreTape ));
//
//        return $this->render('ouvrage/show/', [
//           'titreToSearch' => $titreToSearch,
//           'form' => $form->createView()
//        ]);
//
//
//}


    /**
     * @Route("/admin/ouvrage/emprunt/{id}", name="ouvrage_emprunt")
     */
    public function rentAction(Ouvrage $ouvrage, Request $request, ReservationManager $reservationManager){

        $reservationManager->CheckIfReservationIsFinish($ouvrage, $this);

        $rent = new Rent();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(EmpruntType::class, $rent);
        $form->handleRequest($request);

        switch ($ouvrage->getStatus()){
            case 'free':

                if($form->isSubmitted()&& $form->isValid()) {
                    $ouvrage->setStatus('emprunt');
                    $rentUser = $rent->getUser();

                    $objetUser = $entityManager->getRepository(User::class)->findOneBy(array('username' => $rentUser));

                    $ouvrage->setUser($objetUser);

                    $dateRent = new DateTime();
                    $ouvrage->setDateReservation($dateRent);

                    $entityManager->persist($ouvrage);
                    $entityManager->flush();
                    $this->addFlash('notice', 'L\'ouvrage '.$ouvrage->getTitle().' est emprunté');
                    return $this->redirectToRoute('admin_ouvrage_managementAll');
                }
                break;

            case 'reservation':
                $userReservation = $ouvrage->getUser()->getUsername();

                if($form->isSubmitted() && $form->isValid()){
                    if($rent->getUser() == $userReservation){
                        $ouvrage->setStatus('emprunt');
                        $dateRent = new DateTime();
                        $ouvrage->setDateReservation($dateRent);
                        $entityManager->persist($ouvrage);
                        $entityManager->flush();
                        $this->addFlash('notice', 'L\'ouvrage '.$ouvrage->getTitle().' est emprunté');
                        return $this->redirectToRoute('admin_ouvrage_managementAll');
                        break;
                    }else {
                        $this->addFlash('notice', "l'ouvrage est déja réservé");
                        break;
                    }
                }break;

            case 'not_available':
                $this->addFlash('notice', 'L\'ouvrage est en cour de réstauration');
                return $this->redirectToRoute('admin_ouvrage_managementAll');
                break;
            case 'emprunt':
                $this->addFlash('notice', 'Ouvrage déja emprunté');
                return $this->redirectToRoute('admin_ouvrage_managementAll');
                break;
        }
        return $this->render('ouvrage/emprunt.html.twig', array(
            'form' =>$form->createView(),
            'ouvrage' => $ouvrage,
            'mainNavGestBooks' => true
        ));
    }


    public function moderationCommentAction(){

    }
}
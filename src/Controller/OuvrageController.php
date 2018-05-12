<?php

namespace App\Controller;

use App\Entity\Ouvrage;
use App\Form\OuvrageType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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


//            return $this->redirect($this->generateUrl('app_product_list'));


            $entityManager->persist($ouvrage);
            $entityManager->flush();


            return $this->redirectToRoute('ouvrage_showAll');
        }

        return $this->render('ouvrage/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/ouvrage/{id}", name="ouvrage_show")
     */
    public function showAction(Ouvrage $ouvrage)
    {
        return $this->render('ouvrage/show.html.twig', [
            'ouvrage' => $ouvrage
        ]);
    }

    /**
     * @Route("/admin/ouvrage/{id}", name="admin_ouvrage_show")
     */
    public function adminShowAction(Ouvrage $ouvrage)
    {
        return $this->render('ouvrage/admin_show.html.twig', [
            'ouvrage' => $ouvrage
        ]);
    }

    /**
     * @Route("/ouvrage/show/all", name="ouvrage_showAll")
     */
    public function showAllAction(){

        $entityManager = $this->getDoctrine()->getManager();
        $ouvrages = $entityManager->getRepository(Ouvrage::class)->findAll();

        if (!$ouvrages){
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }

        return $this->render('ouvrage/showAll.html.twig', [
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
            'ouvrage' => $ouvrages
        ]);
    }

    /**
     * @Route("/admin/ouvrage/classic/show/all", name="admin_ouvrage_classic_showAll")
     */
    public function adminClassicShowAllAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $ouvrages = $entityManager->getRepository(Ouvrage::class)->findAll();

        if (!$ouvrages){
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }

        return $this->render('ouvrage/admin_classic_showAll.html.twig', [
            'ouvrages' => $ouvrages
        ]);
    }



    /**
     * @Route("/admin/ouvrage/edit/{id}", name="ouvrage_edit")
     */
    public function editAction(Ouvrage $ouvrage, Request $request)
    {
        if($ouvrage->getPicture()){
            $ouvrage->setPicture(
                new File($this->getParameter('pictures_directory').'/'.$ouvrage->getPicture())
            );
        }

        $entityManager = $this->getDoctrine()->getManager();


        $form = $this->createForm(OuvrageType::class, $ouvrage);


        $form->handleRequest($request);


        if ($form->isSubmitted()&&$form->isValid()){
            $file = $ouvrage->getPicture();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('pictures_directory'),
                $fileName
            );
            $ouvrage->setPicture($fileName);


            $entityManager->flush();

            return $this->redirectToRoute('ouvrage_showAll');
        }
        var_dump($ouvrage);
        return $this->render('ouvrage/edit.html.twig', [
            'form' => $form->createView(),
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

        return $this->redirectToRoute('ouvrage_showAll');
    }

    private function generateUniqueFileName ()
    {
        return md5(uniqid());
    }


}

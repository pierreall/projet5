<?php

namespace App\Controller;

use App\Entity\Ouvrage;
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
     * @Route("/ouvrage/ajout", name="ouvrage_add")
     */
    public function addAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $ouvrage = new Ouvrage();
        $ouvrage->setAuthor("Patrick Baud");
        $ouvrage->setEditor("DUNOD");
        $ouvrage->setGenre("Voyage");
        $ouvrage->setISBNumber(9782100763818);
        $ouvrage->setResume("Après le succès de Terre secrète
         et ses merveilles, Patrick Baud, créateur de la chaîne Youtube Axolot,
         vous propose un tour du monde à la découverte de cent lieux étranges et souvent méconnus :
           le puits mystique du palais de la Regaleira au Portugal, l'incroyable musée sous-marin de Cancun au Mexique,
            les mystérieux tombeaux de Myre en Turquie, la mosquée multicolore Nasir-ol-Molk en Iran,
             ou encore les jardins suspendus futuristes de Singapour... A chaque fois, une magnifique 
             photographie accompagne la description du site et son étonnante histoire. Vous pouvez plonger 
             dans ce livre et le lire d'une seule traite, ou bien le déguster au gré de vos envies, 
             pour découvrir les lieux les plus secrets de notre planète !");
        $ouvrage->setTitle("LIEUX SECRETS III");
        $ouvrage->setSubTitle("Merveilles insolite de l'humanité");

        $entityManager->persist($ouvrage);

        $entityManager->flush();



        return $this->render('ouvrage/index.html.twig', [
            'controller_name' => $ouvrage->getTitle()
        ]);
    }

    /**
     * @Route("/ouvrage/{id}")
     */
    public function showAction(Ouvrage $ouvrage)
    {
        return $this->render('ouvrage/show.html.twig', [
            'ouvrage' => $ouvrage
        ]);
    }

    /**
     * @Route("/ouvrages", name="ouvrage_all")
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
     * @Route("/ouvrage/edit/{id}")
     */
    public function updateAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $ouvrage = $entityManager->getRepository(Ouvrage::class)->find($id);

        if (!$ouvrage) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

//        $ouvrage->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $ouvrage->getId()
        ]);
    }

    /**
     * @Route("/ouvrage/delete/{id}")
     */
    public function deleteAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $ouvrage = $entityManager->getRepository(Ouvrage::class)->find($id);

        if (!$ouvrage) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($ouvrage);
        $entityManager->flush();

//        return $this->redirectToRoute('product_show', [
//            'id' => $ouvrage->getId()
//        ]);
    }

}

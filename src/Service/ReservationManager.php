<?php
namespace App\Service;


use App\Controller\OuvrageController;
use App\Entity\Ouvrage;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReservationManager extends Controller{

    /**
     * @param Ouvrage $ouvrage
     * @param OuvrageController $ouvrageController
     * @return bool
     */
    public function CheckIfReservationIsFinish(Ouvrage $ouvrage, OuvrageController $ouvrageController)
    {
        if ($ouvrage->getDateReservation() != null) {
            $dateToday = new DateTime();

            $dateReserv = $ouvrage->getDateReservation()->format('Y-m-d H:i:s');
            $dateReservation = new DateTime($dateReserv);

            $interval = $dateToday->diff($dateReservation);

            if ($interval->h > 11 || $interval->d > 0 || $interval->m > 0 || $interval->y > 0){
                $ouvrageController->cancelReservationAction($ouvrage);
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * @param Ouvrage $ouvrage
     */
    /*public function AddReservationInDataBase(Ouvrage $ouvrage, OuvrageController $ouvrageController){

        var_dump($this->CheckIfReservationIsFinish($ouvrage, $ouvrageController));
        if ($this->CheckIfReservationIsFinish($ouvrage, $ouvrageController)){
            $entityManager = $this->getDoctrine()->getManager();
            $ouvrage->setUser($this->getUser());
            $date = new DateTime();
            $date->format('Y-m-d H:i:s');
            $ouvrage->setDateReservation($date);
            $entityManager->persist($ouvrage);
            $entityManager->flush();

            $this->addFlash('notice', 'Ouvrage reservé , vous avez 12h pour le récupérer');
        }
    }*/
}
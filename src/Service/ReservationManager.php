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
        if ($ouvrage->getDateReservation() != null && $ouvrage->getStatus() == "reservation") {
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

}
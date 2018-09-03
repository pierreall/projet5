<?php
//src/Controller/DefaultController.php

namespace App\Controller;

use App\Entity\Ouvrage;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function index(AuthorizationCheckerInterface $authChecker){

        $entityManager = $this->getDoctrine()->getManager();

        $lastOuvrages =$entityManager->getRepository(Ouvrage::class)->findBy(array(),array('id' => 'desc'), 3, 0);


        if($authChecker->isGranted('ROLE_ADMIN')){
            return $this->render('default/admin_home.html.twig', array(
                'mainNavHome' => true,
                'lastOuvrages' => $lastOuvrages
            ));
        }else {
            return $this->render('default/home.html.twig', array(
                'mainNavHome' => true,
                'lastOuvrages' =>$lastOuvrages
            ));
        }

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
            'mainNavLogin' => true,
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(\Swift_Mailer $mailer, Request $request ){

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $message = (new \Swift_Message($form->get('mailSubject')->getData()))
                ->setFrom($form->get('mailFrom')->getData())
                ->setTo('alloinp@gmail.com')
                ->setBody($form->get('mailBody')->getData(), 'text/html')
            ;

            $mailer->send($message);
            return $this->redirectToRoute('contact');
        }


       return $this->render('default/contact.html.twig', [
            'form' => $form->createView()
        ]);


    }

}
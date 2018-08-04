<?php

namespace App\Controller;

use App\Entity\Ouvrage;
use App\Entity\User;
use App\Form\UserProfilType;
use App\Form\UserType;
//use http\Env\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserController extends Controller
{
    /**
     * @Route("/admin/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/admin/user/ajout", name="user_add")
     */
    public function addAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_showAll');
        }

        return $this->render('user/add.html.twig', [
            'mainNavGestUsers' => true,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/user/{id}", name="user_show")
     */
    public function showAction (User $user)
    {
        return $this->render('user/show.html.twig', [
            'mainNavGestUsers' => true,
            'ouvrages' => $user->getOuvrages(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/user/show/all", name="user_showAll")
     */
    public function showAllAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $users = $entityManager->getRepository(User::class)->findAll();


        if (!$users){
            throw $this->createNotFoundException(
                'No users found for id '
            );
        }

        return $this->render('user/showAll.html.twig', [
            'mainNavGestUsers' => true,
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin/user/edit/{id}", name="user_edit")
     */
    public function editAction(User $user , Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $entityManager = $this->getDoctrine()->getManager();


        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager->flush();

            return $this->redirectToRoute('user_showAll');
        }

        return $this->render('user/edit.html.twig', [
            'mainNavGestUsers' => true,
            'form' =>$form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/user/delete/{id}", name="user_delete")
     */
    public function deleteAction(User $user)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash(
            'notice','L\'utilisateur a été supprimé'.$user->getUsername()
        );


        return $this->redirectToRoute('user_showAll');
    }

    /**
     * @Route("/user/profil", name="user_profil")
     */
    public function myProfilAction(){
        $user = $this->getUser();
        $myProfil = $this->getUser();


        return $this->render('user/my_profil.html.twig', [
            'mainNavProfil' => true,
            'myProfil' => $myProfil,
            'ouvrages' => $user->getOuvrages()
        ]);
    }

    /**
     * @Route("/user/profil/admin", name="user_profil_admin")
     */
    public function myProfilAdminAction(){
        $user = $this->getUser();
        $myProfil = $this->getUser();

        return $this->render('user/admin_my_profil.html.twig', [
            'mainNavProfil' => true,
            'myProfil' => $myProfil,
            'ouvrages' => $user->getOuvrages()
        ]);
    }

    /**
     * @Route("/user/profil/edit/{id}", name="user_profil_edit")
     */
    public function myProfilEditAction(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder, AuthorizationCheckerInterface $authChecker){
        $entityManager = $this->getDoctrine()->getManager();


        $form = $this->createForm(UserProfilType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager->flush();

            return $this->redirectToRoute('user_profil');
        }

        if($authChecker->isGranted('ROLE_ADMIN')){
            return $this->render('user/admin_edit_my_profil.html.twig', [
                'mainNavProfil' => true,
                'form' =>$form->createView(),
                'user' => $user,
                'ouvrage' => $user->getOuvrages()
            ]);
        }

        return $this->render('user/edit_my_profil.html.twig', [
            'mainNavProfil' => true,
            'form' =>$form->createView(),
            'user' => $user,
            'ouvrage' => $user->getOuvrages()
        ]);
    }
}

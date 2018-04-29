<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
//use http\Env\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @Route("/admin/user/ajout/", name="user_add")
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
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/user/{id}", name="user_show")
     */
    public function showAction (User $user)
    {
        return $this->render('user/show.html.twig', [
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

//            return $this->redirectToRoute('user_show',[
//                'user' => $user->getId(),
//            ]);
            return $this->redirectToRoute('user_showAll');
        }

        return $this->render('user/edit.html.twig', [
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
            'notice','L\'utilisateur a été supprimé'
        );


        return $this->redirectToRoute('user_showAll');
    }

}

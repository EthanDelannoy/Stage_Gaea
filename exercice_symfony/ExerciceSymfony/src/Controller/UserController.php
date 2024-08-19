<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use App\Form\UserType;

class UserController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }



    #[Route('/user', name: 'user')]
    public function afficher(Request $request, UserRepository $repository): Response
    {

        $users = $repository->findAll();   

        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em){
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été créée');
            return $this->redirectToRoute('user');
        }
        return $this->render('user/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/user/{id}', name: 'edit', methods: ['GET', 'POST'], requirements:['id' => Requirement::DIGITS])]
    public function edit(User $user, Request $request, EntityManagerInterface $em) {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été modifiée');
            return $this->redirectToRoute('user');
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form
        ]);

    }

    #[Route('/user/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(User $user, EntityManagerInterface $em): Response
    {
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'L\'utilisateur a bien été supprimé');
        return $this->redirectToRoute('user'); 
    }

    #[Route('/user/{id}/possession', name:'possession')]
    public function possession(User $user): Response
    {

        $possessions = $user->getPossessions();

        return $this->render('user/possession.html.twig', [
            'user' => $user,
            'possessions' => $possessions,
        ]);
    }

}

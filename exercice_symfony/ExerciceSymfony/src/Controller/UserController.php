<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

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

    #[Route('/user/{id}', name:'delete', methods: ['DELETE'], requirements:['id' => Requirement::DIGITS])]
    public function remove(User $user, EntityManagerInterface $em){
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'L\'utilisateur a bien été supprimée');
        return $this->redirectToRoute('user');
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController {

    #[Route("/", name: "home")]
    function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response { //créer un utilisateur
        // $user = new User();
        // $user->setEmail('Jogn@doe.fr')
        // ->setUsername('JohnDoe')
        // ->setPassword($hasher->hashPassword($user, '0000'))
        // ->setRoles([]);
        // $em->persist($user);
        // $em->flush();
        return $this->render('home/index.html.twig');
    }
}

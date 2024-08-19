<?php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use App\Form\UserType;
use App\Service\UserService;

class UserController extends AbstractController
{
    private $userService;

    // Injecter UserService via le constructeur
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/user', name: 'user')]
    public function afficher(Request $request, UserRepository $repository): Response
    {

        $users = $repository->findAll();

        foreach ($users as $user) {

            $user->age = $this->userService->calculateAge($user->getBirthdate());
        }

        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été créé');
            return $this->redirectToRoute('user');
        }
        return $this->render('user/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/user/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été modifié');
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

    #[Route('/user/{id}/possession', name: 'possession')]
    public function possession(User $user): Response
    {
        $possessions = $user->getPossessions();

        return $this->render('user/possession.html.twig', [
            'user' => $user,
            'possessions' => $possessions,
        ]);
    }
}
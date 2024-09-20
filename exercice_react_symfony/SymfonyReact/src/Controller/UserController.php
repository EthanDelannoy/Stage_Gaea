<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    
    #[Route('/api/users', name: 'api_users', methods: ['GET'])]
    public function getUsers(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $users = $userRepository->findAll();
    
        $data = $serializer->serialize($users, 'json', [
            'groups' => 'user:read',
            'datetime_format' => 'Y-m-d'
        ]);
    
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/api/users/{id}', name: 'api_delete_user', methods: ['DELETE'])]
    public function deleteUser($id, UserRepository $userRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $userRepository->find($id);

        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'L\'utilisateur a bien été supprimé'], Response::HTTP_OK);
    }

    #[Route('/api/users', name: 'api_create_user', methods: ['POST'])]
public function createUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
{
    $user = $serializer->deserialize($request->getContent(), User::class, 'json');
    
    if (empty($user->getNom()) || empty($user->getPrenom()) || empty($user->getEmail()) || empty($user->getAdresse()) || empty($user->getTel()) || empty($user->getBirthDate())) {
        return new JsonResponse(['error' => 'Missing data'], Response::HTTP_BAD_REQUEST);
    }

    $birthDate = $user->getBirthDate();
    $age = null;

    if ($birthDate) {
        $age = $birthDate->diff(new \DateTime())->y;
    }

    $entityManager->persist($user);
    $entityManager->flush();

    return new JsonResponse([
        'id' => $user->getId(),
        'nom' => $user->getNom(),
        'prenom' => $user->getPrenom(),
        'email' => $user->getEmail(),
        'adresse' => $user->getAdresse(),
        'tel' => $user->getTel(),
        'birthDate' => $birthDate->format('Y-m-d'),
        'age' => $age,
    ], Response::HTTP_CREATED);
}
}

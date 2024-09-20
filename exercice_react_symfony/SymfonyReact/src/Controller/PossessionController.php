<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PossessionController extends AbstractController
{
    #[Route('/api/users/{id}/possessions', name: 'api_user_possessions', methods: ['GET'])]
    public function getUserPossessions(int $id, UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $user = $userRepository->find($id);
    
        $possessions = $user->getPossessions();
    
        
        $data = $serializer->serialize($possessions, 'json', ['groups' => 'user:read']);
    
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/api/users/{id}', name: 'api_get_user', methods: ['GET'])]
    public function getUsers(int $id, UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
{
    $user = $userRepository->find($id);

    $data = $serializer->serialize($user, 'json', [
        'groups' => 'user:read',
        'datetime_format' => 'Y-m-d'
    ]);
    
    return new JsonResponse($data, 200, [], true);
}
}


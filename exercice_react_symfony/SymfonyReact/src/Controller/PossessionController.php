<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PossessionController extends AbstractController
{
    #[Route('/api/users/{id}/possessions', name: 'api_user_possessions', methods: ['GET'])]
    public function getUserPossessions(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);

        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $possessions = $user->getPossessions();
        $data = [];

        foreach ($possessions as $possession) {
            $data[] = [
                'id' => $possession->getId(),
                'nom' => $possession->getNom(),
                'valeur' => $possession->getValeur(),
                'type' => $possession->getType(),
            ];
        }

        return $this->json($data);
    }
}


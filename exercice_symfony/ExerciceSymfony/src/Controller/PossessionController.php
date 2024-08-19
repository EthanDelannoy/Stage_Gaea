<?php

namespace App\Controller;

use App\Entity\Possession;
use App\Entity\User;
use App\Form\PossessionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class PossessionController extends AbstractController
{
  
    #[Route('/user/{id}/add-possession', name: 'add_possession')]
    public function addPossession(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $possession = new Possession();
        $possession->setUser($user);

        $form = $this->createForm(PossessionType::class, $possession);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($possession);
            $entityManager->flush();

            return $this->redirectToRoute('possession', ['id' => $user->getId()]);
        }

        return $this->render('possession/add.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/possession/{id}', name: 'deletePossession', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(Possession $possession, EntityManagerInterface $em): Response
    {
    $em->remove($possession);
    $em->flush();
    $this->addFlash('success', 'La possession a bien été supprimée');
    return $this->redirectToRoute('possession', ['id' => $possession->getUser()->getId()]);
    }

    #[Route('/possession/{id}', name: 'editPossession', methods: ['GET', 'POST'], requirements:['id' => Requirement::DIGITS])]
    public function edit(Possession $possession, Request $request, EntityManagerInterface $em) {
        $form = $this->createForm(PossessionType::class, $possession);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'La possession a bien été modifiée');
            return $this->redirectToRoute('possession', ['id' => $possession->getUser()->getId()]);
        }
        return $this->render('possession/edit.html.twig', [
            'possession' => $possession,
            'form' => $form
        ]);
    }
}
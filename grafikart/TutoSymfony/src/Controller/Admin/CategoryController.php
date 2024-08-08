<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/admin/category", name: 'admin.category.')] //Le chemain 
#[IsGranted('ROLE_ADMIN')] // Seul les admins peuvent y accedez
class CategoryController extends AbstractController {

    #[Route(name: 'index')] //Le chemain 
    public function index(CategoryRepository $repository){
        return $this->render('admin/category/index.html.twig', [  //Afficher ce que l'on veux 
            'categories' => $repository->findAllWithCount()       //Avec cette fonctions
        ]);
    }

    #[Route('/create', name: 'create')] //Le chemain 
    public function create(Request $request, EntityManagerInterface $em){
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category); //Creer le formulaire 
        $form->handleRequest($request);                            //envoyer les informations
        if($form->isSubmitted() && $form->isValid()){              // si c'est envoyé et valide 
            $em->persist($category);                               // la requetes est envoyé 
            $em->flush();                                          // la requetes est envoyé 
            $this->addFlash('success', 'La catégorie a bien été créée');  // Mettre un message de validation visible
            return $this->redirectToRoute('admin.category.index');   // Le rediriger vers l'index
        }
        return $this->render('admin/category/create.html.twig', [    // afficher le formulaire 
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'edit', requirements:['id' => Requirement::DIGITS], methods:['GET', 'POST'])]
    public function edit(Category $category, Request $request, EntityManagerInterface $em){
        $form = $this->createForm(CategoryType::class, $category);   //Creer le formulaire
        $form->handleRequest($request);                              //envoyer les informations
        if($form->isSubmitted() && $form->isValid()){                // si c'est envoyé et valide 
            $em->flush();                                            // la requetes est envoyé 
            $this->addFlash('success', 'La catégorie a bien été modifiée'); // Mettre un message de validation visible
            return $this->redirectToRoute('admin.category.index'); // Le rediriger vers l'index
        }
        return $this->render('admin/category/edit.html.twig', [ // afficher le formulaire 
            'category' => $category,
            'form' => $form
        ]);

    }

    #[Route('/{id}', name: 'delete', requirements:['id' => Requirement::DIGITS], methods:['DELETE'])]
    public function remove(Category $category, EntityManagerInterface $em){
        $em->remove($category);     //Supprimer la categorie
        $em->flush();               //Envoyer la requetes
        $this->addFlash('success', 'La catégorie a bien été supprimée');  // Mettre un message de validation visible
        return $this->redirectToRoute('admin.category.index'); // Le rediriger vers l'index
    }
}
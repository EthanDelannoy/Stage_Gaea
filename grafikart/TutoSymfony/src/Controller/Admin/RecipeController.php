<?php

namespace App\Controller\Admin;

use App\Demo;
use App\Entity\Category;
use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use PharIo\Manifest\Requirement;
use phpDocumentor\Reflection\Types\Resource_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement as RequirementRequirement;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/admin/recettes", name: 'admin.recipe.')]
#[IsGranted('ROLE_ADMIN')]
class RecipeController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(RecipeRepository $repository, Request $request): Response
    {

        $page = $request->query->getInt('page', 1);
        $limit = 2;
        $recipes = $repository->paginateRecipes($page);
        return $this->render('admin/recipe/index.html.twig', [
            'recipes' => $recipes,

        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em){
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'La recette a bien été créée');
            return $this->redirectToRoute('admin.recipe.index');
        }
        return $this->render('admin/recipe/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements:['id' => RequirementRequirement::DIGITS])]

    public function edit(Recipe $recipe, Request $request, EntityManagerInterface $em) {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'La recette a bien été modifiée');
            return $this->redirectToRoute('admin.recipe.index');
        }
        return $this->render('admin/recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form
        ]);

    }

    #[Route('/{id}', name:'delete', methods: ['DELETE'], requirements:['id' => RequirementRequirement::DIGITS])]
    public function remove(Recipe $recipe, EntityManagerInterface $em){
        $em->remove($recipe);
        $em->flush();
        $this->addFlash('success', 'La recette a bien été supprimée');
        return $this->redirectToRoute('admin.recipe.index');
    }

}

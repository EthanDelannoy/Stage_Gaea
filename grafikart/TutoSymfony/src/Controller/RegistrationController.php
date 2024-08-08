<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user); //formulaire 
        $form->handleRequest($request); //envoyer les informations 

        if ($form->isSubmitted() && $form->isValid()) {  // si c'est envoyé et valide 

            $user->setPassword( // On prend son mdp 
                $userPasswordHasher->hashPassword( // On le hash
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user); // on enregistre les son mpd hasher
            $entityManager->flush();        // on enregistre les son mpd hasher


            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user, //envoie un email pour confirmer que son email est valide
                (new TemplatedEmail())
                    ->from(new Address('support@demo.fr', 'Support')) // le nom de notre adresse email 
                    ->to($user->getEmail()) // la personne qui a enregistrer son email 
                    ->subject('Please Confirm your Email') // l'objet
                    ->htmlTemplate('registration/confirmation_email.html.twig') //L'affichage du mail 
            );

            return $security->login($user, 'form_login', 'main');
        }

        return $this->render('registration/register.html.twig', [ //afficher le formulaire 
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); // si il a bien validé dans le mail


        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser()); // si il a bien validé dans le mail
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle')); // sinon message d'erreur

            return $this->redirectToRoute('app_register'); // on le redirige 
        }

        $this->addFlash('success', 'Your email address has been verified.'); // affichage du message de validation 

        return $this->redirectToRoute('app_register'); // on le redirige 
    } 
}

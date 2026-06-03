<?php

namespace App\Controller;

use App\Entity\Buyer;
use App\Entity\Profile;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
  public function __construct(private EmailVerifier $emailVerifier) {}

  #[Route('/register', name: 'app_register')]
  public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
  {
    $user = new User();
    $user->setProfile(new Profile());
    
    $form = $this->createForm(RegistrationFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      /** @var string $plainPassword */
      $plainPassword = $form->get('plainPassword')->getData();
      
      // Encode password
      $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

      // Create Buyer
      $buyer = new Buyer();
      $user->setBuyer($buyer);

      $entityManager->persist($user);
      $entityManager->flush();

      // Send verification email
      $appSender = $this->getParameter('app_sender_email');
      $appName = $this->getParameter('app_name');

      $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
        (new TemplatedEmail())
          ->from(new Address($appSender, $appName))
          ->to($user->getEmail())
          ->subject('Please confirm your email')
          ->htmlTemplate('registration/confirmation_email.html.twig')
      );

      return $this->redirectToRoute('app_confirmation_account_creation');
    }

    return $this->render('registration/register.html.twig', [
      'registrationForm' => $form->createView(),
    ]);
  }

  #[Route('/verify/email', name: 'app_verify_email')]
  public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
  {
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    // validate email confirmation link, sets User::isVerified=true and persists
    try {
      /** @var User $user */
      $user = $this->getUser();
      $this->emailVerifier->handleEmailConfirmation($request, $user);
      
      return $this->redirectToRoute('app_verification_success');

    } catch (VerifyEmailExceptionInterface $exception) {
      $this->addFlash('error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));
      return $this->redirectToRoute('app_register');
    }
  }

  #[Route('/registration/confirmation', name: 'app_confirmation_account_creation')]
  public function registrationConfirmation()
  {
    return $this->render('registration/confirmation.html.twig');
  }

  #[Route('/verification/success', name: 'app_verification_success')]
  public function verificationSuccess()
  {
    return $this->render('registration/verification_success.html.twig');
  }

}
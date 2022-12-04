<?php

namespace App\Service;

use App\Entity\User;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class UserRegister {

    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;
    private EmailVerifier $emailVerifier;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface, EntityManagerInterface $entityManager, EmailVerifier $emailVerifier)
    {
        
        $this->userPasswordHasher = $userPasswordHasherInterface;
        $this->entityManager = $entityManager;
        $this->emailVerifier = $emailVerifier;
    }

    public function setPassword(User $user, Form $form){

            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->entityManager->persist($user);
            $this->entityManager->flush();

    }

    public function registrationConfirmationEmail(User $user){

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('ladynight@gmail.com', 'Lady Night'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

    }

    public function handleEmailConfirmation(Request $request, UserInterface $user){

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {

            return $exception;
        }


    }


}

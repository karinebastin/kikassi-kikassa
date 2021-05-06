<?php

namespace App\Controller\Admin;

use App\Entity\SuperAdmin;
use App\Entity\AdhesionBibliotheque;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

#[Route('/reset-password')]
class ResetAdminPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private $resetPasswordHelper;

    public function __construct(
        ResetPasswordHelperInterface $resetPasswordHelper
    ) {
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    /**
     * Display & process form to request a password reset.
     */
    #[Route('', name: 'admin_forgot_password_request')]
    public function request(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processSendingPasswordResetEmail(
                $form->get('email')->getData(),
                $mailer
            );
        }

        return $this->render('admin/reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    /**
     * Confirmation page after a user has requested a password reset.
     */
    #[Route('/check-email', name: 'admin_check_email')]
    public function checkEmail(): Response
    {
        // We prevent users from directly accessing this page
        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            return $this->redirectToRoute('admin_forgot_password_request');
        }

        return $this->render('admin/reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     */
    #[Route('/reset/{token}', name: 'admin_reset_password')]
    public function reset(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        string $token = null
    ): Response {
        if ($token) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('admin_reset_password');
        }

        $token = $this->getTokenFromSession();
        if (null === $token) {
            throw $this->createNotFoundException(
                'No reset password token found in the URL or in the session.'
            );
        }

        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser(
                $token
            );
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash(
                'reset_password_error',
                sprintf(
                    'There was a problem validating your reset request - %s',
                    $e->getReason()
                )
            );

            return $this->redirectToRoute('admin_forgot_password_request');
        }

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A password reset token should be used only once, remove it.
            $this->resetPasswordHelper->removeResetRequest($token);

            // Encode the plain password, and set it.
            $encodedPassword = $passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setMotDePasse($encodedPassword);
            $this->getDoctrine()
                ->getManager()
                ->flush();

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();

            return $this->redirectToRoute('admin_login');
        }

        return $this->render('admin/reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }

    private function processSendingPasswordResetEmail(
        string $emailFormData,
        MailerInterface $mailer
    ): RedirectResponse {
        $user = $this->getDoctrine()
            ->getRepository(AdhesionBibliotheque::class)
            ->findOneBy([
                'email' => $emailFormData,
            ])
            ? $this->getDoctrine()
                ->getRepository(AdhesionBibliotheque::class)
                ->findOneBy([
                    'email' => $emailFormData,
                ])
            : $this->getDoctrine()
                ->getRepository(SuperAdmin::class)
                ->findOneBy([
                    'email' => $emailFormData,
                ]);

        // Do not reveal whether a user account was found or not.
        if (!$user) {
            return $this->redirectToRoute('admin_check_email');
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            // If you want to tell the user why a reset email was not sent, uncomment
            // the lines below and change the redirect to 'admin_forgot_password_request'.
            // Caution: This may reveal if a user is registered or not.
            //
            // $this->addFlash('reset_password_error', sprintf(
            //     'There was a problem handling your password reset request - %s',
            //     $e->getReason()
            // ));

            return $this->redirectToRoute('admin_check_email');
        }

        $email = (new TemplatedEmail())
            ->from(new Address('marjorieme@hotmail.com', 'kikassi-mail'))
            ->to($user->getEmail())
            ->subject('Your password reset request')
            ->htmlTemplate('admin/reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
            ]);

        $mailer->send($email);

        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        return $this->redirectToRoute('admin_check_email');
    }
}
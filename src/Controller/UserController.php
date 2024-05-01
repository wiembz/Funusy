<?php

namespace App\Controller;

use App\Form\CheckResetType;

use App\Form\ChangePasswordFormType;
use App\Entity\User;
use App\Form\Signup1Type;
use App\Form\Signup2Type;
use App\Form\Signup3Type;
use App\Form\UserLoginFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Gregwar\Captcha\CaptchaBuilder;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
// Add this at the beginning of your UserController.php file
use Symfony\Component\Form\FormError;

class UserController extends AbstractController
{
    #[Route('/hello', name: 'app_hello')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
 // ResetPassword Method
#[Route('/reset-password', name: 'reset_password')]
public function resetPassword(Request $request, SessionInterface $session, MailerInterface $mailer): Response
{
    // Generate a random token
    $randomToken = mt_rand(100000, 999999);

    // Save the token in the session
    $session->set('reset_token', $randomToken);

    // Send the token to the user's email
    $email = (new Email())
        ->from('hamza.mbarki@esprit.tn')
        ->to('mohamed.bsila@esprit.tn') // Get email from user input
        ->subject('Password Reset Token')
        ->text("Your password reset token is: $randomToken");

    $mailer->send($email);

    // Redirect to a route where users can input the reset token
    return $this->redirectToRoute('check_reset');
}

#[Route('/checkReset', name: 'check_reset')]
public function checkReset(Request $request, SessionInterface $session): Response
{
    $form = $this->createForm(CheckResetType::class);
    $form->handleRequest($request);
    $enteredToken='';
    $storedToken = $session->get('reset_token');
    if ($form->isSubmitted() && $form->isValid()) {
        $enteredToken = $form->get('reset_token')->getData();
        $storedToken = $session->get('reset_token');

        if ($enteredToken == $storedToken) {
            // Verification successful, clear reset token and redirect to change password page
            $session->remove('reset_token');
            return $this->redirectToRoute('change_password');
        }

        // Verification failed, add error message to the form
        $form->addError(new FormError('Invalid reset token.'));
    }

    return $this->render('user/reset/reset_verification_failed.html.twig', [
        'form' => $form->createView(),
        'storedToken'=>$storedToken,
        'enteredToken'=>$enteredToken,
    ]);
}
    #[Route('/changePas', name: 'change_password')]
    public function changePassword(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the submitted new password from the form
            $newPassword = $form->get('new_password')->getData();
            $confirmPassword = $form->get('confirm_password')->getData();
    
            // Check if new password and confirm password match
            if ($newPassword !== $confirmPassword) {
                // Handle error, passwords do not match
                return $this->render('change_password.html.twig', [
                    'form' => $form->createView(),
                    'error' => 'Passwords do not match'
                ]);
            }
    
            // Fetch the user with emailUser == moha@gmail.com
            $userRepository = $entityManager->getRepository(User::class);
            $user = $userRepository->findOneBy(['emailUser' => 'mohamed.bsila@esprit.2tn']);
    
            // Update the user's password
            if ($user instanceof User) {
                $user->setMdp(password_hash($newPassword, PASSWORD_DEFAULT));
                $entityManager->flush();
    
                // Password updated successfully, redirect or render success message
                return $this->redirectToRoute('password_changed_successfully');
            }
    
            // Handle error, user not found
            return $this->render('user/reset/change_password.html.twig', [
                'form' => $form->createView(),
                'error' => 'User not found'
            ]);
        }
    
        // Render the form
        return $this->render('user/reset/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/passwordChangedSuccessfully', name: 'password_changed_successfully')]
    public function passwordChangedSuccessfully(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Implement your logic here
        
        return $this->redirectToRoute('signup_success');
    }
    #[Route('/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->invalidate();
        return $this->redirectToRoute('home_front');
    }

    #[Route('/logins', name: 'app_user1')]
    public function login(Request $request, UserRepository $userRepository, SessionInterface $session): Response
    {
        $failedAttempts = $session->get('failed_attempts', 0);

        $form = $this->createForm(UserLoginFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check CAPTCHA if present
            if ($failedAttempts >= 3) {
                $captcha = $request->request->get('captcha');
                // Validate CAPTCHA here
                if (!$this->validateCaptcha($captcha, $session)) {
                    // Invalid CAPTCHA, increment failed attempts and display error
                    $failedAttempts++;
                    $session->set('failed_attempts', $failedAttempts);
                    $this->addFlash('error', 'Invalid CAPTCHA.');
                    return $this->redirectToRoute('app_user1'); // Redirect back to login page
                }
            }

            $userFormData = $form->getData();
            $user = $userRepository->findOneBy(['emailUser' => $userFormData->getEmailUser()]);

            if ($user !== null && password_verify($userFormData->getMdp(), $user->getMdp())) {
                // Reset failed attempts upon successful login
                $session->set('failed_attempts', 0);

                // Start session and store user data
                $session->set('id', $user->getIdUser());
                $session->set('name', $user->getNomUser());
                $session->set('role', $user->getRoleUser());
                $session->set('email', $user->getEmailUser());

                return $this->redirectToRoute('signup_step2');
            } else {
                $failedAttempts++;
                $session->set('failed_attempts', $failedAttempts);

                if ($failedAttempts >= 3) {
                    // Display CAPTCHA
                    throw new CustomUserMessageAuthenticationException('Please complete the CAPTCHA.');
                } else {
                    $this->addFlash('error', 'Invalid email or password.');
                }
            }
        }

        // Display CAPTCHA field if required
        $showCaptcha = ($failedAttempts >= 3);

        return $this->render('user/login/login.html.twig', [
            'form' => $form->createView(),
            'showCaptcha' => $showCaptcha,
        ]);
    }
    private function validateCaptcha(?string $captcha, SessionInterface $session): bool
    {
        // Check if captcha is null
        if ($captcha === null) {
            return false;
        }
    
        $captchaSession = $session->get('captcha');
        if ($captcha === $captchaSession) {
            return true;
        }
        return false;
    }
    

    #[Route('/generate-captcha', name: 'generate_captcha')]
    public function generateCaptcha(SessionInterface $session): Response
    {
        // Generate CAPTCHA image
        $captcha = new CaptchaBuilder();
        $captcha->build();
    
        // Set CAPTCHA text in session
        $session->set('captcha', $captcha->getPhrase());
    
        // Generate response with CAPTCHA image
        $response = new Response($captcha->get(), 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    
        return $response;
    }

    #[Route('/signup', name: 'signup_step1')]
    public function step1(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(Signup1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $user->getEmailUser();

            // Check if email already exists
            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['emailUser' => $email]);

            if ($existingUser) {
                $this->addFlash('error', 'Email already exists. Please use a different email address.');
            } else {
                $_SESSION['email'] = $email;
                return $this->redirectToRoute('signup_step2');
            }
        }

        return $this->render('user/signup/step1.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/signup/step2', name: 'signup_step2')]
    public function step2(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(Signup2Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $user->getMdp();   /////  hna jbed password men 3and el user 
            

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); ///// hna hasha el password 
            $user->setMdp($hashedPassword); ///// hna raja3 el password lel user ama 3amelou el hash (cripteh )

            
            $_SESSION['password'] = $hashedPassword;///// hna type fi lansa session   besm password 
            return $this->redirectToRoute('signup_step3');
        }

        return $this->render('user/signup/step2.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/signup/step3', name: 'signup_step3')]
    public function step3(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(Signup3Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $_SESSION['email'];
            $password = $_SESSION['password'];
            
            // Set email and password obtained from session
            $user->setEmailUser($email);
            $user->setMdp($password);
            
            // Persist user to the database
            $entityManager->persist($user);
            $entityManager->flush();

            // Clear session after signup
            unset($_SESSION['email']);
            unset($_SESSION['password']);

            // Redirect to a success page or wherever you want
            return $this->redirectToRoute('signup_success');
        }

        return $this->render('user/signup/step3.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/signup/success', name: 'signup_success')]
    public function success(): Response
    {
        return $this->render('user/signup/success.html.twig');
    }
   
}

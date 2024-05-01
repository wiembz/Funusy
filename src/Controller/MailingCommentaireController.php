<?php

// src/Controller/MailingCommentaireController.php

namespace App\Controller\Commentaire;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailingCommentaireController extends AbstractController
{
    #[Route('/commentaire/mail', name: 'app_commentaire_mail', methods: ['POST'])]
    public function sendMail(Request $request): Response
    {
        // Sender's email address (your email)
        $myAccountEmail = 'omaymasellami2018@gmail.com';
        // Generated app password
        $password = 'ikel ocib bzut pdfp';

        $recepient = $request->request->get('adress_mail');
        $subject = $request->request->get('subject_mail');
        $content = $request->request->get('content_mail');

        // Checking if fields are empty
        if (empty($subject) || empty($content)) {
            // Return a JSON response with an error message
            return $this->json(['message' => 'Empty fields', 'error' => true], Response::HTTP_BAD_REQUEST);
        }

        // Sending the email
        try {
            $message = $this->preparedMessage($myAccountEmail, $recepient, $subject, $content);

            // Creating a transport
            $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                ->setUsername($myAccountEmail)
                ->setPassword($password);

            // Creating the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);

            // Sending the message
            $result = $mailer->send($message);

            if ($result) {
                // Return a JSON response indicating success
                return $this->json(['message' => 'Email sent successfully', 'error' => false], Response::HTTP_OK);
            } else {
                // Return a JSON response with an error message
                return $this->json(['message' => 'Failed to send email', 'error' => true], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            // Return a JSON response with an error message
            return $this->json(['message' => 'An error occurred: ' . $e->getMessage(), 'error' => true], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Preparing the message to be sent
    private function preparedMessage(string $myAccountEmail, string $recepient, string $subject, string $content): \Swift_Message
    {
        return (new \Swift_Message($subject))
            ->setFrom($myAccountEmail)
            ->setTo($recepient)
            ->setBody($content);
    }
}

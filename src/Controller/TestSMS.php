<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TwilioService;
use App\Entity\CarteBancaire;

class TestSMS extends AbstractController
{
    #[Route('/test-twilio/{carteId}', name: 'test_twilio')]
    public function testTwilio(TwilioService $twilioService): Response
    {
        

        $carte = $this->getDoctrine()->getRepository(CarteBancaire::class)->find('5464 8489 6468 4464');

        // Create an instance of TwilioService with the provided Twilio credentials
        $twilioService->sendReminder($carte);

        // Return a response indicating that the reminder was sent
        return new Response('Reminder sent successfully!');
    }

    }

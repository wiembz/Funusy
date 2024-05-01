<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignaleController extends AbstractController
{
    #[Route('/signale', name: 'app_signale')]
    public function index(): Response
    {
        return $this->render('signale/index.html.twig', [
            'controller_name' => 'SignaleController',
        ]);
    }
}

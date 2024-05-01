<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarteBancaireController extends AbstractController
{
    #[Route('/carte/bancaire', name: 'app_carte_bancaire')]
    public function index(): Response
    {
        return $this->render('carte_bancaire/index.html.twig', [
            'controller_name' => 'CarteBancaireController',
        ]);
    }
}

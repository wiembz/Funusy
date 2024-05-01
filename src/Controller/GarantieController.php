<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GarantieController extends AbstractController
{
    #[Route('/garantie', name: 'app_garantie')]
    public function index(): Response
    {
        return $this->render('garantie/index.html.twig', [
            'controller_name' => 'GarantieController',
        ]);
    }
}

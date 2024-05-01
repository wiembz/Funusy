<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvestissementController extends AbstractController
{
    #[Route('/investissement', name: 'app_investissement')]
    public function index(): Response
    {
        return $this->render('investissement/index.html.twig', [
            'controller_name' => 'InvestissementController',
        ]);
    }
}

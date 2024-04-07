<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        return $this->render('FRONT/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
    #[Route('/testback', name: 'app_testback')]
    public function indexBACK(): Response
    {
        return $this->render('BACK/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}

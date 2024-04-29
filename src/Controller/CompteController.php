<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CompteType;
use App\Repository\CompteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use App\Repository\UserRepository;


use DateTime;

#[Route('/compte')]
class CompteController extends AbstractController
{   
    
    #[Route('/get-user-details/{userId}', name: 'get_user_details')]
public function getUserDetails($userId, UserRepository $userRepository): JsonResponse
{
    // Retrieve user details from the database based on $userId
    $user = $userRepository->find($userId);

   
    // Retrieve the user's last name and first name
    $lastName = $user->getNomUser();
    $firstName = $user->getPrenomUser();

    // Return user details as JSON response
    return new JsonResponse([
        'lastName' => $lastName,
        'firstName' => $firstName,
    ]);
}




    #[Route('/new', name: 'app_compte_new', methods: ['GET', 'POST'])]

    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $compte = new Compte();

        // Generate a random string for rib
        $rib = $this->generateRandomRib();

        // Set the generated rib
        $compte->setRib($rib);

        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        $currentDateTime = new DateTime();
        
        $formattedDateTime = $currentDateTime->format('d-m-Y');
        $date = DateTime::createFromFormat('d-m-Y', $formattedDateTime);
        dump($date);
       


        if ($form->isSubmitted() && $form->isValid()) {
           
            $entityManager->persist($compte);
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_show', ['rib' => $compte->getRib()], Response::HTTP_SEE_OTHER);

        }

        return $this->render('compte/new.html.twig', [
            'compte' => $compte,
            'form' => $form->createView(),
        ]);
        
        
    }
    
    #[Route('/{rib}', name: 'app_compte_show', methods: ['GET'])]
    public function show(Compte $compte): Response
    {
        return $this->render('compte/show.html.twig', [
            'compte' => $compte,
        ]);
    }

    #[Route('/', name: 'app_compte_index', methods: ['GET', 'POST'])]
    public function indexFRONT(CompteRepository $compteRepository): Response
    {
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
    
        return $this->render('compte/indexBACK.html.twig', [
            'comptes' => $compteRepository->findAll(),
            'form' => $form->createView(), // Pass the createView() method
        ]);
    }


    #[Route('/{rib}/edit', name: 'app_compte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Compte $compte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_show', ['rib' => $compte->getRib()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compte/edit.html.twig', [
            'compte' => $compte,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{rib}', name: 'app_compte_delete', methods: ['POST'])]
    public function delete(Request $request, Compte $compte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $compte->getRib(), $request->request->get('_token'))) {
            $entityManager->remove($compte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_home_page', [], Response::HTTP_SEE_OTHER);
    }

    private function generateRandomRib(): string
    {
        $rib = '';
        for ($i = 0; $i < 20; $i++) {
            $rib .= mt_rand(0, 9);
        }
        return $rib;
    }
}
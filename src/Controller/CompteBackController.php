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
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\User;
use App\Repository\UserRepository;

use DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/compte/back')]
class CompteBackController extends AbstractController
{  
    #[Route('/{rib}', name: 'app_compte_back_delete', methods: ['POST'])]
    public function delete(Request $request, Compte $compte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $compte->getRib(), $request->request->get('_token'))) {
            $entityManager->remove($compte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_compte_back_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/error', name: 'app_compte_show_back_error', methods: ['GET', 'POST'])]
    public function indexBACK(CompteRepository $compteRepository): Response
    {
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
    
        return $this->render('compte_back/show_back.html.twig', [
            'comptes' => $compteRepository->findAll(),
            'form' => $form->createView(), 
        ]);
    }

    #[Route('/new', name: 'app_compte_back_new', methods: ['GET', 'POST'])]

    public function new(Request $request, EntityManagerInterface $entityManager,CompteRepository $CompteRepository,ValidatorInterface $validatorInterface): Response
    {
        $compte = new Compte();
        $randomRib = '';
        for ($i = 0; $i < 20; $i++) {
            $randomRib .= mt_rand(0, 9); // Append a random digit (0-9)
        }

        // Set the generated RIB as the default value for the "rib" field
        $compte->setRib($randomRib);
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        $currentDateTime = new DateTime();
        
        $formattedDateTime = $currentDateTime->format('d-m-Y');
        $date = DateTime::createFromFormat('d-m-Y', $formattedDateTime);
        dump($date);

        $idUser = $compte->getIdUser();

        if ($form->isSubmitted() && $form->isValid()) {
           
            $existingCompte = $CompteRepository->findOneBy(['id_user' => $idUser]);


            if (!$existingCompte) {

            $this->addFlash('error', 'User with ID '.$idUser.' already exists !! .');
            return $this->redirectToRoute('app_compte_show_back_error');
        }

            $entityManager->persist($compte);
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compte_back/new.html.twig', [
            'compte' => $compte,
            'form' => $form->createView(),
        ]);
        
        
    }
    
    #[Route('/{rib}', name: 'app_compte_back', methods: ['GET'])]
    public function show(Compte $compte): Response
    {
        return $this->render('compte_back/show.html.twig', [
            'compte' => $compte,
        ]);
    }

    #[Route('/', name: 'app_compte_back_index', methods: ['GET', 'POST'])]
    public function indexFRONT(CompteRepository $compteRepository): Response
    {
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
    
        return $this->render('compte_back/indexBACK.html.twig', [
            'comptes' => $compteRepository->findAll(),
            'form' => $form->createView(), 
        ]);
    }
    



    #[Route('/{rib}/edit', name: 'app_compte_back_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Compte $compte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compte_back/edit.html.twig', [
            'compte' => $compte,
            'form' => $form->createView(),
        ]);
    }

   
}
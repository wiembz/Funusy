<?php

namespace App\Controller;

use App\Entity\CarteBancaire;
use App\Form\CarteBancaireType;
use App\Repository\CarteBancairetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTime;
use App\Entity\Compte;
#[Route('/carte/bancaire')]
class CarteBancaireController extends AbstractController
{
    #[Route('/test', name:'app_test')]
    
   public function ind(Request $request)
   {
       $form = $this->createForm(CarteBancaireType::class); // Replace YourFormType with the actual name of your form type class

       return $this->render('carte_bancaire/_form.html.twig', [
           'form' => $form->createView(),
       ]);
   }

    #[Route('/f', name: 'app_carte_bancaire', methods: ['GET'])]
    public function indexFRONT(CarteBancairetRepository $carteBancairetRepository): Response
    {



        return $this->render('carte_bancaire/index.html.twig', [
           

            'carte_bancaires' => $carteBancairetRepository->findAll(),
           
        ]);
    }


    #[Route('/ccc', name: 'app_newcarte_bancaire')]
    public function carddd(Request $request, EntityManagerInterface $entityManager): Response
    {
        $requestData = json_decode($request->getContent(), true);

        // Check if the required keys exist in the array
        if (isset($requestData['cardNumber'], $requestData['cardName'], $requestData['cardExpiration'], $requestData['cardCvv'], $requestData['rib'])) {
            // Extract card information from JSON data
            $cardNumber = $requestData['cardNumber'];
            $cardName = $requestData['cardName'];
            $cardExpiration = DateTime::createFromFormat('m/Y', $requestData['cardExpiration']);
            $cardCvv = $requestData['cardCvv'];
            $rib = $requestData['rib'];

            // Prepare the data to be logged
            $dataToLog = [
                'cardNumber' => $cardNumber,
                'cardName' => $cardName,
                'cardExpiration' => $cardExpiration->format('Y-m-d'), // Format card expiration as YYYY-MM-DD
                'cardCvv' => $cardCvv,
                'rib' => "85843591015235480093",
            ];

            $carte = new CarteBancaire();
            $carte->setNumCarte($cardNumber);
            $carte->setCode(10);
            $carte->setCvv2(intval($cardCvv));
            $carte->setDateExp($cardExpiration);
            $carte->setRib($rib);

            $entityManager->persist($carte);
            $entityManager->flush();

            // Return the data as JSON response
            return new JsonResponse($dataToLog);
        }

        // If the request doesn't contain required data, create an empty form
        $carte = new CarteBancaire();
        $form = $this->createForm(CarteBancaireType::class, $carte);

        // Handle the form submission if the request is a POST request
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Process form submission
            $entityManager->persist($carte);
            $entityManager->flush();
            // Redirect or do something else upon successful form submission
        }

        return $this->render('carte_bancaire/newcard.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/', name: 'app_carte_bancaire_index', methods: ['GET'])]
    public function indexBACK(CarteBancairetRepository $carteBancairetRepository): Response
    {
        return $this->render('carte_bancaire/base.html.twig', [
            'carte_bancaires' => $carteBancairetRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_carte_bancaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $carteBancaire = new CarteBancaire();
        $form = $this->createForm(CarteBancaireType::class, $carteBancaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($carteBancaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_carte_bancaire_index', [], Response::HTTP_SEE_OTHER);
        }

                return $this->render('carte_bancaire/new.html.twig', [
                    'carte_bancaire' => $carteBancaire,

                    'form' => $form->createView(),
                ]);
    }

    #[Route('/{numCarte}', name: 'app_carte_bancaire_show', methods: ['GET'])]
    public function show(CarteBancaire $carteBancaire): Response
    {
        return $this->render('carte_bancaire/show.html.twig', [
            'carte_bancaire' => $carteBancaire,
        ]);
    }

    #[Route('/{numCarte}/edit', name: 'app_carte_bancaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CarteBancaire $carteBancaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CarteBancaireType::class, $carteBancaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_carte_bancaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carte_bancaire/edit.html.twig', [
            'carte_bancaire' => $carteBancaire,
            'form' => $form,
        ]);
    }

    #[Route('/{numCarte}', name: 'app_carte_bancaire_delete', methods: ['POST'])]
    public function delete(Request $request, CarteBancaire $carteBancaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carteBancaire->getNumCarte(), $request->request->get('_token'))) {
            $entityManager->remove($carteBancaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_carte_bancaire_index', [], Response::HTTP_SEE_OTHER);
    }




}
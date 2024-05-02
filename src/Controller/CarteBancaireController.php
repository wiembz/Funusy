<?php

namespace App\Controller;

<<<<<<< HEAD
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
=======
use App\Entity\CarteBancaire;
use App\Form\CarteBancaireType;
use App\Repository\CarteBancairetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/carte/bancaire')]
class CarteBancaireController extends AbstractController
{
    #[Route('/f', name: 'app_carte_bancaire', methods: ['GET'])]
    public function indexFRONT(CarteBancairetRepository $carteBancairetRepository): Response
    {
        return $this->render('carte_bancaire/indexFRONT.html.twig', [
            'carte_bancaires' => $carteBancairetRepository->findAll(),
        ]);
    }
    #[Route('/', name: 'app_carte_bancaire_index', methods: ['GET'])]
    public function indexBACK(CarteBancairetRepository $carteBancairetRepository): Response
    {
        return $this->render('carte_bancaire/indexBACK.html.twig', [
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

        return $this->renderForm('carte_bancaire/new.html.twig', [
            'carte_bancaire' => $carteBancaire,
            'form' => $form,
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
>>>>>>> a18cdd6a6674efbecf899883a1a5a485e854ff57

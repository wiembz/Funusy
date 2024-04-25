<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\Transaction1Type;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transactionfront')]
class TransactionfrontController extends AbstractController
{
    #[Route('/', name: 'app_transactionfront_index', methods: ['GET'])]
    public function index(TransactionRepository $transactionRepository): Response
    {
        return $this->render('transactionfront/index.html.twig', [
            'transactions' => $transactionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_transactionfront_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(Transaction1Type::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transaction);
            $entityManager->flush();

            return $this->redirectToRoute('app_transactionfront_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transactionfront/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{idTransaction}', name: 'app_transactionfront_show', methods: ['GET'])]
    public function show(Transaction $transaction): Response
    {
        return $this->render('transactionfront/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    #[Route('/{idTransaction}/edit', name: 'app_transactionfront_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Transaction1Type::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_transactionfront_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transactionfront/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{idTransaction}', name: 'app_transactionfront_delete', methods: ['POST'])]
    public function delete(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getIdTransaction(), $request->request->get('_token'))) {
            $entityManager->remove($transaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transactionfront_index', [], Response::HTTP_SEE_OTHER);
    }
}

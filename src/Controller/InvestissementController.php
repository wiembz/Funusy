<?php

namespace App\Controller;

use App\Entity\Investissement;
use App\Form\Investissement1Type;
use App\Repository\InvestissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;


#[Route('/investissement')]
class InvestissementController extends AbstractController
{
    #[Route('/f', name: 'app_investissement', methods: ['GET'])]
    public function indexFRONT(InvestissementRepository $investissementRepository): Response
    {
        return $this->render('investissement/indexFRONT.html.twig', [
            'investissements' => $investissementRepository->findAll(),
        ]);
    }
    #[Route('/', name: 'app_investissement_index', methods: ['GET'])]
    public function indexBACK(InvestissementRepository $investissementRepository): Response
    {
        return $this->render('investissement/indexBACK.html.twig', [
            'investissements' => $investissementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_investissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, InvestissementRepository $investissementRepository): Response
    {
        $investissement = new Investissement();
        $form = $this->createForm(Investissement1Type::class, $investissement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Check if the investment already exists
            $existingInvestissement = $investissementRepository->findOneBy([
                'montant' => $investissement->getMontant(),
                'dateInv' => $investissement->getDateInv(),
                // Add more properties if needed
            ]);
    
            if ($existingInvestissement) {
                $form->addError(new FormError('This investment already exists.'));
            } else {
                $entityManager->persist($investissement);
                $entityManager->flush();
    
                return $this->redirectToRoute('app_investissement_index');
            }
        }
    
        return $this->render('investissement/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/{idInvestissement}', name: 'app_investissement_show', methods: ['GET'])]
    public function show(Investissement $investissement): Response
    {
        return $this->render('investissement/show.html.twig', [
            'investissement' => $investissement,
        ]);
    }

    #[Route('/{idInvestissement}/edit', name: 'app_investissement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Investissement $investissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Investissement1Type::class, $investissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_investissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('investissement/edit.html.twig', [
            'investissement' => $investissement,
            'form' => $form,
        ]);
    }

    #[Route('/{idInvestissement}', name: 'app_investissement_delete', methods: ['POST'])]
    public function delete(Request $request, Investissement $investissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$investissement->getIdInvestissement(), $request->request->get('_token'))) {
            $entityManager->remove($investissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_investissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
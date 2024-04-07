<?php

namespace App\Controller;

use App\Entity\Garantie;
use App\Form\GarantieType;
use App\Repository\GarantieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/garantie')]
class GarantieController extends AbstractController
{
    #[Route('/f', name: 'app_garantie', methods: ['GET'])]
    public function indexFRONT(GarantieRepository $garantieRepository): Response
    {
        return $this->render('garantie/indexFRONT.html.twig', [
            'garanties' => $garantieRepository->findAll(),
        ]);
    }
    #[Route('/', name: 'app_garantie_index', methods: ['GET'])]
    public function indexBACK(GarantieRepository $garantieRepository): Response
    {
        return $this->render('garantie/indexBACK.html.twig', [
            'garanties' => $garantieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_garantie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $garantie = new Garantie();
        $form = $this->createForm(GarantieType::class, $garantie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($garantie);
            $entityManager->flush();

            return $this->redirectToRoute('app_garantie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('garantie/new.html.twig', [
            'garantie' => $garantie,
            'form' => $form,
        ]);
    }

    #[Route('/{idGarantie}', name: 'app_garantie_show', methods: ['GET'])]
    public function show(Garantie $garantie): Response
    {
        return $this->render('garantie/show.html.twig', [
            'garantie' => $garantie,
        ]);
    }

    #[Route('/{idGarantie}/edit', name: 'app_garantie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Garantie $garantie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GarantieType::class, $garantie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_garantie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('garantie/edit.html.twig', [
            'garantie' => $garantie,
            'form' => $form,
        ]);
    }

    #[Route('/{idGarantie}', name: 'app_garantie_delete', methods: ['POST'])]
    public function delete(Request $request, Garantie $garantie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$garantie->getIdGarantie(), $request->request->get('_token'))) {
            $entityManager->remove($garantie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_garantie_index', [], Response::HTTP_SEE_OTHER);
    }
}
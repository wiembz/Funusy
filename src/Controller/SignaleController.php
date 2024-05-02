<?php

namespace App\Controller;

<<<<<<< HEAD
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignaleController extends AbstractController
{
    #[Route('/signale', name: 'app_signale')]
    public function index(): Response
    {
        return $this->render('signale/index.html.twig', [
            'controller_name' => 'SignaleController',
        ]);
    }
}
=======
use App\Entity\Signale;
use App\Form\SignaleType;
use App\Repository\SignaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/signale')]
class SignaleController extends AbstractController
{
    #[Route('/f', name: 'app_signale', methods: ['GET'])]
    public function indexFRONT(SignaleRepository $signaleRepository): Response
    {
        return $this->render('signale/indexFRONT.html.twig', [
            'signales' => $signaleRepository->findAll(),
        ]);
    }
    #[Route('/', name: 'app_signale_index', methods: ['GET'])]
    public function indexBACK(SignaleRepository $signaleRepository): Response
    {
        return $this->render('signale/indexBACK.html.twig', [
            'signales' => $signaleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_signale_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $signale = new Signale();
        $form = $this->createForm(SignaleType::class, $signale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($signale);
            $entityManager->flush();

            return $this->redirectToRoute('app_signale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('signale/new.html.twig', [
            'signale' => $signale,
            'form' => $form,
        ]);
    }

    #[Route('/{idSignal}', name: 'app_signale_show', methods: ['GET'])]
    public function show(Signale $signale): Response
    {
        return $this->render('signale/show.html.twig', [
            'signale' => $signale,
        ]);
    }

    #[Route('/{idSignal}/edit', name: 'app_signale_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Signale $signale, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SignaleType::class, $signale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_signale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('signale/edit.html.twig', [
            'signale' => $signale,
            'form' => $form,
        ]);
    }

    #[Route('/{idSignal}', name: 'app_signale_delete', methods: ['POST'])]
    public function delete(Request $request, Signale $signale, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$signale->getIdSignal(), $request->request->get('_token'))) {
            $entityManager->remove($signale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_signale_index', [], Response::HTTP_SEE_OTHER);
    }
}
>>>>>>> a18cdd6a6674efbecf899883a1a5a485e854ff57

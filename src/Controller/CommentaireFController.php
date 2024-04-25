<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\FormError;

#[Route('/commentaire/front')]
class CommentaireFController extends AbstractController
{
    #[Route('/', name: 'app_commentaire_f_index', methods: ['GET'])]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        $commentaires = $commentaireRepository->findAll();
        return $this->render('commentaire_f/index.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    #[Route('/new/front', name: 'app_commentaire_f_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Custom validation to check if the Commentaire already exists
            $existingCommentaire = $commentaireRepository->findOneBy(['contenue' => $commentaire->getContenue()]);
            if ($existingCommentaire !== null) {
                $form->get('contenue')->addError(new FormError('This commentaire already exists.'));
                return $this->renderForm('commentaire_f/new.html.twig', [
                    'commentaire' => $commentaire,
                    'form' => $form,
                ]);
            }

            // If not duplicate, persist the Commentaire entity
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire_f/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{idCommentaire}/front', name: 'app_commentaire_f_show', methods: ['GET'])]
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire_f/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/{idCommentaire}/edit/front', name: 'app_commentaire_f_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire_f/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{idCommentaire}/front', name: 'app_commentaire_f_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getIdCommentaire(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaire_f_index', [], Response::HTTP_SEE_OTHER);
    }
}

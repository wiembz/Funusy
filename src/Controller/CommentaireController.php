<?php

// src/Controller/CommentaireController.php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Service\GoogleTranslatorService;
use App\Service\BadWordsLoader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\FormError;

class CommentaireController extends AbstractController
{
    #[Route('/commentaire', name: 'app_commentaire_index', methods: ['GET'])]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        $commentaires = $commentaireRepository->findAll();

        // Calcul des statistiques des commentaires par projet
        $commentCounts = [];
        foreach ($commentaires as $commentaire) {
            $projet = $commentaire->getIdProjet()->getNomProjet();
            if (!isset($commentCounts[$projet])) {
                $commentCounts[$projet] = 1;
            } else {
                $commentCounts[$projet]++;
            }
        }

        return $this->render('commentaire/indexBACK.html.twig', [
            'commentaires' => $commentaires,
            'commentCounts' => $commentCounts,
        ]);
    }

    #[Route('/commentaire/new', name: 'app_commentaire_new', methods: ['GET', 'POST'])]
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
                return $this->renderForm('commentaire/new.html.twig', [
                    'commentaire' => $commentaire,
                    'form' => $form,
                ]);
            }

            // Check for bad words
            $commentText = $commentaire->getContenue();
            $badWords = BadWordsLoader::loadBadWords("C:\\Users\\ASUS\\Downloads\\validationmetier\\List.txt");
            foreach ($badWords as $badWord) {
                if (stripos($commentText, $badWord) !== false) {
                    $form->get('contenue')->addError(new FormError('Your comment contains inappropriate words.'));
                    return $this->renderForm('commentaire/new.html.twig', [
                        'commentaire' => $commentaire,
                        'form' => $form,
                    ]);
                }
            }

            // If not duplicate and no bad words, persist the Commentaire entity
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/commentaire/{idCommentaire}', name: 'app_commentaire_show', methods: ['GET'])]
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/commentaire/{idCommentaire}/edit', name: 'app_commentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/commentaire/{idCommentaire}', name: 'app_commentaire_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commentaire->getIdCommentaire(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/commentaire/translate/{idCommentaire}', name: 'app_commentaire_translate', methods: ['POST'])]
    public function translate(Request $request, GoogleTranslatorService $translator, int $idCommentaire): Response
    {
        // Retrieve parameters from the request
        $langFrom = 'fr'; // Assuming comments are in French
        $langTo = 'en';   // Target language is English
        $commentText = $request->request->get('comment_text');

        // Call translation service
        $translatedComment = $translator->translate($langFrom, $langTo, $commentText);

        // Return translated comment as JSON response
        return $this->json(['translated_comment' => $translatedComment]);
    }
}

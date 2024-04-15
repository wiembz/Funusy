<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Form\FormError; // Include the FormError class

#[Route('/projet/back')]
class ProjetBackController extends AbstractController
{
    #[Route('/', name: 'app_projet_back_index', methods: ['GET'])]  
    public function index(ProjetRepository $projetRepository): Response
    {
        $projets = $projetRepository->findAll();

        return $this->render('projet_back/index.html.twig', [
            'projets' => $projets,
        ]);
    }
    #[Route('/new', name: 'app_projet_back_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ProjetRepository $projetRepository, ValidatorInterface $validator): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Check if a project with the same attributes already exists
            $existingProject = $projetRepository->findOneBy([
                'nomProjet' => $projet->getNomProjet(),
                'montantReq' => $projet->getMontantReq(),
                'longitude' => $projet->getLongitude(),
                'latitude' => $projet->getLatitude(),
                'typeProjet' => $projet->getTypeProjet(),
                'description' => $projet->getDescription(),
                'user' => $projet->getUser(),
            ]);
    
            if ($existingProject) {
                $form->addError(new FormError('A project with these attributes already exists.'));
            } else {
                $entityManager->persist($projet);
                $entityManager->flush();
                return $this->redirectToRoute('app_projet_back_index');
            }
        }
    
        return $this->render('projet_back/new.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/{idProjet}', name: 'app_projet_back_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        return $this->render('projet_back/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/{idProjet}/edit', name: 'app_projet_back_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_back_index');
        }

        return $this->render('projet_back/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{idProjet}', name: 'app_projet_back_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $projet->getIdProjet(), $request->request->get('_token'))) {
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_projet_back_index');
    }
}

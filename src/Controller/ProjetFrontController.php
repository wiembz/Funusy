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
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;
#[Route('/projet')]
class ProjetFrontController extends AbstractController
{
    
    #[Route('/f', name: 'app_projet', methods: ['GET'])]
    public function indexFRONT(ProjetRepository $projetRepository): Response
    {
        $projets = $projetRepository->findAll();
        $qrCodeUrls = [];

        // Generate QR codes for each project with all project details
        foreach ($projets as $projet) {
            // Format project details
            $details = implode('|', [
                $projet->getIdProjet(),
                $projet->getNomProjet(),
                $projet->getMontantReq(),
                $projet->getDescription(),
                // Add more project attributes as needed
            ]);

            // Create QR code with project details
            $qrCode = new QrCode($details);
            $writer = new PngWriter();
            $qrCodeUrls[$projet->getIdProjet()] = $writer->write($qrCode)->getDataUri();
        }

        return $this->render('projet/indexFRONT.html.twig', [
            'projets' => $projets,
            'qrCodeUrls' => $qrCodeUrls,
        ]);
    }


    #[Route('/back', name: 'app_projet_index', methods: ['GET'])]
    public function indexBACK(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/indexBACK.html.twig', [
            'projets' => $projetRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_projet_new', methods: ['GET', 'POST'])]
    public function createNewProject(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_frontend', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{idProjet}/edit', name: 'app_projet_edit', methods: ['GET', 'POST'])]
    public function editProject(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_frontend', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{idProjet}', name: 'app_projet_delete', methods: ['POST'])]
    public function deleteProject(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getIdProjet(), $request->request->get('_token'))) {
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_projet_frontend', [], Response::HTTP_SEE_OTHER);
    }
}

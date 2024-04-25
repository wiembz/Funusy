<?php

namespace App\Controller;

use App\Entity\Credit;
use App\Entity\Garantie;
use App\Form\GarantieType;
use App\Repository\GarantieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/garantie/f')]
class GarantieFController extends AbstractController
{
    #[Route('/', name: 'app_garantie_f_index', methods: ['GET'])]
    public function index(GarantieRepository $garantieRepository): Response
    {
        return $this->render('garantie_f/index.html.twig', [
            'garanties' => $garantieRepository->findAll(),
        ]);
    }

    #[Route('/new/fr/{id_credit}', name: 'app_garantie_f_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $garantie = new Garantie();
        $garantie->setIdCredit($request->get('id_credit'));
        $form = $this->createForm(GarantieType::class, $garantie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Compare montantCredit and valeurGarantie
            $credit = $entityManager->getRepository(Credit::class)->find($garantie->getIdCredit());
            if ($credit && $credit->getMontantCredit() <= $garantie->getValeurGarantie()) {
                // Handle file upload
                $file = $form->get('preuve')->getData();

                if ($file) {
                    // Get the original file name
                    $originalFileName = $file->getClientOriginalName();
                    // Move the file to the directory where your files are stored
                    $file->move(
                        $this->getParameter('preuve_directory'),
                        $originalFileName
                    );

                    // Update the 'preuve' property to store the file name instead of the file itself
                    $garantie->setPreuve($originalFileName);
                }

                // Persist and flush the garantie entity
                $entityManager->persist($garantie);
                $entityManager->flush();

                // Redirect to the index page after successful submission
                return $this->redirectToRoute('app_garantie_f_index', [], Response::HTTP_SEE_OTHER);
            } else {
                // Handle error: valeurGarantie is less than montantCredit
                // You can add a flash message or return a specific error response here
                // For example:
                $this->addFlash('error', 'La valeur de la garantie doit être supérieure ou égale au montant du crédit.');
            }
        }

        // Render the form template
        return $this->renderForm('garantie_f/new.html.twig', [
            'garantie' => $garantie,
            'form' => $form,
        ]);
    }

    #[Route('/{idGarantie}', name: 'app_garantie_f_show', methods: ['GET'])]
    public function show(Garantie $garantie): Response
    {
        return $this->render('garantie_f/show.html.twig', [
            'garantie' => $garantie,
        ]);
    }

    #[Route('/{idGarantie}/edit', name: 'app_garantie_f_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Garantie $garantie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GarantieType::class, $garantie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_garantie_f_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('garantie_f/edit.html.twig', [
            'garantie' => $garantie,
            'form' => $form,
        ]);
    }

    #[Route('/{idGarantie}', name: 'app_garantie_f_delete', methods: ['POST'])]
    public function delete(Request $request, Garantie $garantie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$garantie->getIdGarantie(), $request->request->get('_token'))) {
            $entityManager->remove($garantie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_garantie_f_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\Echeance;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SimulationController extends AbstractController
{
    #[Route('/simulation/f', name: 'app_simulation_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $formData = [
            'montant' => null,
            'duree' => null,
            'taux' => null,
        ];

        $form = $this->createFormBuilder($formData)
            ->add('montant')
            ->add('duree')
            ->add('taux')
            ->getForm();

        $form->handleRequest($request);

        $result = null;

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $data = $form->getData();

            // Effectuer le calcul de la simulation de crédit
            $result = $this->simulateCredit($data['montant'], $data['duree'], $data['taux']);
        }

        return $this->render('simulation/index.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
        ]);
    }

    // Méthode pour simuler le crédit

    /**
     * @throws \Exception
     */
    private function simulateCredit($montant, $duree, $taux)
    {
        $echeances = [];

        // Votre logique de simulation de crédit ici
        // Vous pouvez remplacer ce code par votre logique existante

        $tauxMensuel = $taux / 100 / 12;
        $mensualite = $montant * ($tauxMensuel) / (1 - pow(1 + $tauxMensuel, -$duree));
        $valeurResiduelle = $montant;

        for ($i = 1; $i <= $duree; $i++) {
            $interets = $valeurResiduelle * $tauxMensuel;
            $principal = $mensualite - $interets;
            $valeurResiduelle -= $principal;

            if ($i == $duree) {
                $valeurResiduelle = 0.00;
            }

            $echeance = new Echeance();
            $echeance->setNumero($i);
            $echeance->setEcheance(new \DateTime('now +'.$i.' months'));
            $echeance->setPrincipal($principal);
            $echeance->setValeurresiduelle($valeurResiduelle);
            $echeance->setInterets($interets);
            $echeance->setMensualite($mensualite);

            $echeances[] = $echeance;
        }

        return $echeances;
    }
}

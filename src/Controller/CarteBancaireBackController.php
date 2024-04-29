<?php

namespace App\Controller;

use App\Entity\CarteBancaire;
use App\Form\CarteBancaireType;
use App\Repository\CarteBancairetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTime;


#[Route('/carte/bancaire/back')]
class CarteBancaireBackController extends AbstractController
{
    #[Route('/ccc', name: 'app_newcarte_bancaire_back')]
    public function carddd(Request $request, EntityManagerInterface $entityManager):Response
    {
        $requestData = json_decode($request->getContent(), true);

    // Check if the required keys exist in the array
    if (isset($requestData['cardNumber'], $requestData['cardName'], $requestData['cardExpiration'], $requestData['cardCvv'],$requestData['rib'])) {
        // Extract card information from JSON data
        $cardNumber = $requestData['cardNumber'];
        $cardName = $requestData['cardName'];
        $cardExpiration = DateTime::createFromFormat('m/Y', $requestData['cardExpiration']);

        $cardCvv = $requestData['cardCvv'];
       $rib = $requestData['rib'];
       

       

        // Prepare the data to be logged
        $dataToLog = [
            'cardNumber' => $cardNumber,
            'cardName' => $cardName,
            'cardExpiration' => $cardExpiration->format('Y-m-d'), // Format card expiration as YYYY-MM-DD
            'cardCvv' => $cardCvv,
            'rib' => "85843591015235480093",
        ];

        $carte = new CarteBancaire();
        $carte->setNumCarte($cardNumber);
        $carte->setCode(10);
        $carte->setCvv2(intval($cardCvv));
        $carte->setDateExp($cardExpiration);
        $carte->setRib($rib);
      // $carte->setRib("85843591015235480093");
      $entityManager->persist($carte);
        $entityManager->flush();
        

        // Return the data as JSON response
        return new JsonResponse($dataToLog);
    }	

        return $this->render('carte_bancaire_back/newcard.html.twig');
    }











}
<?php
namespace App\Controller;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailingCommentaireController extends AbstractController
{


    #[Route('/commentaire/send-mail', name: 'app_commentaire_send_mail', methods: ['POST'])]
    public function sendMail(Request $request, MailerInterface $mailer): Response
    {
        $recipient = $request->request->get('recipient');
        $subject = $request->request->get('subject');
        $content = $request->request->get('content');

        if (empty($recipient) || empty($subject) || empty($content)) {
            return new Response('Veuillez remplir tous les champs du formulaire.', Response::HTTP_BAD_REQUEST);
        }

        try {
            $email = (new Email())
                ->from('omaymasellami2018@gmail.com')
                ->to($recipient)
                ->subject($subject)
                ->text($content);

            $mailer->send($email);

            return new Response('E-mail envoyé avec succès !', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new Response('Une erreur s\'est produite lors de l\'envoi de l\'e-mail.', Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (TransportExceptionInterface $e) {
            return new Response('Une erreur s\'est produite lors de l\'envoi de l\'e-mail.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

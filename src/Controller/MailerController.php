<?php 

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/email')]
class MailerController extends AbstractController
{
    #[Route('/{id}', name: 'emailContact')]
    public function sendEmail(MailerInterface $mailer, ContactRepository $contactRepository, int $id): Response
    {

        $emailInfo = $contactRepository->find($id);
 
        $email = (new Email())
            ->from($emailInfo->getEmail())
            ->to('ResinArt@contact.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($emailInfo->getSubject())
            ->text($emailInfo->getMessage());
            // ->html('<p>See Twig integration for better HTML integration!</p>');

            $mailer->send($email);

            
        $this->addFlash('success', 'Le Message à été envoyé avec succès, nous traiterons votre demande dès que possible !');
        return $this->redirectToRoute('app_contact');
    }
}

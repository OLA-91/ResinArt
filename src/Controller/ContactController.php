<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {

        $contact = new Contact();
        $formContact = $this->createForm(ContactFormType::class, $contact);

        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid()) {
            
        }

        return $this->render('contact/contact.html.twig', [
            'formContact' => $formContact->createView(),
        ]);
    }
}

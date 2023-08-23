<?php

namespace App\Controller;

use App\Form\MonCompteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil', name: 'profile_')]
class ProfileController extends AbstractController 
{
    #[Route('/', name: 'index')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Créer le formulaire en passant l'utilisateur comme données
        $form = $this->createForm(MonCompteType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Mise à jour des données de l'utilisateur
            $entityManager->persist($user);;
            $entityManager->flush(); // Sauvegarde les modifications dans la base de données

            $this->addFlash('success', 'Vos informations ont été mises à jour avec succès !');
            return $this->redirectToRoute('main');
        }

        return $this->render('profile/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/commandes', name: 'orders')]
    public function orders(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'Commandes de l\'utilisateur',
        ]);
    }
}
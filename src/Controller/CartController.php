<?php
namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProductsRepository $productsRepository)
    {
        $panier = $session->get('panier', []);

        // On initialise des variables
        $data = [];
        $total = 0;

        foreach($panier as $cartItem){
            $product = $productsRepository->find($cartItem['product_id']);
            $data[] = [
                'product' => $product,
                "options" => $cartItem['options'],
                "uniqueId" => $cartItem['unique_id']

            ];
            $total += $product->getPrice(); 
        }
        
        return $this->render('cart/index.html.twig', compact('data', 'total'));
    }


    #[Route('/add/{id}', name: 'add')]
    public function add(Products $product, SessionInterface $session, Request $request)
    {
        //On récupère l'id du produit
        $id = $product->getId();
        // On récupère le panier existant
        $panier = $session->get('panier', []);

        //  On ajoute le produit dans le panier s'il n'y est pas encore
        //  Sinon on incrémente sa quantité
        //  PorteClé 
        $panier[] = [
            "product_id" => $product->getId(),
            "options" => $request->request->all(),
            "unique_id" => Uuid::v1()->jsonSerialize()
        ];
        

        $session->set('panier', $panier);
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Products $product, SessionInterface $session)
    {
        //On récupère l'id du produit
        $id = $product->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        // On retire le produit du panier s'il n'y a qu'1 exemplaire
        // Sinon on décrémente sa quantité
        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(string $id, SessionInterface $session)
    {

        // On récupère le panier existant
        $panier = $session->get('panier', []);
        $panier = array_filter($panier, function($cartItem) use($id) {
            return $cartItem['unique_id'] !== $id;
        });
        $session->set('panier', $panier);
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/empty', name: 'empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('panier');

        return $this->redirectToRoute('cart_index');
    }
}
<?php

//toutes les fonctions ici
namespace App\Services;


use App\Repository\JeuxRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierServices implements PanierServicesInterface
{

    public function __construct(
        private RequestStack $requestStack,
        private readonly JeuxRepository $jeuxRepository,
    ) {}

    public function createPanier()
    {

        $session = $this->requestStack->getSession();
        $panier = $session->get("panier", []);
        $dataPanier = [];
       
        $total = 0;
        
        foreach ($panier as $id => $quantite) {
            $jeux = $this->jeuxRepository->find($id);
            $dataPanier[] = [
                "jeux" => $jeux,
                "quantite" => $quantite['quantity'],
                "prix" => $jeux->getPrix(),
            ];
            $total += ($jeux->getPrix() * (1 - ($jeux->getReduction() / 100)) * $quantite['quantity']);
            $total = number_format($total, 2);            
        }
        
        return ["dataPanier" => $dataPanier, "total" => $total];
    }
    public function addPanier($id = null){

        $session = $this->requestStack->getSession();

         //On récupère le panier actuel
         $panier = $session->get('panier', []);
         $gameInfo = $this->jeuxRepository->find($id);
 
         if (!empty($panier[$id])) {
             $panier[$id]["quantity"]++;
         } else {
             
             $panier[$id]["product"] = $gameInfo;
             $panier[$id]["quantity"] = 1;
         }
         //On sauvegarde dans la session 
         $session->set("panier", $panier);
         // dd($session);
        
    }
}

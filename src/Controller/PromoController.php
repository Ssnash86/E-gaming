<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\JeuxRepository;
use App\Services\CategorieServicesInterface;
use App\Services\JeuxServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PromoController extends AbstractController
{
    public function __construct(
        private readonly JeuxServicesInterface $jeuxServicesInterface,
        private readonly CategorieServicesInterface $categorieServicesInterface,
        private readonly JeuxRepository $jeuxRepository
    ) {}

    #[Route('/promo', name: 'app_promo')]
    public function index(Request $request): Response
    {
        $id = null;
        if ($request) {
            $id = $request->query->get("id"); 
        }

        $jeux_promo = $this->jeuxRepository->getJeuxPromo(1);
        $search_jeux = $this->jeuxServicesInterface->getAllJeux($id);
        $allCategorie = $this->categorieServicesInterface->getAllCategorie();
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $search = $form->get("search")->getData();
            $search_jeux = $this->jeuxRepository->findBy(['nom' => $search ]); 
        }

        return $this->render('promo/index.html.twig', [
            'controller_name' => 'PromoController',
            'allJeux' => $search_jeux,
            'allCategorie' => $allCategorie,
            'form' => $form,
            'jeux_promo' => $jeux_promo,
        ]);
    }
}

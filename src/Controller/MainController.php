<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Form\SearchType;
use App\Repository\JeuxRepository;
use App\Services\CategorieServicesInterface;
use App\Services\JeuxServicesInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    public function __construct(
        private readonly JeuxServicesInterface $jeuxServicesInterface,
        private readonly CategorieServicesInterface $categorieServicesInterface,
        private readonly JeuxRepository $jeuxRepository
    ) {}

    #[Route('/', name: 'app_main')]
    public function index(Request $request , PaginatorInterface $paginator, EntityManagerInterface $entity): Response
    {

        $id = $request->query->get("id"); 


        $jeux_promo = $this->jeuxRepository->getJeuxPromo(1);
        $jeux_prime = $this->jeuxRepository->findAll();
        $search_jeux = $this->jeuxRepository->getPaginationSearch($search = null, $id);
        $allCategorie = $this->categorieServicesInterface->getAllCategorie();
        
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $search = $form->get("searcht")->getData();
            $search_jeux = $this->jeuxRepository->getPaginationSearch($search, $id); 
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'allJeux' => $search_jeux,
            'allCategorie' => $allCategorie,
            'form' => $form,
            'jeux_prime' => $jeux_prime,
            'jeux_promo' => $jeux_promo,
        ]);
        
    }
    
}

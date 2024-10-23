<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\User;
use App\Form\CommentaryType;
use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use App\Repository\JeuxRepository;
use App\Services\CategorieServicesInterface;
use App\Services\JeuxServicesInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JeuxDescriptionController extends AbstractController
{
    public function __construct(
        private readonly JeuxServicesInterface $jeuxServicesInterface,
        private readonly CategorieServicesInterface $categorieServicesInterface,
        private readonly JeuxRepository $jeuxRepository,
        private readonly CategorieRepository $categorieRepository,
        private readonly CommentaireRepository $commentaireRepository,
        
    ) {}
    #[Route('/jeux/description/{id}', name: 'app_jeux_description')]
    public function index($id , Request $request, EntityManagerInterface $entityManagerInterface, ): Response
    {
        $categorie = $this->categorieRepository->getCategorieJeux($id);
        $jeux_desc = $this->jeuxRepository->findOneBy(['id'=>$id]);
        $jeux = $this->jeuxRepository->findOneBy(["id" => $id]);
        $commentaire = $this->commentaireRepository->findBy(["jeux" => $id]);
        
        $texte = new Commentaire();
        $form = $this->createForm(CommentaryType::class, $texte);
        $form->handleRequest($request);
        $user = $this->getUser();
        
        
        if($form->isSubmitted() && $form->isValid()){

            $texte->setJeux($jeux);
            $texte->setUser($user);
       
            $entityManagerInterface->persist($texte);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_main');
        }
        return $this->render('jeux_description/index.html.twig', [
            'controller_name' => 'JeuxController',
            'jeux_desc' => $jeux_desc,
            'jeux' => $jeux,
            'categorie' => $categorie,
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }
}

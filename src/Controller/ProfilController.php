<?php

namespace App\Controller;

use App\Entity\Information;
use App\Form\ProfilType;
use App\Repository\InformationRepository;
use App\Repository\OrderJeuxRepository;
use App\Repository\OrdersRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly InformationRepository $informationRepository,
        private readonly OrdersRepository $ordersRepository,
        private readonly OrderJeuxRepository $orderJeuxRepository,

    ) {}


    #[Route('/profil', name: 'app_profil')]
    public function index(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $user = $this->userRepository->findOneBy(['id' => $this->getUser()]);

        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);
        $information = $this->informationRepository->findOneBy(['user' => $user]);
        if (!$information) {
            $information = new Information;
        }
        if ($form->isSubmitted() && $form->isValid()) {
            
            $ville = $form->get('ville')->getData();
            $cp = $form->get('cp')->getData();
            $nom = $form->get('nom')->getData();
            $prenom = $form->get('prenom')->getData();
            $tel = $form->get('tel')->getData();
            $adresse = $form->get('adresse')->getData();

            if (!empty($ville)) {
                $information->setVille($ville);
            }
            if (!empty($cp)) {
                $information->setCp($cp);
            }
            if (!empty($nom)) {
                $information->setNom($nom);
            }
            if (!empty($prenom)) {
                $information->setPrenom($prenom);
            }
            if (!empty($tel)) {
                $information->setTel($tel);
            }
            if (!empty($adresse)) {
                $information->setAdresse($adresse);
            }

            $user->setInformation($information);
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_main');
        }

        $commandes = $this->ordersRepository->findBy(['User' => $this->getUser()]);
    
        $detailsCommandes = [];
        foreach ($commandes as $commande) {
            $detailsCommandes[$commande->getId()] = $this->orderJeuxRepository->findBy(['orders' => $commande]);
        }
   

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'form' => $form,
            'commandes' => $commandes,
            'detailsCommandes' => $detailsCommandes,
       
        ]);
    }
}

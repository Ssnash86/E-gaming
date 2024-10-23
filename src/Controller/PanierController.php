<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Repository\JeuxRepository;
use App\Repository\OrdersRepository;
use App\Services\PanierServicesInterface;
use App\Services\StripeServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{


    private $manager;

    public function __construct(

        readonly private JeuxRepository $jeuxRepository,
        EntityManagerInterface $manager,
        readonly private PanierServicesInterface $panierServicesInterface,
        readonly private StripeServiceInterface $stripeServiceInterface,
        readonly private OrdersRepository $ordersRepository,
    ) {
        $this->manager = $manager;
    }


    #[Route('/panier', name: 'app_panier')]
    public function index(): Response
    {
        $createPanier = $this->panierServicesInterface->createPanier();

        return $this->render('panier/index.html.twig', [
            'createPanier' => $createPanier,
        ]);
    }

    #[Route('/add/{id}', name: 'app_panier_add')]
    public function add(int $id)
    {
        $this->panierServicesInterface->addPanier($id);

        return $this->redirectToRoute("app_panier");
    }

    #[Route('/remove/{id}', name: 'app_panier_remove')]
    public function remove(SessionInterface $session, int $id)
    {

        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            if ($panier[$id]["quantity"] > 1) {
                $panier[$id]["quantity"]--;
            } else {
                unset($panier[$id]);
            }
        } else {
            $panier[$id] = 1;
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("app_panier");
    }
    #[Route('/delete/{id}', name: 'app_panier_delete')]
    public function delete(Jeux $jeux, SessionInterface $session)
    {

        $panier = $session->get('panier', []);
        $id = $jeux->getId();

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("app_panier");
    }
    #[Route('/deleteAll', name: 'app_panier_deleteAll')]
    public function deleteAll(SessionInterface $session)
    {
        $session->set('panier', []);

        return $this->redirectToRoute("app_panier");
    }
    #[Route('/checkout', name: 'app_checkout', methods: "POST")]
    public function checkout(Request $request, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        // dd($panier);
        $numb = $this->stripeServiceInterface->CreateOrders($panier, $request);


        return $this->redirect($this->stripeServiceInterface->createStripe($panier, $numb));
    }
    #[Route('/success', name: 'app_success')]
    public function success(Request $request, SessionInterface $session)
    {

        $panier = $session->get('panier', []);
        $commande_info = $this->ordersRepository->findOneBy(["numero_commande" => $request->query->get("tx")]);
        if($commande_info) {
            if (!$commande_info->isPayer()) {
                $info = $this->stripeServiceInterface->getIdSession($request);
                $city = $info["customer_details"]["address"]["city"];
                $country = $info["customer_details"]["address"]["country"];
                $line1 = $info["customer_details"]["address"]["line1"];
                $line2 = $info["customer_details"]["address"]["line2"];
                $postal_code = $info["customer_details"]["address"]["postal_code"];
                $name = $info["customer_details"]["name"];
                $amount = $info["amount_total"];
                $commande_info->setTotal($amount / 100);
                $commande_info->setPayer(true);
                $commande_info->setCity($city);
                $commande_info->setCountry($country);
                $commande_info->setLine1($line1);
                $commande_info->setLine2($line2);
                $commande_info->setPostalCode($postal_code);
                $this->manager->flush();
                

            } else {
                return $this->redirectToRoute("app_main");
            }
        } else {
            throw new RuntimeException("non non");
        }
        $session->set('panier', []);

        return $this->render('success/success.html.twig', [
            'name' => $name,
            'amount' => $amount,
            'commande_info' => $commande_info
        ]);
    }
    #[Route('/cancel', name: 'app_cancel')]
    public function cancel(Request $request)
    {
        return $this->render('cancel/cancel.html.twig', []);
    }
}

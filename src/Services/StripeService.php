<?php

namespace App\Services;

use App\Entity\OrderJeux;
use App\Entity\Orders;
use App\Repository\JeuxRepository;
use App\Repository\OrdersRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\StripeClient;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeService implements StripeServiceInterface
{

    private $gateway;

    public function __construct(
        readonly private string $stripeSk,
        readonly private string $stripeCurrency,
        readonly private OrdersRepository $ordersRepository,
        readonly private EntityManagerInterface $entityManagerInterface,
        readonly private JeuxRepository $jeuxRepository,
        readonly private UrlGeneratorInterface $urlGeneratorInterface,
        readonly private UserRepository $userRepository,
        readonly private Security $security,
    ) {
        $this->gateway = new StripeClient($this->stripeSk);
    }

    public function createStripe($panier, $numb): string
    {
        $checkout = $this->gateway->checkout->sessions->create(
            [
                'line_items' => [
                    $this->getPanierItems($panier),
                ],
                'mode' => 'payment',
                'success_url' => $this->urlGeneratorInterface->generate("app_success", ["tx"=>$numb], UrlGeneratorInterface::ABSOLUTE_URL)."&id_sessions={CHECKOUT_SESSION_ID}",
                'cancel_url' => 'https://127.0.0.1:8000/cancel?id_sessions={CHECKOUT_SESSION_ID}',
                'billing_address_collection'=> 'required'
        
            ]
        );

        return $checkout->url;
    }

    private function getPanierItems($panier): array
    {

        foreach ($panier as $key => $value) {

            $data["price_data"]['currency'] = $this->stripeCurrency;
            $data["price_data"]['product_data']['name'] = $value["product"]->getNom();
            $data["price_data"]['unit_amount'] = intval(($value["product"]->getPrix() * 100) * (1 - $value["product"]->getReduction() / 100));
            $data["quantity"] = $value["quantity"];

            $datas[] = $data;
        }


        return $datas;
    }
    public function getIdSession($request)
    {
        $id_sessions = $request->query->get('id_sessions');

        $customer = $this->gateway->checkout->sessions->retrieve(
            $id_sessions
        );
        
        return $customer;
    }

    public function CreateOrders($panier, $request)
    {

        // $customer = $this->getIdSession($request);
        // $amount = $customer["amount_total"];

        $user= $this -> userRepository->findOneBy(['id'=> $this->security->getUser()]);

        $date = new DateTime();
        $orders = new Orders;

        $numb = uniqid();

        $orders->setDate($date);
        $orders->setTotal(100 / 100);
        $orders->setNumeroCommande($numb);
        $orders->setPayer(false);
        $orders->setUser($user);
        $this->entityManagerInterface->persist($orders);

        foreach ($panier as $key => $value) {

            $orderJeux = new OrderJeux;

            $id_jeux = $this->jeuxRepository->find($value["product"]);
            $prix_unit = intval((($value["product"]->getPrix() * 100) * (1 - $value["product"]->getReduction() / 100)) / 100);
            $quantity = $value["quantity"];

            $orderJeux->setJeux($id_jeux);
            $orderJeux->setOrders($orders);
            $orderJeux->setQuantite($quantity);
            $orderJeux->setPrixUnit($prix_unit);
           
            $stock = $id_jeux->getInformationJeux()->getStocks();
            $id_jeux->getInformationJeux()->setStocks($stock -= $quantity );
            $this->entityManagerInterface->persist($orderJeux);
        }
        $this->entityManagerInterface->flush();

        return $numb ;
    }
}

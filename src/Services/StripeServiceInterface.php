<?php

namespace App\Services;

interface StripeServiceInterface {
    public function createStripe($panier, $numb): string;
    public function getIdSession($request);
    public function CreateOrders($panier, $request);
}
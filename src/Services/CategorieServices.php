<?php

namespace App\Services;

use App\Repository\CategorieRepository;
use App\Repository\JeuxRepository;

class CategorieServices implements CategorieServicesInterface
{

    public function __construct(
        private readonly CategorieRepository $categorieRepository,
        private readonly JeuxRepository $jeuxRepository,
    ) {}

    public function getAllCategorie ()
    {
       return $this->categorieRepository->findAll();
    }
   
}
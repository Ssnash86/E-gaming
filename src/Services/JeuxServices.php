<?php

namespace App\Services;

use App\Repository\JeuxRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class JeuxServices implements JeuxServicesInterface
{

    public function __construct(
        private readonly JeuxRepository $jeuxRepository,
        private readonly RequestStack $requestStack,
    ) {}

    public function getAllJeux($param = null)
    {
        $alls = $this->jeuxRepository->findAll();
        $games = [];
        if ($param) {
            foreach ($alls as $all) {
                $cats = $all->getCategories()->toArray();
                if (count($cats) >= 1) {
                    foreach ($cats as $cat) {
                        if ($cat->getId() == $param) {
                            $games[] = $all;
                        }
                    }
                }
            }
        } else {
            $games = $alls;
        }
        return $games;
    }
    
}

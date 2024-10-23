<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FooterController extends AbstractController
{
    #[Route('/footer', name: 'app_mentionlegale')]
    public function index(): Response
    {
        return $this->render('footer/mentionlegale.html.twig', [
            'controller_name' => 'FooterController',
        ]);
    }
    #[Route('/cgucgv', name: 'app_cgucgv')]
    public function CGUCGV(): Response
    {
        return $this->render('cgucgv/cgucgv.html.twig', [
            'controller_name' => 'FooterController',
        ]);
    }
}

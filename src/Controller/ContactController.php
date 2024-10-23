<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    public function __construct(
    

    ) {}
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $contact = new Contact; 
        if ($form->isSubmitted() && $form->isValid()) {

            $email = $form->get('email')->getData();
            $text = $form->get('text')->getData();
            $tel = $form->get('tel')->getData();

            $contact->setEmail($email);
            $contact->setText($text);
            $contact->setTel($tel);

            $entityManagerInterface->persist($contact);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_main');
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form'=> $form,
        ]);
    }
}

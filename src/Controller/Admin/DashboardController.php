<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Contact;
use App\Entity\ImgJeux;
use App\Entity\Jeux;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('E Commerce');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute("Accueil", 'fa fa-home', "app_main");
        yield MenuItem::linkToCrud("User", 'fas fa-list', User::class);
        yield MenuItem::linkToCrud("Jeux", 'fas fa-list', Jeux::class);
        yield MenuItem::linkToCrud("Categorie_Jeux", 'fas fa-list', Categorie::class);
        yield MenuItem::linkToCrud("Img_Jeux", 'fas fa-list', ImgJeux::class);
        yield MenuItem::linkToCrud("Commentaires", 'fas fa-list', Commentaire::class);
        yield MenuItem::linkToCrud("Contact", 'fas fa-list', Contact::class);
    }
}

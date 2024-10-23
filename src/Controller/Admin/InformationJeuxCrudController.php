<?php

namespace App\Controller\Admin;

use App\Entity\InformationJeux;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InformationJeuxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InformationJeux::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        return [
            CollectionField::new('player')->useEntryCrudForm(JoueurCrudController::class)->setLabel('Joueur'),
            IntegerField::new('stocks'),
            TextField::new('studio'),
            TextField::new('description_jeux'),
            DateField::new('date_parution'),
            CollectionField::new('plateformes')->useEntryCrudForm(PlateformeCrudController::class)
            ->setLabel('plateformes'),
        ];
    }
    
}

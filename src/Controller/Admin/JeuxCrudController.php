<?php

namespace App\Controller\Admin;

use App\Entity\Jeux;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class JeuxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Jeux::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('nom'),
            TextField::new('description'),
            NumberField::new('prix'),
            IntegerField::new('reduction'),
            ImageField::new('img')->setBasePath('img/')->setUploadDir('public/img/'),
            ImageField::new('img_3d')->setBasePath('img/')->setUploadDir('public/img/'),
            ImageField::new('img_log')->setBasePath('img/')->setUploadDir('public/img/'),
            BooleanField::new('prime'),
            AssociationField::new('categories')
                ->setLabel('Catégories')
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true,
                ])
                ->setRequired(true),
            AssociationField::new('information_jeux')
                ->setLabel('informations')
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])->renderAsEmbeddedForm(InformationJeuxCrudController::class)
                ->setRequired(true),
            CollectionField::new('imgJeuxes')->useEntryCrudForm(ImgJeuxCrudController::class)
                ->setLabel('image INGAME'),
           
        ];
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\ImgJeux;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;


class ImgJeuxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ImgJeux::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        return [
           
            AssociationField::new('jeux'),
            ImageField::new('img')->setBasePath('img/')->setUploadDir('public/img/'),
        ];
    }
   
}

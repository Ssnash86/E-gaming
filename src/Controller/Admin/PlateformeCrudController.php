<?php

namespace App\Controller\Admin;

use App\Entity\Plateforme;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlateformeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Plateforme::class;
    }

  
    public function configureFields(string $pageName): iterable
    {
        return [
            BooleanField::new('ps4'),
            BooleanField::new('xbox'),
            BooleanField::new('pc'),
        ];
    }
    
}

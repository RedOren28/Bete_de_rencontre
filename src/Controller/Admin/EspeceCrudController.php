<?php

namespace App\Controller\Admin;

use App\Entity\Espece;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EspeceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Espece::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

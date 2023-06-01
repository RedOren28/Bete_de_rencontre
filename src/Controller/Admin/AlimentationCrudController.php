<?php

namespace App\Controller\Admin;

use App\Entity\Alimentation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AlimentationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Alimentation::class;
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

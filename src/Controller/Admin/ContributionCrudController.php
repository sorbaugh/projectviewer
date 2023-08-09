<?php

namespace App\Controller\Admin;

use App\Entity\Contribution;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContributionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contribution::class;
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

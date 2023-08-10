<?php

namespace App\Controller\Admin;

use App\Entity\Contributor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContributorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contributor::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('role'),
            AssociationField::new('tasks'),
            BooleanField::new('isActive')->renderAsSwitch(false)
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name')
            ->add('role')
            ->add('isActive');
    }


}

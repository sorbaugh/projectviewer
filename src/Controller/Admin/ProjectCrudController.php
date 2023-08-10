<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            DateField::new('createdAt')
                ->hideOnForm()
                ->setFormat('dd MMM. y hh:mm'),
            DateField::new('updatedAt', 'Last Updated At')
                ->hideOnForm()
                ->setFormat('dd MMM. y hh:mm')
                ->setFormTypeOption(
                    'disabled',
                    $pageName != Crud::PAGE_NEW
                ),
            TextField::new('name'),
            TextEditorField::new('description'),
            DateField::new('dueDate'),
            AssociationField::new('tasks')
                ->setFormTypeOption('choice_label', 'name'),
            BooleanField::new('isFinished')->renderAsSwitch(false),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name')
            ->add('isFinished')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('dueDate')
            ;
    }


}

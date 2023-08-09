<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
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
            DateField::new('createdAt')->hideOnForm()->setFormat('dd MMM. y hh:mm'),
            DateField::new('updatedAt')->setFormat('dd MMM. y hh:mm'),
            TextField::new('name'),
            TextEditorField::new('description'),
            DateField::new('dueDate'),
            AssociationField::new('tasks')
                ->setFormTypeOption('choice_label', 'name'),
            BooleanField::new('isFinished')->renderAsSwitch(false),
        ];
    }
}

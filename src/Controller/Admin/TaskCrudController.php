<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TaskCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Task::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('createdAt')->hideOnForm()->setFormat('dd MMM. y hh:mm'),
            DateField::new('updatedAt')->onlyOnForms()->setFormat('dd MMM. y hh:mm'),
            TextField::new('name'),
            TextEditorField::new('description'),
            DateField::new('dueDate'),
            AssociationField::new('project')
                ->setRequired(false)
                ->autocomplete()
                ->formatValue(static function($value, Task $task) {
                    if (!$project = $task->getProject()) {
                        return null;
                    }

                    return sprintf('%s&nbsp;(%s)', $project->getName(), $project->getTasks()->count());
                }),
            AssociationField::new('taskHistories')->setLabel('Task History Entries'),
            AssociationField::new('blockers'),
            BooleanField::new('isFinished')->renderAsSwitch(),
        ];
    }
}

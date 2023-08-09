<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use App\Entity\TaskHistory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TaskHistoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TaskHistory::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('createdAt')
                ->hideOnForm()
                ->setFormat('dd MMM. y hh:mm'),
            AssociationField::new('task')
                ->autocomplete()
                ->setFormTypeOption(
                    'disabled',
                    $pageName != Crud::PAGE_NEW
                )
                ->formatValue(static function($value, TaskHistory $taskHistory) {
                    if (!$task = $taskHistory->getTask()) {
                        return null;
                    }

                    return sprintf('%s&nbsp;(%s)', $task->getName(), $task->getTaskHistories()->count());
                }),
            TextareaField::new('description')

        ];
    }
}

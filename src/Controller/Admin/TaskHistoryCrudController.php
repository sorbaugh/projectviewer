<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use App\Entity\TaskHistory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
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

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_INDEX, 'History Log')
            ->setDefaultSort([
                'createdAt' => 'DESC',
            ]);
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->disable(Crud::PAGE_NEW)
            ->disable(Crud::PAGE_EDIT)
            ->disable(Crud::PAGE_DETAIL)
        );
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
            TextareaField::new('description')->renderAsHtml()

        ];
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use function Sodium\add;

class TaskCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Task::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setDefaultSort([
                'isFinished' => 'ASC',
                'id' => 'DESC'
            ])
            ->showEntityActionsInlined();
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
            AssociationField::new('project')
                ->setRequired(false)
                ->autocomplete()
                ->formatValue(static function($value, Task $task) {
                    if (!$project = $task->getProject()) {
                        return null;
                    }

                    return sprintf('%s&nbsp;(%s)', $project->getName(), $project->getTasks()->count());
                }),
            TextField::new('name'),
            TextEditorField::new('description')
                ->setSortable(false)
                ->hideOnIndex(),
            TextEditorField::new('currentNote')
                ->setLabel('Log')
                ->setSortable(false)
                ->hideOnIndex(),
            DateField::new('dueDate'),
            AssociationField::new('taskHistories')
                ->setLabel('Log Entries')
                ->setTemplatePath('admin/field/task_log_listing.html.twig')
                ->hideOnForm(),
            AssociationField::new('blockers'),
            BooleanField::new('isFinished')->renderAsSwitch(),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(BooleanFilter::new('isFinished'))
            ->add('project')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('name');
            //->add('blockers')
            //->add('taskHistories');
    }


}

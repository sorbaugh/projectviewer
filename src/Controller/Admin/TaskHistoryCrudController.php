<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use App\Entity\TaskHistory;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

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
        $reportAction = Action::new('report', 'Download Report')
            ->linkToCrudAction('reportHistory')
            //->addCssClass('btn btn-success')
            ->setIcon('fa fa-file-arrow-down')
            ->setTemplatePath('admin/action/history_report_action.html.twig')
            ->displayAsButton()
            ->createAsGlobalAction()
        ;
        return parent::configureActions($actions
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->disable(Crud::PAGE_NEW)
            ->disable(Crud::PAGE_EDIT)
            ->disable(Crud::PAGE_DETAIL)
            ->add(Crud::PAGE_INDEX, $reportAction)
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

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(DateTimeFilter::new('createdAt'))
            ->add(EntityFilter::new('task'));
    }

    public function reportHistory(AdminContext $adminContext, EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(TaskHistory::class);
        $fullHistory = $repository->findAll();

        return $this->json(['history-entries' => count($fullHistory)]);
    }
}

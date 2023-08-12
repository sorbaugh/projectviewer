<?php

namespace App\Controller\Admin;

use App\Entity\Blocker;
use App\Entity\TaskHistory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class BlockerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blocker::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Problem'),
            TextField::new('solution'),
            BooleanField::new('isResolved'),
            AssociationField::new('task', 'Blocked Task')
                ->autocomplete()
                ->setFormTypeOption(
                    'disabled',
                    $pageName != Crud::PAGE_NEW
                )
                ->formatValue(static function($value, Blocker $blocker) {
                    if (!$task = $blocker->getTask()) {
                        return null;
                    }

                    return sprintf('%s&nbsp;(%s blockers total)', $task->getName(), $task->getBlockers()->count());
                }),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(BooleanFilter::new('isResolved'))
            ->add(EntityFilter::new('task'))
            ->add(TextFilter::new('name'))
            ->add(TextFilter::new('solution'));
    }
}

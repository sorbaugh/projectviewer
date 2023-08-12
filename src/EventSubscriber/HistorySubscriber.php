<?php

namespace App\EventSubscriber;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\TaskHistory;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * List of all available Events for future reference:
 * EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent
 * EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityBuildEvent
 * EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent
 * EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntitySearchEvent
 * EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent
 * EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent
 * EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent
 * EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent
 * EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent
 */
class HistorySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => 'onBeforeEntityUpdatedEvent',
        ];
    }
    public function onBeforeEntityUpdatedEvent(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Task) {
            $this->beforeTaskUpdated($entity);
        }

        if ($entity instanceof Project) {
            $this->beforeProjectUpdated($entity);
        }

    }

    private function beforeTaskUpdated(Task $task): void
    {
        $task->setUpdatedAt(new \DateTimeImmutable());

        if ($task->getCurrentNote() !== null) {
            $taskHistory = new TaskHistory();
            $taskHistory->setCreatedAt(new \DateTimeImmutable())
                ->setDescription($task->getCurrentNote());
            $task->addTaskHistory($taskHistory);
        }
    }

    private function beforeProjectUpdated(Project $project): void
    {
        $project->setUpdatedAt(new \DateTimeImmutable());
    }
}

<?php

namespace App\EventSubscriber;

use App\Entity\Task;
use App\Entity\TaskHistory;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HistorySubscriber implements EventSubscriberInterface
{
    public function onBeforeEntityUpdatedEvent(BeforeEntityUpdatedEvent $event): void
    {
        $task = $event->getEntityInstance();

        if (!$task instanceof Task) {
            return;
        }

        if ($task->getCurrentNote() !== null) {
            $taskHistory = new TaskHistory();
            $taskHistory->setCreatedAt(new \DateTimeImmutable())
                ->setDescription($task->getCurrentNote());
            $task->addTaskHistory($taskHistory);
        }

    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => 'onBeforeEntityUpdatedEvent',
        ];
    }
}

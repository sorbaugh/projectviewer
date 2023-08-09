<?php

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Task;

class EntityUpdateListenerAAAAA implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
        ];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Task) {
            $entityManager = $args->getObjectManager();
            $entity->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->getUnitOfWork()->recomputeSingleEntityChangeSet($entityManager->getClassMetadata(YourEntity::class), $entity);
        }
    }
}

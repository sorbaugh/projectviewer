<?php

// src/EventListener/SearchIndexer.php
namespace App\EventListener;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
class EntityUpdateListener
{
    // the listener methods receive an argument which gives you access to
    // both the entity object of the event and the entity manager itself
    public function preUpdate(PreUpdateEventArgs $args): void
    {

    }
}
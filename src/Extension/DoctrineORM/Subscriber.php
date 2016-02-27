<?php

namespace DavidBadura\DoctrineBlending\Extension\DoctrineORM;

use DavidBadura\DoctrineBlending\BlendingManager;
use DavidBadura\DoctrineBlending\Metadata\PropertyMetadata;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class Subscriber implements EventSubscriber
{
    /**
     * @var BlendingManager
     */
    private $blendingManager;

    /**
     * @param BlendingManager $blendingManager
     */
    public function __construct(BlendingManager $blendingManager)
    {
        $this->blendingManager = $blendingManager;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::postLoad
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $this->blendingManager->resolveBlendings($args->getObject());
    }
}
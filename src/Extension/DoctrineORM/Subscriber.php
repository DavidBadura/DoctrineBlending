<?php

namespace DavidBadura\DoctrineBlending\Extension\DoctrineORM;

use DavidBadura\DoctrineBlending\BlendingManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
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
            // load
            Events::postLoad,
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,

            // persist
            Events::prePersist,
            Events::preUpdate,
            Events::preRemove
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $this->load($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->load($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->load($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $this->load($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->persist($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->persist($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $this->persist($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    private function load(LifecycleEventArgs $args)
    {
        $this->blendingManager->resolveBlendings($args->getObject());
    }

    /**
     * @param LifecycleEventArgs $args
     */
    private function persist(LifecycleEventArgs $args)
    {
        $this->blendingManager->revertBlendings($args->getObject());
    }
}
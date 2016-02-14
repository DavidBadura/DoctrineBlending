<?php

namespace DavidBadura\DoctrineBlending;

use DavidBadura\DoctrineBlending\Handler\HandlerRepository;
use GeneratedHydrator\Configuration;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class BlendingManager
{
    /**
     * @var array
     */
    private $blendings = [];

    /**
     * @var array
     */
    private $hydrators = [];

    /**
     * @var HandlerRepository
     */
    private $repository;

    /**
     * @param HandlerRepository $repository
     */
    public function __construct(HandlerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param object $object
     * @throws \Exception
     */
    public function resolveBlendings($object)
    {
        $blendings = $this->getBlendingFor(get_class($object));

        if (!$blendings) {
            return;
        }

        $hydrator = $this->createHydrator($object);
        $properties = $hydrator->extract($object);

        foreach ($blendings as $blending) {
            $handler = $this->repository->get($blending->handler);

            $properties[$blending->property] = $handler->toPhp($properties[$blending->property], $blending->options);
        }

        $hydrator->hydrate(
            $properties,
            $object
        );
    }

    /**
     * @param object $object
     * @throws \Exception
     */
    public function revertBlendings($object)
    {
        $blendings = $this->getBlendingFor(get_class($object));

        if (!$blendings) {
            return;
        }

        $hydrator = $this->createHydrator($object);
        $properties = $hydrator->extract($object);

        foreach ($blendings as $blending) {
            $handler = $this->repository->get($blending->handler);

            $properties[$blending->property] = $handler->toDatabase($properties[$blending->property], $blending->options);
        }

        $hydrator->hydrate(
            $properties,
            $object
        );
    }

    /**
     * @param string $class
     * @return Blending[]
     */
    public function getBlendingFor($class)
    {
        if (!isset($this->blendings[$class])) {
            return [];
        }

        return $this->blendings[$class];
    }

    /**
     * @param string $class
     * @param string $property
     * @param string $handler
     * @param array $options
     */
    public function addBlending($class, $property, $handler, $options = [])
    {
        $blending = new Blending();
        $blending->class = $class;
        $blending->property = $property;
        $blending->handler = $handler;
        $blending->options = $options;

        $this->blendings[$class][] = $blending;
    }

    /**
     * @param object $object
     */
    private function createHydrator($object)
    {
        $class = get_class($object);

        if (isset($this->hydrators[$class])) {
            return $this->hydrators[$class];
        }

        $config = new Configuration($class);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        $this->hydrators[$class] = new $hydratorClass();

        return $this->hydrators[$class];
    }
}
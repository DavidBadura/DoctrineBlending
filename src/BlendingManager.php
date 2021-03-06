<?php

namespace DavidBadura\DoctrineBlending;

use DavidBadura\DoctrineBlending\Handler\HandlerRepository;
use DavidBadura\DoctrineBlending\Metadata\Driver\AnnotationDriver;
use DavidBadura\DoctrineBlending\Metadata\PropertyMetadata;
use Metadata\MetadataFactory;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class BlendingManager
{
    /**
     * @var HandlerRepository
     */
    private $handlerRepository;

    /**
     * @var MetadataFactory
     */
    private $metadataFactory;

    /**
     * @param HandlerRepository $handlerRepository
     */
    public function __construct(HandlerRepository $handlerRepository)
    {
        $this->handlerRepository = $handlerRepository;
        $this->metadataFactory = new MetadataFactory(new AnnotationDriver());
    }

    /**
     * @return HandlerRepository
     */
    public function getHandlerRepository()
    {
        return $this->handlerRepository;
    }

    /**
     * @param string $class
     * @return \Metadata\MergeableClassMetadata|null
     */
    public function getMetadataFor($class)
    {
        return $this->metadataFactory->getMetadataForClass($class);
    }

    /**
     * @param object $object
     * @throws \Exception
     */
    public function resolveBlendings($object)
    {
        $classMetadata = $this->metadataFactory->getMetadataForClass(get_class($object));

        /** @var PropertyMetadata $property */
        foreach ($classMetadata->propertyMetadata as $property) {
            $handler = $this->handlerRepository->get($property->handler);

            $value = $property->getValue($object);
            $value = $handler->toPhp($value, $property->options);

            $property->setValue($object, $value);
        }
    }

    /**
     * @param object $object
     * @throws \Exception
     */
    public function revertBlendings($object)
    {
        $classMetadata = $this->metadataFactory->getMetadataForClass(get_class($object));


        /** @var PropertyMetadata $property */
        foreach ($classMetadata->propertyMetadata as $property) {
            $handler = $this->handlerRepository->get($property->handler);

            $value = $property->getValue($object);

            dump($value);

            $value = $handler->toDatabase($value, $property->options);

            dump($value);

            $property->setValue($object, $value);
        }
    }
}
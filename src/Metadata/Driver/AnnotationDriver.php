<?php

namespace DavidBadura\DoctrineBlending\Metadata\Driver;

use DavidBadura\DoctrineBlending\Annotation\Blend;
use DavidBadura\DoctrineBlending\Metadata\PropertyMetadata;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Metadata\ClassMetadata;
use Metadata\Driver\DriverInterface;
use Metadata\MergeableClassMetadata;
use ReflectionClass;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class AnnotationDriver implements DriverInterface
{
    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     *
     */
    public function __construct()
    {
        AnnotationRegistry::registerLoader('class_exists');

        $this->reader = new AnnotationReader();
    }

    /**
     * @param ReflectionClass $class
     *
     * @return ClassMetadata
     */
    public function loadMetadataForClass(ReflectionClass $class)
    {
        $classMetadata = new MergeableClassMetadata($class->getName());

        foreach ($class->getProperties() as $property) {
            foreach ($this->reader->getPropertyAnnotations($property) as $propertyAnnotation) {
                if (!$propertyAnnotation instanceof Blend) {
                    continue;
                }

                $propertyMetadata = new PropertyMetadata($class->getName(), $property->getName());
                $propertyMetadata->handler = $propertyAnnotation->handler;
                $propertyMetadata->options = $propertyAnnotation->options;

                $classMetadata->addPropertyMetadata($propertyMetadata);
            }
        }

        return $classMetadata;
    }
}
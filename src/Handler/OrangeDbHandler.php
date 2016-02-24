<?php

namespace DavidBadura\DoctrineBlending\Handler;

use DavidBadura\OrangeDb\DocumentManager;
use DavidBadura\OrangeDb\Metadata\PropertyMetadata;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class OrangeDbHandler implements HandlerInterface
{
    /**
     * @var DocumentManager
     */
    private $manager;

    /**
     * @param DocumentManager $manager
     */
    public function __construct(DocumentManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param mixed $value
     * @param array $options
     * @return mixed
     */
    public function toDatabase($value, array $options = [])
    {
        if (!$value) {
            return null;
        }

        $metadata = $this->manager->getMetadataFor($options['class']);

        /** @var PropertyMetadata $property */
        $property = $metadata->propertyMetadata[$metadata->identifier];

        return $property->getValue($value);
    }

    /**
     * @param mixed $value
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public function toPhp($value, array $options = [])
    {
        if (!$value) {
            return null;
        }

        return $this->manager->find($options['class'], $value);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'orangedb';
    }
}
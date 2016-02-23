<?php

namespace DavidBadura\DoctrineBlending\Handler;

use DavidBadura\OrangeDb\DocumentManager;

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
        return $this->manager->getMetadataFor($options['class']);
    }

    /**
     * @param mixed $value
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public function toPhp($value, array $options = [])
    {
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
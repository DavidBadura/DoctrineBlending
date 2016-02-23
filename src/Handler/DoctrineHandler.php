<?php

namespace DavidBadura\DoctrineBlending\Handler;

use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class DoctrineHandler implements HandlerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param mixed $value
     * @param array $options
     * @return mixed
     */
    public function toDatabase($value, array $options = [])
    {
        $manager = $this->registry->getManagerForClass($options['class']);

        return $manager->getClassMetadata($options['class'])->getIdentifierValues($value);
    }

    /**
     * @param mixed $value
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public function toPhp($value, array $options = [])
    {
        $manager = $this->registry->getManagerForClass($options['class']);

        if (method_exists($manager, 'getReference')) {
            return $manager->getReference($options['class'], $value);
        }

        return $manager->find($options['class'], $value);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'doctrine';
    }
}
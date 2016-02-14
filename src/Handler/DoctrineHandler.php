<?php

namespace DavidBadura\DoctrineBlending\Handler;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;

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

        if (!$manager instanceof EntityManagerInterface && !$manager instanceof DocumentManager) {
            throw new \Exception(); // todo
        }

        return $manager->getReference($options['class'], $value);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'doctrine';
    }
}
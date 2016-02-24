<?php

namespace DavidBadura\DoctrineBlending\Handler;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class HandlerRepository
{
    /**
     * @var HandlerInterface[]
     */
    private $handlers = [];

    /**
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        dump($name);
        dump($this->handlers);

        return isset($this->handlers[$name]);
    }

    /**
     * @param string $name
     * @return HandlerInterface
     * @throws \Exception
     */
    public function get($name)
    {
        if ($this->has($name)) {
            return $this->handlers[$name];
        }

        throw new \Exception(); // todo
    }

    /**
     * @param HandlerInterface $handler
     * @throws \Exception
     */
    public function add(HandlerInterface $handler)
    {
        if ($this->has($handler->getName())) {
            throw new \Exception(); // todo
        }

        $this->handlers[$handler->getName()] = $handler;
    }

    /**
     * @param HandlerInterface $handler
     * @throws \Exception
     */
    public function remove(HandlerInterface $handler)
    {
        if (!$this->has($handler->getName())) {
            throw new \Exception(); // todo
        }

        unset($this->handlers[$handler->getName()]);
    }
}
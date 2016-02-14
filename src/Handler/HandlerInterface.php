<?php

namespace DavidBadura\DoctrineBlending\Handler;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
interface HandlerInterface
{
    /**
     * @param mixed $value
     * @param array $options
     * @return mixed
     */
    public function toDatabase($value, array $options = []);

    /**
     * @param mixed $value
     * @param array $options
     * @return mixed
     */
    public function toPhp($value, array $options = []);

    /**
     * @return string
     */
    public function getName();
}
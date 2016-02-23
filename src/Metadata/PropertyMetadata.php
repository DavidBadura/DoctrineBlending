<?php

namespace DavidBadura\DoctrineBlending\Metadata;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class PropertyMetadata extends \Metadata\PropertyMetadata
{
    /**
     * @var string
     */
    public $handler;

    /**
     * @var array
     */
    public $options;
}
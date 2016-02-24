<?php

namespace DavidBadura\DoctrineBlending\Extension\Symfony\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author David Badura <d.badura@gmx.de>
 */
class HandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('davidbadura.doctrine_blending.handler_repository')) {
            return;
        }

        foreach ($container->findTaggedServiceIds('davidbadura_doctrine_blending.handler') as $id => $attributes) {
            $container->getDefinition('davidbadura.doctrine_blending.handler_repository')->addMethodCall('add', array(new Reference($id)));
        }
    }
}
<?php

namespace DavidBadura\DoctrineBlending\Extension\Symfony;

use DavidBadura\DoctrineBlending\Extension\Symfony\DependencyInjection\CompilerPass\HandlerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class DavidBaduraDoctrineBlendingBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new HandlerPass());
    }
}

<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 18:15
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Transformer;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TransformerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(TransformerChain::class)) {
            return;
        }

        $definition = $container->findDefinition(TransformerChain::class);
        $taggedServices = $container->findTaggedServiceIds('doctor_meetings.transformer');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $arguments = [new Reference($id), $attributes['alias']];
                $definition->addMethodCall('addTransformer', $arguments);
            }
        }
    }
}

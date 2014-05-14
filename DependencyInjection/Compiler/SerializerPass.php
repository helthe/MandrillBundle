<?php

/*
 * This file is part of the HeltheMandrillBundle package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Bundle\MandrillBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Adds all services with the tags "helthe_mandrill.serializer.encoder" and "helthe_mandrill.serializer.normalizer" as
 * encoders and normalizers to the Mandrill serializer service.
 *
 * Based of the Symfony SerializerPass.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class SerializerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('helthe_mandrill.serializer')) {
            return;
        }

        // Looks for all the services tagged "helthe_mandrill.serializer.normalizer" and adds them to the Serializer service
        $normalizers = $this->findAndSortTaggedServices('helthe_mandrill.serializer.normalizer', $container);
        $container->getDefinition('helthe_mandrill.serializer')->replaceArgument(0, $normalizers);

        // Looks for all the services tagged "helthe_mandrill.serializer.encoder" and adds them to the Serializer service
        $encoders = $this->findAndSortTaggedServices('helthe_mandrill.serializer.encoder', $container);
        $container->getDefinition('helthe_mandrill.serializer')->replaceArgument(1, $encoders);
    }

    private function findAndSortTaggedServices($tagName, ContainerBuilder $container)
    {
        $services = $container->findTaggedServiceIds($tagName);

        if (empty($services)) {
            throw new \RuntimeException(sprintf('You must tag at least one service as "%s" to use the Serializer service', $tagName));
        }

        $sortedServices = array();
        foreach ($services as $serviceId => $tags) {
            foreach ($tags as $tag) {
                $priority = isset($tag['priority']) ? $tag['priority'] : 0;
                $sortedServices[$priority][] = new Reference($serviceId);
            }
        }

        krsort($sortedServices);

        // Flatten the array
        return call_user_func_array('array_merge', $sortedServices);
    }
}

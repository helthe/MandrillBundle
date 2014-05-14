<?php

/*
 * This file is part of the HeltheMandrillBundle package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Bundle\MandrillBundle\Tests\DependencyInjection;

use Helthe\Bundle\MandrillBundle\DependencyInjection\HeltheMandrillExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HeltheMandrillExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testWithNoApiKey()
    {
        $container = new ContainerBuilder();
        $loader = new HeltheMandrillExtension();
        $loader->load(array(array()), $container);
    }

    public function testLoadDefault()
    {
        $container = new ContainerBuilder();
        $loader = new HeltheMandrillExtension();
        $loader->load(array(array('api_key' => 'mandrill_key')), $container);

        // HTTP Client
        $this->assertTrue($container->hasParameter('helthe_mandrill.http.client.class'));
        $this->assertEquals('GuzzleHttp\Client', $container->getParameter('helthe_mandrill.http.client.class'));
        $this->assertTrue($container->hasDefinition('helthe_mandrill.http.client'));

        // Mailer
        $this->assertTrue($container->hasParameter('helthe_mandrill.mailer.basic.class'));
        $this->assertEquals('Helthe\Component\Mandrill\Mailer\Mailer', $container->getParameter('helthe_mandrill.mailer.basic.class'));
        $this->assertTrue($container->hasDefinition('helthe_mandrill.mailer.basic'));

        $this->assertTrue($container->hasParameter('helthe_mandrill.mailer.templating.class'));
        $this->assertEquals('Helthe\Component\Mandrill\Mailer\TemplatingEngineMailer', $container->getParameter('helthe_mandrill.mailer.templating.class'));
        $this->assertTrue($container->hasDefinition('helthe_mandrill.mailer.templating'));

        // Mandrill
        $this->assertTrue($container->hasParameter('helthe_mandrill.client.class'));
        $this->assertEquals('Helthe\Component\Mandrill\Client', $container->getParameter('helthe_mandrill.client.class'));
        $this->assertTrue($container->hasDefinition('helthe_mandrill.client'));
        $this->assertEquals('mandrill_key', $container->getDefinition('helthe_mandrill.client')->getArgument(2));

        // Serializer
        $this->assertTrue($container->hasParameter('helthe_mandrill.serializer.class'));
        $this->assertEquals('Symfony\Component\Serializer\Serializer', $container->getParameter('helthe_mandrill.serializer.class'));
        $this->assertTrue($container->hasDefinition('helthe_mandrill.serializer'));

        $this->assertTrue($container->hasParameter('helthe_mandrill.serializer.encoder.class'));
        $this->assertEquals('Symfony\Component\Serializer\Encoder\JsonEncoder', $container->getParameter('helthe_mandrill.serializer.encoder.class'));
        $this->assertTrue($container->hasDefinition('helthe_mandrill.serializer.encoder'));

        $this->assertTrue($container->hasParameter('helthe_mandrill.serializer.normalizer.class'));
        $this->assertEquals('Symfony\Component\Serializer\Normalizer\CustomNormalizer', $container->getParameter('helthe_mandrill.serializer.normalizer.class'));
        $this->assertTrue($container->hasDefinition('helthe_mandrill.serializer.normalizer'));
    }
}

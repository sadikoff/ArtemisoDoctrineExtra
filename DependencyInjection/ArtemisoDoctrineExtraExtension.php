<?php

namespace Artemiso\DoctrineExtraBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ArtemisoDoctrineExtraExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config  = $this->processConfiguration(new Configuration(), $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $mappings = [];

        foreach ($config['listeners'] as $extension => $enabled) {
            $definitionKey = 'artemiso_doctrine_extra.listener.'.$extension;

            if ($extension == 'translatable' && $enabled) {
                $container->getDefinition('artemiso_doctrine_extra.extension_listener')->setPublic(true)->addTag(
                  'kernel.event_listener',
                  ['event' => 'kernel.request', 'method' => 'onLateKernelRequest', 'priority' => '-10']
                );

                $mappings['translatable'] = $config['mappings']['translatable'];

                $container->setParameter('artemiso_doctrine_extra.mappings.translatable', true);
            }

            if ($extension == 'loggable' && $enabled) {
                $container->getDefinition('artemiso_doctrine_extra.extension_listener')->setPublic(true)->addTag(
                  'kernel.event_listener',
                  ['event' => 'kernel.request', 'method' => 'onKernelRequest']
                );

                $mappings['loggable'] = $config['mappings']['loggable'];

                $container->setParameter('artemiso_doctrine_extra.mappings.loggable', true);
            }

            if ($extension == 'tree' && $enabled) {
                $mappings['tree'] = $config['mappings']['tree'];
            }

            if ($container->hasDefinition($definitionKey) && $enabled) {
                $container->getDefinition($definitionKey)->setPublic(true);

            }
        }

        $container->loadFromExtension(
          'doctrine',
          [
            'orm' => [
              'mappings' => $mappings
            ]
          ]
        );
    }

}

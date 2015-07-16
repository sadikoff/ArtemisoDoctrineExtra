<?php

namespace Artemiso\DoctrineExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('artemiso_doctrine_extra');

        $mappings = $rootNode->children()->arrayNode('mappings')->addDefaultsIfNotSet()->children();

        $translatable = $mappings->arrayNode('translatable')->addDefaultsIfNotSet()->children();
        $translatable->scalarNode('type')->defaultValue('annotation');
        $translatable->scalarNode('alias')->defaultValue('Gedmo');
        $translatable->booleanNode('is_bundle')->defaultFalse();
        $translatable->scalarNode('prefix')->defaultValue('Gedmo\Translatable\Entity');
        $translatable->scalarNode('dir')->defaultValue(
            '%kernel.root_dir%/../vendor/gedmo/doctrine-extensions/lib/Gedmo/Translatable/Entity'
        );

        $loggable = $mappings->arrayNode('loggable')->addDefaultsIfNotSet()->children();
        $loggable->scalarNode('type')->defaultValue('annotation');
        $loggable->scalarNode('alias')->defaultValue('Gedmo');
        $loggable->booleanNode('is_bundle')->defaultFalse();
        $loggable->scalarNode('prefix')->defaultValue('Gedmo\Loggable\Entity');
        $loggable->scalarNode('dir')->defaultValue(
            '%kernel.root_dir%/../vendor/gedmo/doctrine-extensions/lib/Gedmo/Loggable/Entity'
        );

        $tree = $mappings->arrayNode('tree')->addDefaultsIfNotSet()->children();
        $tree->scalarNode('type')->defaultValue('annotation');
        $tree->scalarNode('alias')->defaultValue('Gedmo');
        $tree->booleanNode('is_bundle')->defaultFalse();
        $tree->scalarNode('prefix')->defaultValue('Gedmo\Tree\Entity');
        $tree->scalarNode('dir')->defaultValue(
            '%kernel.root_dir%/../vendor/gedmo/doctrine-extensions/lib/Gedmo/Tree/Entity'
        );

        $listeners = $rootNode->children()->arrayNode('listeners')->addDefaultsIfNotSet()->children();

        $listeners->booleanNode('blameable')->defaultFalse();
        $listeners->booleanNode('ip_traceable')->defaultFalse();
        $listeners->booleanNode('loggable')->defaultFalse();
        $listeners->booleanNode('sluggable')->defaultFalse();
        $listeners->booleanNode('soft_deletable')->defaultFalse();
        $listeners->booleanNode('timestampable')->defaultFalse();
        $listeners->booleanNode('translatable')->defaultFalse();
        $listeners->booleanNode('tree')->defaultFalse();
        $listeners->booleanNode('uploadable')->defaultFalse();

        return $treeBuilder;
    }
}

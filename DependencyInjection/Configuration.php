<?php

namespace Fortune\FortuneApiBundle\DependencyInjection;

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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fortune_api');

        $rootNode
            ->children()
                ->arrayNode('resources')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('parent')->end()
                            ->scalarNode('entity')->isRequired()->end()
                            ->arrayNode('validation')
                                ->prototype('scalar')
                                ->end()
                            ->end()
                            ->arrayNode('access_control')
                                ->children()
                                    ->booleanNode('authentication')->defaultFalse()->end()
                                    ->scalarNode('role')->defaultNull()->end()
                                ->end()
                            ->end()
                            ->arrayNode('exclude')
                                ->prototype('scalar')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

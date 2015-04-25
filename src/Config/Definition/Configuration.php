<?php

namespace PhpZone\Shell\Config\Definition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('shell');

        $rootNode
            ->useAttributeAsKey('id')
            ->prototype('array')
                ->children()
                    ->scalarNode('description')->end()
                    ->scalarNode('help')->end()
                    ->arrayNode('script')
                        ->isRequired()
                        ->requiresAtLeastOneElement()
                        ->prototype('scalar')->end()
                    ->end()
                    ->booleanNode('enable')->end()
                    ->booleanNode('tty')->end()
                    ->booleanNode('stop_on_error')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

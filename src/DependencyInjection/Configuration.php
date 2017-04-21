<?php

namespace BimData\IntentClient\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('intent_client');

        $rootNode
            ->children()
                ->scalarNode('client_id')->end()
                ->scalarNode('client_secret')->end()
                ->scalarNode('site')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
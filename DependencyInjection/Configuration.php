<?php

namespace MPeters\BBCEditorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2013 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bbc_editor', 'array');

        $rootNode
            ->children()
				->booleanNode('enable')->defaultTrue()->end()
				->scalarNode('base_path')->defaultValue('/test/web/bundles/nbbc/')->end()
				->scalarNode('js_path')->defaultValue('/test/web/bundles/nbbc/editor.js')->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}

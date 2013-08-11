<?php

namespace tps\DndFileUploadBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

    const DEFAULT_UPLOAD_DIRECTORY = 'web/uploads';
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dnd_file_upload');

        $rootNode->children()
            ->arrayNode('twig')
                ->children()
                    ->scalarNode('css_class')
                        ->defaultValue('dnd-file-upload-container')
                        ->info('the css class that is used for the main-container div element')
                        ->example('my-sweet-upload-class')
                    ->end()
                ->end()
            ->end()
            ->scalarNode('upload_directory')
                ->defaultValue(Configuration::DEFAULT_UPLOAD_DIRECTORY)
                ->info('the directory that files are moved to after upload succeeds')
                ->example('/var/userUploads')
            ->end()
            ->scalarNode('allowed_mimetypes')
                ->defaultValue('*')
                ->info('a list of allowed mimetypes, comma-separated, use "*" to allow all')
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}

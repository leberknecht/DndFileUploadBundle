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
    const DEFAULT_UPLOAD_DIRECTORY = 'uploads';

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dnd_file_upload');

        $rootNode->beforeNormalization()
            ->ifTrue(function($config) {
                    return isset($config['persist_entity']) && $config['persist_entity'] && empty($config['entity_class']);
                })
                ->thenInvalid('You need to specify dnd_file_upload.entity_class to persist file uploads')
            ->end()
            ->children()
                ->booleanNode('is_persistence_valid')
                    ->defaultValue(true)
                    ->info('you need to specify entity_class for persistence')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('upload_directory')
                    ->defaultValue(Configuration::DEFAULT_UPLOAD_DIRECTORY)
                    ->info('the directory that files are moved to after upload succeeds')
                    ->example('/var/userUploads')
                ->end()
                ->arrayNode('allowed_mimetypes')
                    ->prototype('scalar')
                    ->end()
                    ->defaultValue(array('*'))
                    ->info('an array of allowed mimetypes')
                ->end()
                ->scalarNode('persist_entity')
                    ->defaultValue(false)
                    ->info('if set to true, the file-entity will be persisted after upload')
                ->end()
                ->scalarNode('entity_class')
                    ->info('file-entity that will be persisted to database')
                    ->example('Acme\DemoBundle\Entity\UploadedFile')
                ->end()
                ->arrayNode('twig')
                    ->children()
                        ->scalarNode('css_class')
                        ->defaultValue('dnd-file-upload-container')
                        ->info('the css class that is used for the main-container div element')
                ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}

<?php

namespace tps\DndFileUploadBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DndFileUploadExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $container->setParameter('dnd_file_upload.upload_directory', $config['upload_directory']);
        $container->setParameter('dnd_file_upload.allowed_mimetypes', $config['allowed_mimetypes']);
        $container->setParameter('dnd_file_upload.persist_entity', $config['persist_entity']);
        if ($config['persist_entity'] == true) {
            $container->setParameter('dnd_file_upload.entity_class', $config['entity_class']);
        }
        if (isset($config['twig']) && isset($config['twig']['css_class'])) {
            $container->setParameter('dnd_file_upload.twig.css_class', $config['twig']['css_class']);
        }
    }
}

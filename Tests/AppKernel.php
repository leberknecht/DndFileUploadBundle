<?php

namespace tps\DndFileUploadBundle\Tests;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Component\Filesystem\Filesystem;
use tps\DndFileUploadBundle\DndFileUploadBundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel {
    private $config;

    public function __construct($config)
    {
        parent::__construct('test', true);

        $fs = new Filesystem();
        if (!$fs->isAbsolutePath($config)) {
            $config = __DIR__.'/'.$config;
        }

        if (!file_exists($config)) {
            throw new \RuntimeException(sprintf('The config file "%s" does not exist.', $config));
        }

        $this->config = $config;
    }

    public function registerBundles()
    {
        return array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new DoctrineBundle(),
            new DndFileUploadBundle(),
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->config);
    }

    protected function getContainerClass()
    {
        return parent::getContainerClass().sha1($this->config);
    }

    public function serialize()
    {
        return $this->config;
    }

    public function unserialize($str)
    {
        $this->__construct($str);
    }
}

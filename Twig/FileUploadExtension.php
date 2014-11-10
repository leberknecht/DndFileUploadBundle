<?php

namespace tps\DndFileUploadBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Twig_Extension;
use Symfony\Component\DependencyInjection\Container;

class FileUploadExtension extends Twig_Extension
{
    /**
     * @var array
     */
    private $supportedMimetypes;

    /**
     * @var string
     */
    private $divContainerCssClass;

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('DndFileUploadContainer',
                array(
                    $this,
                    'getDndFileUploadContainer',
                ),
                array(
                    'needs_environment' => true,
                    'is_safe' => array('html')
                )
            )
        );
    }

    /**
     * @param \Twig_Environment $twig
     * @param string $containerId
     * @return string
     */
    public function getDndFileUploadContainer(\Twig_Environment $twig, $containerId = '')
    {
        return $twig->render(
            'DndFileUploadBundle::base.container.html.twig',
            array(
                'containerId' => $containerId,
                'cssClass' => $this->getDivContainerCssClass(),
                'supportedMimeTypesSerialized' => implode(',', $this->getSupportedMimetypes()),
                'uploadSlotTemplate' => $twig->render('DndFileUploadBundle::uploadSlot.html.twig')
            )
        );
    }

    /**
     * @param string $divContainerCssClass
     */
    public function setDivContainerCssClass($divContainerCssClass)
    {
        $this->divContainerCssClass = $divContainerCssClass;
    }

    /**
     * @return string
     */
    public function getDivContainerCssClass()
    {
        return $this->divContainerCssClass;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'file_upload_extension';
    }

    /**
     * @param array $supportedMimetypes
     */
    public function setSupportedMimetypes(array $supportedMimetypes)
    {
        $this->supportedMimetypes = $supportedMimetypes;
    }

    /**
     * @return array
     */
    public function getSupportedMimetypes()
    {
        return $this->supportedMimetypes;
    }
}

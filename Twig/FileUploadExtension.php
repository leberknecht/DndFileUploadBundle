<?php
/**
 * Created by PhpStorm.
 * User: leberknecht
 * Date: 28.07.13
 * Time: 20:12
 */

namespace tps\DndFileUploadBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Twig_Extension;
use Symfony\Component\DependencyInjection\Container;

class FileUploadExtension extends Twig_Extension {

    /**
     * @var Container
     */
    private $dic;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $supportedMimetypes;

    /**
     * @var string
     */
    private $divContainerCssClass;

    public function __construct(Container $dic, \Twig_Environment $twig) {
        $this->setDic($dic);
        $this->setTwig($twig);
        $this->setSupportedMimetypes($this->dic->getParameter('dnd_file_upload.allowed_mimetypes'));
        $this->setDivContainerCssClass($this->dic->getParameter('dnd_file_upload.twig.css_class'));
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('DndFileUploadContainer',
                array(
                    $this,
                    'DndFileUploadContainerFilter',
                    ),
                array("is_safe" => array("html")
                )
            ),
        );
    }

    /**
     * @param $containerId
     * @return string
     */
    public function DndFileUploadContainerFilter($containerId)
    {
        return $this->twig->render('DndFileUploadBundle::base.container.html.twig',
            array(
                'containerId' => $containerId,
                'cssClass' => $this->getDivContainerCssClass(),
                'supportedMimeTypesSerialized' => $this->getSupportedMimetypes()
            )
        );
    }

    /**
     * @param \Symfony\Component\DependencyInjection\Container $dic
     */
    public function setDic($dic)
    {
        $this->dic = $dic;
    }

    /**
     * @return \Symfony\Component\DependencyInjection\Container
     */
    public function getDic()
    {
        return $this->dic;
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
     * @param \Twig_Environment $twig
     */
    public function setTwig($twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    public function getName()
    {
        return 'file_upload_extension';
    }

    public function getUploadDirectory()
    {
        return $this->dic->getParameter('dnd_file_upload.upload_directory');
    }

    /**
     * @param string $supportedMimetypes
     */
    public function setSupportedMimetypes($supportedMimetypes)
    {
        $this->supportedMimetypes = $supportedMimetypes;
    }

    /**
     * @return string
     */
    public function getSupportedMimetypes()
    {
        return $this->supportedMimetypes;
    }
}
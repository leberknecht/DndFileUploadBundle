<?php
/**
 * Created by PhpStorm.
 * User: leberknecht
 * Date: 28.07.13
 * Time: 20:12
 */

namespace tps\DndFileUploadBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Twig_Extension;
use Symfony\Component\DependencyInjection\Container;

class FileUploadExtension extends Twig_Extension {

    /**
     * @var EngineInterface
     */
    private $templatingEngine;

    /**
     * @var string
     */
    private $supportedMimetypes;

    /**
     * @var string
     */
    private $divContainerCssClass;

    /**
     * @var string
     */
    private $postHandlerRoute;

    public function __construct(EngineInterface $templatingEngine) {
        $this->setTemplatingEngine($templatingEngine);
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('DndFileUploadContainer',
                array(
                    $this,
                    'getDndFileUploadContainer',
                ),
                array(
                    "is_safe" => array("html")
                )
            ),
            new \Twig_SimpleFunction('DndFileUploadAssets',
                array(
                    $this,
                    'DndFileUploadAssetsFilter',
                ),
                array(
                    "is_safe" => array("html")
                )
            ),
        );
    }

    /**
     * @param $containerId
     * @return string
     */
    public function getDndFileUploadContainer($containerId = '')
    {
        return $this->templatingEngine->render('DndFileUploadBundle::base.container.html.twig',
            array(
                'containerId' => $containerId,
                'cssClass' => $this->getDivContainerCssClass(),
                'supportedMimeTypesSerialized' => $this->getSupportedMimetypes()
            )
        );
    }

    /**
     * @return string
     */
    public function DndFileUploadAssetsFilter()
    {
        $uploadSlotTemplate = $this->templatingEngine->render('DndFileUploadBundle::uploadSlot.html.twig');
        return $this->templatingEngine->render('DndFileUploadBundle::assets.container.html.twig',
            array(
                'cssClass' => $this->getDivContainerCssClass(),
                'supportedMimeTypesSerialized' => $this->getSupportedMimetypes(),
                'uploadSlotTemplate' => $uploadSlotTemplate
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
     * @param EngineInterface $twig
     */
    public function setTemplatingEngine($twig)
    {
        $this->templatingEngine = $twig;
    }

    /**
     * @return \Twig_Environment
     */
    public function getTemplatingEngine()
    {
        return $this->templatingEngine;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'file_upload_extension';
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

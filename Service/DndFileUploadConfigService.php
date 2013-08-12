<?php

namespace tps\DndFileUploadBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class DndFileUploadConfigService  {

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
     * @var
     */
    private $persistEntity;

    /**
     * @var string
     */
    private $divContainerCssClass;

    public function __construct(Container $dic) {
        $this->setDic($dic);
        $this->setTwig($this->dic->get('twig'));
        $this->setSupportedMimetypes($this->dic->getParameter('dnd_file_upload.allowed_mimetypes'));
        $this->setDivContainerCssClass($this->dic->getParameter('dnd_file_upload.twig.css_class'));
        $this->setPersistEntity($this->dic->getParameter('dnd_file_upload.persist_entity'));
    }

    /**
     * @param \tps\DndFileUploadBundle\Service\Container $dic
     */
    public function setDic($dic)
    {
        $this->dic = $dic;
    }

    /**
     * @return \tps\DndFileUploadBundle\Service\Container
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
     * @param mixed $persistEntity
     */
    public function setPersistEntity($persistEntity)
    {
        $this->persistEntity = $persistEntity;
    }

    /**
     * @return mixed
     */
    public function getPersistEntity()
    {
        return $this->persistEntity;
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


}
<?php

namespace tps\DndFileUploadBundle\Service;

use tps\DndFileUploadBundle\Entity\File;

class DndFileUploadService
{

    /**
     * @var string
     */
    private $supportedMimetypes;

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

    /**
     * @param File $file
     * @return bool
     */
    public function checkMimeType(File $file)
    {
        $supportedMimetypes = $this->getSupportedMimetypes();
        if (in_array('*', $supportedMimetypes)) {
            return true;
        }

        $mimetype = $file->getMimetype();
        foreach ($supportedMimetypes as $supportedMimetype) {
            if ($supportedMimetype == $mimetype) {
                return true;
            }
        }
        return false;
    }
}
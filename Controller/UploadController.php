<?php
/**
 * Created by PhpStorm.
 * User: leberknecht
 * Date: 11.08.13
 * Time: 00:33
 */

namespace tps\DndFileUploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use tps\DndFileUploadBundle\Entity\File;
use tps\DndFileUploadBundle\Twig\FileUploadExtension;

class UploadController extends Controller {

    /**
     * @return Response
     */
    public function filePostAction() {
        $file = new File();
        $this->setFilePropertiesByUploadedFile($file);
        $extension = $this->get('dnd_file_upload.file_upload_extension');
        if (false == $this->checkMimeType($file, $extension)) {
            return $this->unsupportedMimetypeResponse($file);
        }

        $targetPath = $extension->getUploadDirectory();
        $file->upload($targetPath);

        if ($extension->getPersistEntity()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return new Response(json_encode(array('error' => 0)));
    }

    /**
     * @param File $file
     */
    public function setFilePropertiesByUploadedFile(File $file)
    {
        $uploadedFile = $file->attachFileByFileinfo($_FILES['file']);
        $file->setCreated(new \DateTime());
        $file->setName($uploadedFile->getClientOriginalName());
        $file->setMimetype($uploadedFile->getMimeType());
        $file->setFilename(rand(0,99999) . time() . '_' . $uploadedFile->getClientOriginalName());
    }

    /**
     * @param File $file
     * @return Response
     */
    private function unsupportedMimetypeResponse(File $file)
    {
        return new Response(json_encode(
            array(
                'error' => 1,
                'error_message' => 'unsupported filetype: ' . $file->getMimetype()
            )
        ));
    }

    /**
     * @param File $file
     * @param FileUploadExtension $extension
     * @return bool
     */
    private function checkMimeType(File $file, FileUploadExtension $extension)
    {
        $allowedMimetypes = $extension->getSupportedMimetypes();
        if ('*' != $allowedMimetypes && !in_array($file->getMimetype(), explode(',', $allowedMimetypes))) {
            return false;
        }
        return true;
    }
} 
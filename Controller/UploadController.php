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

class UploadController extends Controller {

    /**
     * @return Response
     */
    public function filePostAction() {
        $file = new File();
        $allowedMimetypes = $this->get('service_container')->getParameter('dnd_file_upload.allowed_mimetypes');
        $this->setFilePropertiesByFirstUploadedFile($file);
        if ('*' != $allowedMimetypes && !in_array($file->getMimetype(), explode(',', $allowedMimetypes))) {
            return new Response(json_encode(array(
                    'error' => 1,
                    'error_message' => 'unsupported filetype: '. $file->getMimetype()
                )));
        }
        $file->upload($this->get('service_container')->getParameter('dnd_file_upload.upload_directory'));
        $this->getDoctrine()->getManager()->flush();

        return new Response(
            json_encode(
                array(
                    'error' => 0
                )
            )
        );
    }

    /**
     * @param File $file
     */
    public function setFilePropertiesByFirstUploadedFile(File $file)
    {
        $uploadedFile = $file->attachFileByFileinfo($_FILES['file']);
        $file->setCreated(new \DateTime());
        $file->setName($uploadedFile->getClientOriginalName());
        $file->setMimetype($uploadedFile->getMimeType());
        $file->setFilename(rand(0,99999) . time() . '_' . $uploadedFile->getClientOriginalName());
    }
} 
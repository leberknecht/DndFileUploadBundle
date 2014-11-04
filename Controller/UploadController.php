<?php
/**
 * Created by PhpStorm.
 * User: leberknecht
 * Date: 11.08.13
 * Time: 00:33
 */

namespace tps\DndFileUploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use tps\DndFileUploadBundle\Entity\File;
use tps\DndFileUploadBundle\Twig\FileUploadExtension;

class UploadController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function filePostAction(Request $request)
    {
        $file = $this->getPostedFile($request);
        $extensionConfig = $this->container->get('dnd_file_upload.config');
        if (!$extensionConfig->checkMimeType($file)) {
            return $this->unsupportedMimetypeResponse($file);
        }

        $file->upload($this->container->getParameter('dnd_file_upload.upload_directory'));
        if ($this->container->getParameter('dnd_file_upload.persist_entity')) {
            $this->getDoctrine()->getManager()->flush();
        }

        return new Response(json_encode(array('error' => 0)));
    }

    /**
     * @param Request $request
     * @return File
     */
    protected function getPostedFile(Request $request)
    {
        $file = new File();
        $postedFiles = $request->files->all();
        $file->setFile(end($postedFiles));
        $this->setFilePropertiesByUploadedFile($file);
        return $file;
    }

    /**
     * @param File $file
     */
    protected function setFilePropertiesByUploadedFile(File $file)
    {
        $file->setCreated(new \DateTime());
        $file->setName($file->getFile()->getClientOriginalName());
        $file->setMimetype($file->getFile()->getMimeType());
        $file->setFilename(rand(0, 99999) . time() . '_' . $file->getFile()->getClientOriginalName());
    }

    /**
     * @param File $file
     * @return Response
     */
    protected function unsupportedMimetypeResponse(File $file)
    {
        return new Response(
            json_encode(
                array(
                    'error' => 1,
                    'error_message' => 'unsupported filetype: ' . $file->getMimetype()
                )
            )
        );
    }


}

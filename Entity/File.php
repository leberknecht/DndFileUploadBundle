<?php

namespace tps\DndFileUploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\MappedSuperclass
 */
class File
{
    /**
     * @ORM\Column(name="created", type="datetime")
     * @var \DateTime $created
     */
    protected $created;

    /**
     * @var string $directory
     * @ORM\Column(name="directory", type="string", length=255)
     */
    protected $directory;

    /**
     * @var string $name
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var UploadedFile $file
     */
    protected $file;

    /**
     * @var string
     * @ORM\Column(name="mimetype", type="string", length=255)
     */
    protected $mimetype;

    /**
     * @var string
     * @ORM\Column(name="filename", type="string", length=255)
     */
    protected $filename;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return File
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set directory
     *
     * @param string $directory
     * @return File
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * Get directory
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFullPathName() {
        return $this->getDirectory() . DIRECTORY_SEPARATOR . $this->getFilename();
    }

    /**
     * @param string $uploadDirectory
     */
    public function upload($uploadDirectory)
    {
        if (null === $this->file) {
            return;
        }
        $this->setDirectory($uploadDirectory);
        $this->file->move($uploadDirectory, $this->getFilename());
        $this->path = $this->file->getClientOriginalName();
        $this->file = null;
    }

    /**
     * @param string $mimetype
     */
    public function setMimetype($mimetype)
    {
        $this->mimetype = $mimetype;
    }

    /**
     * @return string
     */
    public function getMimetype()
    {
        return $this->mimetype;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
}

<?php

namespace MDMediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="MDMediaBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, unique=false)
     */
    private $url;

    private $file;

    private $tempFilename;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getFile()
    {
	return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
	$this->file = $file;

	if (null !== $this->url)
	{
	    $this->tempFilename = $this->url;
	    $this->url = null;
	    $this->alt = null;
	}
    }

    public function getTempFilename()
    {
	return $this->tempFilename;
    }

    public function setTempFilename($tempFilename)
    {
	$this->tempFilename = $tempFilename;
	return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
	if (null === $this->file)
	{
	    return;
	}

	$this->url = $this->file->guessExtension();
	$this->alt = $this->file->getClientOriginalName();

    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
	if (null === $this->file)
	{
	    return;
	}

	if (null !== $this->tempFilename)
	{
	    $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
	    if (file_exists($oldFile))
	    {
		unlink($oldFile);
	    }
	}
	
	$this->file->move(
		$this->getUploadRootDir(),
		$this->id.'.'.$this->url
	);

    }

    public function getUploadDir()
    {
	return 'web/img/uploads';
    }

    protected function getUploadRootDir()
    {
	return __DIR__.'/../../../'.$this->getUploadDir();
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
	$this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
	if (file_exists($this->tempFilename))
	{
	    unlink($this->tempFilename);
	}
    }

}


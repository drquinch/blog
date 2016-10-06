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

    /**
     * @ORM\Column(name="name", type="string", length=255, unique=false)
     */
    private $name;

    /**
     * @ORM\Column(name="ext", type="string", length=255, unique=false)
     */
    private $ext;

    /**
     * @ORM\Column(name="figcaption", type="string", length=255, unique=false, nullable=true)
     */
    private $figcaption;

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
     * @param string $ext
     *
     * @return Image
     */
    public function setExt($ext)
    {
        $this->ext = $ext;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getExt()
    {
        return $this->ext;
    }

    public function getFile()
    {
	return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
	$this->file = $file;
	
	// on verifie si on avait déjà un fichier pour cette entité
	if (null !== $this->ext)
	{
	    // On sauvegarde l'extension du fichier pour le supprimer plus tard
	    $this->tempFilename = $this->ext;

	    // on réinitilise les valeurs des attributs
	    $this->ext = null;
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

	//TODO verifier si le nom du fichier existe deja, si oui, on rajoute un _x ou x = un nombre
	$this->name = basename($this->file->getClientOriginalName(), '.'.pathinfo($this->file->getClientOriginalName())['extension']);
	$this->ext = $this->file->guessExtension();
	$this->alt = $this->file->getClientOriginalName();
	$this->url = $this->getUploadDir().'/'.$this->name.'.'.$this->ext;

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
	    $oldFile = $this->getUploadRootDir().'/'.$this->name.'.'.$this->tempFilename;
	    if (file_exists($oldFile))
	    {
		unlink($oldFile);
	    }
	}
	
	$this->file->move(
		$this->getUploadRootDir(),
		$this->name.'.'.$this->ext
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
	$this->tempFilename = $this->getUploadRootDir().'/'.$this->name.'.'.$this->ext;
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

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Image
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
     * Set figcaption
     *
     * @param string $figcaption
     *
     * @return Image
     */
    public function setFigcaption($figcaption)
    {
        $this->figcaption = $figcaption;

        return $this;
    }

    /**
     * Get figcaption
     *
     * @return string
     */
    public function getFigcaption()
    {
        return $this->figcaption;
    }
}

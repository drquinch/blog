<?php

namespace MDUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="MDUserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
    /**
     * @var date
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    protected $birthdate;
	
	/**
	 * @var Object
	 * 
	 * @ORM\OneToOne(targetEntity="MDMediaBundle\Entity\Image", cascade={"persist"})
	 */
	protected $profil_image;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $facebookID;

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set profilImage
     *
     * @param \MDMediaBundle\Entity\Image $profilImage
     *
     * @return User
     */
    public function setProfilImage(\MDMediaBundle\Entity\Image $profilImage = null)
    {
        $this->profil_image = $profilImage;

        return $this;
    }

    /**
     * Get profilImage
     *
     * @return \MDMediaBundle\Entity\Image
     */
    public function getProfilImage()
    {
        return $this->profil_image;
    }

    /**
     * Set facebookID
     *
     * @param string $facebookID
     *
     * @return User
     */
    public function setFacebookID($facebookID)
    {
        $this->facebookID = $facebookID;

        return $this;
    }

    /**
     * Get facebookID
     *
     * @return string
     */
    public function getFacebookID()
    {
        return $this->facebookID;
    }
}

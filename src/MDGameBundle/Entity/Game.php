<?php

namespace MDGameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="MDGameBundle\Repository\GameRepository")
 */
class Game
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releasedate", type="date", nullable=true)
     */
    private $releasedate;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\OneToOne(targetEntity="MDMediaBundle\Entity\Image", cascade={"persist"})
     */
    private $coverimage;

    /**
     * @ORM\OneToOne(targetEntity="MDMediaBundle\Entity\Image", cascade={"persist"})
     */
    private $smallimage;

    /**
     * @ORM\ManyToOne(targetEntity="MDMediaBundle\Entity\Image", cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="MDMediaBundle\Entity\Video", cascade={"persist"})
     */
    private $videos;

    /**
     * @ORM\ManyToMany(targetEntity="MDGameBundle\Entity\Publisher", cascade={"persist"})
     */
    private $publishers;

    /**
     * @ORM\ManyToMany(targetEntity="MDGameBundle\Entity\Developer", cascade={"persist"})
     */
    private $developers;

    /**
     * @ORM\ManyToOne(targetEntity="MDGameBundle\Entity\Licence", cascade={"persist"})
     */
    private $licence;

    /**
     * @ORM\ManyToMany(targetEntity="MDGameBundle\Entity\Plateforme", cascade={"persist"})
     */
    private $plateformes;
    
    /**
     * @ORM\ManyToMany(targetEntity="MDGameBundle\Entity\Genre", cascade={"persist"})
     */
    private $genres;

    /**
     * @ORM\ManyToMany(targetEntity="MDGameBundle\Entity\Theme", cascade={"persist"})
     */
    private $themes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->publishers = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Game
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
     * Set releasedate
     *
     * @param \DateTime $releasedate
     *
     * @return Game
     */
    public function setReleasedate($releasedate)
    {
        $this->releasedate = $releasedate;

        return $this;
    }

    /**
     * Get releasedate
     *
     * @return \DateTime
     */
    public function getReleasedate()
    {
        return $this->releasedate;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Game
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Add publisher
     *
     * @param \MDGameBundle\Entity\Publisher $publisher
     *
     * @return Game
     */
    public function addPublisher(\MDGameBundle\Entity\Publisher $publisher)
    {
        $this->publishers[] = $publisher;

        return $this;
    }

    /**
     * Remove publisher
     *
     * @param \MDGameBundle\Entity\Publisher $publisher
     */
    public function removePublisher(\MDGameBundle\Entity\Publisher $publisher)
    {
        $this->publishers->removeElement($publisher);
    }

    /**
     * Get publishers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPublishers()
    {
        return $this->publishers;
    }

    /**
     * Add developer
     *
     * @param \MDGameBundle\Entity\Developer $developer
     *
     * @return Game
     */
    public function addDeveloper(\MDGameBundle\Entity\Developer $developer)
    {
        $this->developers[] = $developer;

        return $this;
    }

    /**
     * Remove developer
     *
     * @param \MDGameBundle\Entity\Developer $developer
     */
    public function removeDeveloper(\MDGameBundle\Entity\Developer $developer)
    {
        $this->developers->removeElement($developer);
    }

    /**
     * Get developers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevelopers()
    {
        return $this->developers;
    }

    /**
     * Set licence
     *
     * @param \MDGameBundle\Entity\Licence $licence
     *
     * @return Game
     */
    public function setLicence(\MDGameBundle\Entity\Licence $licence = null)
    {
        $this->licence = $licence;

        return $this;
    }

    /**
     * Get licence
     *
     * @return \MDGameBundle\Entity\Licence
     */
    public function getLicence()
    {
        return $this->licence;
    }

    /**
     * Add plateforme
     *
     * @param \MDGameBundle\Entity\Plateforme $plateforme
     *
     * @return Game
     */
    public function addPlateforme(\MDGameBundle\Entity\Plateforme $plateforme)
    {
        $this->plateformes[] = $plateforme;

        return $this;
    }

    /**
     * Remove plateforme
     *
     * @param \MDGameBundle\Entity\Plateforme $plateforme
     */
    public function removePlateforme(\MDGameBundle\Entity\Plateforme $plateforme)
    {
        $this->plateformes->removeElement($plateforme);
    }

    /**
     * Get plateformes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlateformes()
    {
        return $this->plateformes;
    }

    /**
     * Add genre
     *
     * @param \MDGameBundle\Entity\Genre $genre
     *
     * @return Game
     */
    public function addGenre(\MDGameBundle\Entity\Genre $genre)
    {
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre
     *
     * @param \MDGameBundle\Entity\Genre $genre
     */
    public function removeGenre(\MDGameBundle\Entity\Genre $genre)
    {
        $this->genres->removeElement($genre);
    }

    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Add theme
     *
     * @param \MDGameBundle\Entity\Theme $theme
     *
     * @return Game
     */
    public function addTheme(\MDGameBundle\Entity\Theme $theme)
    {
        $this->themes[] = $theme;

        return $this;
    }

    /**
     * Remove theme
     *
     * @param \MDGameBundle\Entity\Theme $theme
     */
    public function removeTheme(\MDGameBundle\Entity\Theme $theme)
    {
        $this->themes->removeElement($theme);
    }

    /**
     * Get themes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Set coverimage
     *
     * @param \MDMediaBundle\Entity\Image $coverimage
     *
     * @return Game
     */
    public function setCoverimage(\MDMediaBundle\Entity\Image $coverimage = null)
    {
        $this->coverimage = $coverimage;

        return $this;
    }

    /**
     * Get coverimage
     *
     * @return \MDMediaBundle\Entity\Image
     */
    public function getCoverimage()
    {
        return $this->coverimage;
    }

    /**
     * Set smallimage
     *
     * @param \MDMediaBundle\Entity\Image $smallimage
     *
     * @return Game
     */
    public function setSmallimage(\MDMediaBundle\Entity\Image $smallimage = null)
    {
        $this->smallimage = $smallimage;

        return $this;
    }

    /**
     * Get smallimage
     *
     * @return \MDMediaBundle\Entity\Image
     */
    public function getSmallimage()
    {
        return $this->smallimage;
    }

    /**
     * Set images
     *
     * @param \MDMediaBundle\Entity\Image $images
     *
     * @return Game
     */
    public function setImages(\MDMediaBundle\Entity\Image $images = null)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return \MDMediaBundle\Entity\Image
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set videos
     *
     * @param \MDMediaBundle\Entity\Video $videos
     *
     * @return Game
     */
    public function setVideos(\MDMediaBundle\Entity\Video $videos = null)
    {
        $this->videos = $videos;

        return $this;
    }

    /**
     * Get videos
     *
     * @return \MDMediaBundle\Entity\Video
     */
    public function getVideos()
    {
        return $this->videos;
    }
}

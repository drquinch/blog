<?php

namespace MDGameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Licence
 *
 * @ORM\Table(name="licence")
 * @ORM\Entity(repositoryClass="MDGameBundle\Repository\LicenceRepository")
 */
class Licence
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, unique=false, nullable=true)
     */
    private $website;

    /**
     * @ORM\ManyToMany(targetEntity="MDGameBundle\Entity\Publisher", cascade={"persist"})
     */
    private $publishers;

    /**
     * @ORM\ManyToMany(targetEntity="MDGameBundle\Entity\Developer", cascade={"persist"})
     */
    private $developers;

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
     * @return Licence
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
     * Set website
     *
     * @param string $website
     *
     * @return Licence
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
     * Constructor
     */
    public function __construct()
    {
        $this->publishers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->developers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->plateformes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->genres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->themes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add publisher
     *
     * @param \MDGameBundle\Entity\Publisher $publisher
     *
     * @return Licence
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
     * @return Licence
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
     * Add plateforme
     *
     * @param \MDGameBundle\Entity\Plateforme $plateforme
     *
     * @return Licence
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
     * @return Licence
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
     * @return Licence
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
}

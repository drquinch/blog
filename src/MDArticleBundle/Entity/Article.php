<?php

namespace MDArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="MDArticleBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=255, nullable=true)
     */
    private $subtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime")
     */
    private $datePublication;

    /**
     * @ORM\Column(name="date_last_update", type="datetime")
     */
    private $dateLastUpdate;

    /**
     * @ORM\ManyToOne(targetEntity="MDUserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="MDGameBundle\Entity\Game", cascade={"persist"})
     */
    private $games;

    /**
     * @ORM\ManyToMany(targetEntity="MDGameBundle\Entity\Licence", cascade={"persist"})
     */
    private $licences;

    /**
     * @ORM\ManyToMany(targetEntity="MDGameBundle\Entity\Developer", cascade={"persist"})
     */
    private $developers;

    /**
     * @ORM\ManyToOne(targetEntity="MDMediaBundle\Entity\Image", cascade={"persist"})
     */
    private $coverimage;

    /**
     * @ORM\ManyToMany(targetEntity="MDTagsBundle\Entity\Tag", cascade={"persist"})
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="MDCategoryBundle\Entity\Category", cascade={"persist"})
     */
    private $category;

    /**
     * @var bool
     *
     * @ORM\Column(name="highlight", type="boolean", nullable=true)
     */
    private $highlight;

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
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return Article
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Article
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Article
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->games = new \Doctrine\Common\Collections\ArrayCollection();
        $this->licences = new \Doctrine\Common\Collections\ArrayCollection();
        $this->publishers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->developers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
		$this->dateCreation = new \DateTime();
		$this->dateLastUpdate = new \DateTime();
    }

    /**
     * Set dateLastUpdate
     *
     * @param \DateTime $dateLastUpdate
     *
     * @return Article
     */
    public function setDateLastUpdate($dateLastUpdate)
    {
        $this->dateLastUpdate = $dateLastUpdate;

        return $this;
    }

    /**
     * Get dateLastUpdate
     *
     * @return \DateTime
     */
    public function getDateLastUpdate()
    {
        return $this->dateLastUpdate;
    }

    /**
     * Set author
     *
     * @param \MDUserBundle\Entity\User $author
     *
     * @return Article
     */
    public function setAuthor(\MDUserBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \MDUserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add game
     *
     * @param \MDGameBundle\Entity\Game $game
     *
     * @return Article
     */
    public function addGame(\MDGameBundle\Entity\Game $game)
    {
        $this->games[] = $game;

        return $this;
    }

    /**
     * Remove game
     *
     * @param \MDGameBundle\Entity\Game $game
     */
    public function removeGame(\MDGameBundle\Entity\Game $game)
    {
        $this->games->removeElement($game);
    }

    /**
     * Get games
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Add licence
     *
     * @param \MDGameBundle\Entity\Licence $licence
     *
     * @return Article
     */
    public function addLicence(\MDGameBundle\Entity\Licence $licence)
    {
        $this->licences[] = $licence;

        return $this;
    }

    /**
     * Remove licence
     *
     * @param \MDGameBundle\Entity\Licence $licence
     */
    public function removeLicence(\MDGameBundle\Entity\Licence $licence)
    {
        $this->licences->removeElement($licence);
    }

    /**
     * Get licences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLicences()
    {
        return $this->licences;
    }

    /**
     * Add publisher
     *
     * @param \MDGameBundle\Entity\Publisher $publisher
     *
     * @return Article
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
     * @return Article
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
     * Set coverimage
     *
     * @param \MDMediaBundle\Entity\Image $coverimage
     *
     * @return Article
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
     * Add tag
     *
     * @param \MDTagsBundle\Entity\Tag $tag
     *
     * @return Article
     */
    public function addTag(\MDTagsBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \MDTagsBundle\Entity\Tag $tag
     */
    public function removeTag(\MDTagsBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add category
     *
     * @param \MDCategoryBundle\Entity\Category $category
     *
     * @return Article
     */
    public function addCategory(\MDCategoryBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \MDCategoryBundle\Entity\Category $category
     */
    public function removeCategory(\MDCategoryBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set category
     *
     * @param \MDCategoryBundle\Entity\Category $category
     *
     * @return Article
     */
    public function setCategory(\MDCategoryBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \MDCategoryBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set highlight
     *
     * @param boolean $highlight
     *
     * @return Article
     */
    public function setHighlight($highlight)
    {
        $this->highlight = $highlight;

        return $this;
    }

    /**
     * Get highlight
     *
     * @return boolean
     */
    public function getHighlight()
    {
        return $this->highlight;
    }
}

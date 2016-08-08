<?php

namespace MDGameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publisher
 *
 * @ORM\Table(name="publisher")
 * @ORM\Entity(repositoryClass="MDGameBundle\Repository\PublisherRepository")
 */
class Publisher
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
     * @var array
     *
     * @ORM\Column(name="oldnames", type="array", nullable=true)
     */
    private $oldnames;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;


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
     * @return Publisher
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
     * Set oldnames
     *
     * @param array $oldnames
     *
     * @return Publisher
     */
    public function setOldnames($oldnames)
    {
        $this->oldnames = $oldnames;

        return $this;
    }

    /**
     * Get oldnames
     *
     * @return array
     */
    public function getOldnames()
    {
        return $this->oldnames;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Publisher
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
}

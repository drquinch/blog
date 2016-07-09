<?php

namespace MDGameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="game_market")
 */
class GameMarket
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity="MDGameBundle\Entity\Game")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="MDGameBundle\Entity\Market")
     */
    private $market;


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
     * Set link
     *
     * @param string $link
     *
     * @return GameMarket
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set game
     *
     * @param \MDGameBundle\Entity\Game $game
     *
     * @return GameMarket
     */
    public function setGame(\MDGameBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \MDGameBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set market
     *
     * @param \MDGameBundle\Entity\Market $market
     *
     * @return GameMarket
     */
    public function setMarket(\MDGameBundle\Entity\Market $market = null)
    {
        $this->market = $market;

        return $this;
    }

    /**
     * Get market
     *
     * @return \MDGameBundle\Entity\Market
     */
    public function getMarket()
    {
        return $this->market;
    }
}

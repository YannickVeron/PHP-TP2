<?php

namespace App\Entity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @ORM\Table(name="score")
 */
class Score
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(type="integer")
     */
    protected $score;
    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @var Player
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="scores")
     */
    private $owner;
    public function getOwner(): Player{
        return $this->owner;
    }
    public function setOwner(Player $owner):self{
        $this->owner=$owner;
        return $this;
    }

    /**
     * @var Game
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="scores")
     */
    private $game;
    public function getGame(): Game{
        return $this->game;
    }
    public function setGame(Game $game):self {
        $this->game=$game;
        return $this;
    }

    /**
     * Score constructor.
     * @param $score
     * @param $created_at
     */
    public function __construct(int $score,DateTime $created_at)
    {
        $this->score = $score;
        $this->created_at = $created_at;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getScore() : int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): self
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt() : Datetime
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $created_at
     */
    public function setCreatedAt(Datetime $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }




}
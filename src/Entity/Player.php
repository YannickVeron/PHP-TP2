<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @ORM\Table(name="player")
 */
class Player
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
    * @ORM\Column(type="string", length=255)
    */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $email;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Score", mappedBy="owner")
     */
    private $scores;

    public function score(Score $score) : self{
        $this->scores[] = $score;
        return $this;
    }

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Game",inversedBy="players")
     */
    private $games;
    public  function addGame(Game $game):self {
        $this->games[] = $game;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * @return int
     */
    public function getId():?int
    {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getUsername():?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail():?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

}
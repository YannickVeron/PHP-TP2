<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @ORM\Table(name="game")
 */
class Game
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
    protected $name;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $image;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Player",inversedBy="games")
     */
    private $players;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Score", mappedBy="game")
     */
    private $scores;

    /**
     * Game constructor.
     * @param $name
     * @param $image
     */
    public function __construct(String $name,String $image)
    {
        $this->name = $name;
        $this->image = $image;
    }

    public function addScore(Score $score):self{
        $this->scores[] = $score;
        return $this;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage():string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }




}
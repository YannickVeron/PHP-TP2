<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

class Player
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $username;
    /**
     * @return string
     */
    public function getUsername():string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $email;

    /**
     * @return string
     */
    public function getEmail():string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
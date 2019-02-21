<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements \Symfony\Component\Security\Core\User\UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * 
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $userName;

    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     *     
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $userEmail;

    /**
     *  @var string The hashed password
     * @ORM\Column(type="string", length=255)
     */
    private $userPassword;
    
  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): self
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->userPassword;
    }

    public function setUserPassword(string $userPassword): self
    {
        $this->userPassword = $userPassword;

        return $this;
    }
 
    public function eraseCredentials() {
        
    }

    public function getPassword(): string {
         return $this->userPassword;
    }

    public function getRoles() {
        
    }

    public function getSalt() {
        
    }

}

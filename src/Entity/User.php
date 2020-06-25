<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * Нижеуказанная длина зависит от "алгоритма", который вы используете для шифрования
     * пароля, но это также хорошо работает с bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Artefacts", mappedBy="user")
     */
    private $artefacts;

    public function __construct()
    {
        $this->artefacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function __toString()
    {
        return $this->getUsername();
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getSalt(){}

    public function eraseCredentials(){}

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

    public function unserialize($string)
    {
        list (
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($string, ['allowed_classes' => false]);
    }

    /**
     * @return Collection|Artefacts[]
     */
    public function getArtefacts(): Collection
    {
        return $this->artefacts;
    }

    public function addArtefact(Artefacts $artefact): self
    {
        if (!$this->artefacts->contains($artefact)) {
            $this->artefacts[] = $artefact;
            $artefact->setUser($this);
        }

        return $this;
    }

    public function removeArtefact(Artefacts $artefact): self
    {
        if ($this->artefacts->contains($artefact)) {
            $this->artefacts->removeElement($artefact);
            // set the owning side to null (unless already changed)
            if ($artefact->getUser() === $this) {
                $artefact->setUser(null);
            }
        }

        return $this;
    }
}

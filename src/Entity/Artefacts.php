<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtefactsRepository")
 */
class Artefacts
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="artefacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Klas", inversedBy="artefacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $klas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\KlPr", inversedBy="artefacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $kl_pr;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ZnPr", inversedBy="artefacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zn_pr;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $place;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $period;

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getKlas(): ?Klas
    {
        return $this->klas;
    }

    public function setKlas(?Klas $klas): self
    {
        $this->klas = $klas;

        return $this;
    }

    public function getKlPr(): ?KlPr
    {
        return $this->kl_pr;
    }

    public function setKlPr(?KlPr $kl_pr): self
    {
        $this->kl_pr = $kl_pr;

        return $this;
    }

    public function getZnPr(): ?ZnPr
    {
        return $this->zn_pr;
    }

    public function setZnPr(?ZnPr $zn_pr): self
    {
        $this->zn_pr = $zn_pr;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(?string $period): self
    {
        $this->period = $period;

        return $this;
    }
}

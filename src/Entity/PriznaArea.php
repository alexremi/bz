<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PriznaAreaRepository")
 */
class PriznaArea
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Prizn", inversedBy="priznaAreas")
     */
    private $priznId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ZnPr", mappedBy="priznaArea")
     */
    private $znId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Zn;

    public function __construct()
    {
        $this->znId = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->Zn;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriznId(): ?Prizn
    {
        return $this->priznId;
    }

    public function setPriznId(?Prizn $priznId): self
    {
        $this->priznId = $priznId;

        return $this;
    }

    /**
     * @return Collection|ZnPr[]
     */
    public function getZnId(): Collection
    {
        return $this->znId;
    }

    public function addZnId(ZnPr $znId): self
    {
        if (!$this->znId->contains($znId)) {
            $this->znId[] = $znId;
            $znId->setPriznaArea($this);
        }

        return $this;
    }

    public function removeZnId(ZnPr $znId): self
    {
        if ($this->znId->contains($znId)) {
            $this->znId->removeElement($znId);
            // set the owning side to null (unless already changed)
            if ($znId->getPriznaArea() === $this) {
                $znId->setPriznaArea(null);
            }
        }

        return $this;
    }

    public function getZn(): ?string
    {
        return $this->Zn;
    }

    public function setZn(string $Zn): self
    {
        $this->Zn = $Zn;

        return $this;
    }
}

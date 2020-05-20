<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PriznRepository")
 */
class Prizn
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ZnPr", mappedBy="pr")
     */
    private $znPrs;

    public function __construct()
    {
        $this->znPrs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|ZnPr[]
     */
    public function getZnPrs(): Collection
    {
        return $this->znPrs;
    }

    public function addZnPr(ZnPr $znPr): self
    {
        if (!$this->znPrs->contains($znPr)) {
            $this->znPrs[] = $znPr;
            $znPr->setPr($this);
        }

        return $this;
    }

    public function removeZnPr(ZnPr $znPr): self
    {
        if ($this->znPrs->contains($znPr)) {
            $this->znPrs->removeElement($znPr);
            // set the owning side to null (unless already changed)
            if ($znPr->getPr() === $this) {
                $znPr->setPr(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getName();
    }
}

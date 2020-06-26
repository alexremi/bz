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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\KlPr", mappedBy="Pr")
     */
    private $klPrs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PriznaArea", mappedBy="priznId")
     */
    private $priznaAreas;

    public function __construct()
    {
        $this->znPrs = new ArrayCollection();
        $this->klPrs = new ArrayCollection();
        $this->priznaAreas = new ArrayCollection();
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

    /**
     * @return Collection|KlPr[]
     */
    public function getKlPrs(): Collection
    {
        return $this->klPrs;
    }

    public function addKlPr(KlPr $klPr): self
    {
        if (!$this->klPrs->contains($klPr)) {
            $this->klPrs[] = $klPr;
            $klPr->setPr($this);
        }

        return $this;
    }

    public function removeKlPr(KlPr $klPr): self
    {
        if ($this->klPrs->contains($klPr)) {
            $this->klPrs->removeElement($klPr);
            // set the owning side to null (unless already changed)
            if ($klPr->getPr() === $this) {
                $klPr->setPr(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PriznaArea[]
     */
    public function getPriznaAreas(): Collection
    {
        return $this->priznaAreas;
    }

    public function addPriznaArea(PriznaArea $priznaArea): self
    {
        if (!$this->priznaAreas->contains($priznaArea)) {
            $this->priznaAreas[] = $priznaArea;
            $priznaArea->setPriznId($this);
        }

        return $this;
    }

    public function removePriznaArea(PriznaArea $priznaArea): self
    {
        if ($this->priznaAreas->contains($priznaArea)) {
            $this->priznaAreas->removeElement($priznaArea);
            // set the owning side to null (unless already changed)
            if ($priznaArea->getPriznId() === $this) {
                $priznaArea->setPriznId(null);
            }
        }

        return $this;
    }
}

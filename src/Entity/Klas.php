<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KlasRepository")
 */
class Klas
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
     * @ORM\OneToMany(targetEntity="App\Entity\KlPr", mappedBy="kl")
     */
    private $klPrs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Artefacts", mappedBy="klas")
     */
    private $artefacts;

    public function __construct()
    {
        $this->klPrs = new ArrayCollection();
        $this->artefacts = new ArrayCollection();
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
            $klPr->setKl($this);
        }

        return $this;
    }

    public function removeKlPr(KlPr $klPr): self
    {
        if ($this->klPrs->contains($klPr)) {
            $this->klPrs->removeElement($klPr);
            // set the owning side to null (unless already changed)
            if ($klPr->getKl() === $this) {
                $klPr->setKl(null);
            }
        }

        return $this;
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
            $artefact->setKlas($this);
        }

        return $this;
    }

    public function removeArtefact(Artefacts $artefact): self
    {
        if ($this->artefacts->contains($artefact)) {
            $this->artefacts->removeElement($artefact);
            // set the owning side to null (unless already changed)
            if ($artefact->getKlas() === $this) {
                $artefact->setKlas(null);
            }
        }

        return $this;
    }
}

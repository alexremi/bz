<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KlPrRepository")
 */
class KlPr
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Klas", inversedBy="klPrs")
     */
    private $kl;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Prizn", inversedBy="klPrs")
     */
    private $Pr;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Artefacts", mappedBy="kl_pr")
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

    public function getKl(): ?Klas
    {
        return $this->kl;
    }

    public function setKl(?Klas $kl): self
    {
        $this->kl = $kl;

        return $this;
    }

    public function getPr(): ?Prizn
    {
        return $this->Pr;
    }

    public function setPr(?Prizn $Pr): self
    {
        $this->Pr = $Pr;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->Pr;
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
            $artefact->setKlPr($this);
        }

        return $this;
    }

    public function removeArtefact(Artefacts $artefact): self
    {
        if ($this->artefacts->contains($artefact)) {
            $this->artefacts->removeElement($artefact);
            // set the owning side to null (unless already changed)
            if ($artefact->getKlPr() === $this) {
                $artefact->setKlPr(null);
            }
        }

        return $this;
    }
}

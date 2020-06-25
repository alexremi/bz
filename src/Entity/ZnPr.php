<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ZnPrRepository")
 */
class ZnPr
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Prizn", inversedBy="znPrs")
     */
    private $pr;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Artefacts", mappedBy="zn_pr")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPr(): ?Prizn
    {
        return $this->pr;
    }

    public function setPr(?Prizn $pr): self
    {
        $this->pr = $pr;

        return $this;
    }
    public function __toString()
    {
        return $this->getName();
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
            $artefact->setZnPr($this);
        }

        return $this;
    }

    public function removeArtefact(Artefacts $artefact): self
    {
        if ($this->artefacts->contains($artefact)) {
            $this->artefacts->removeElement($artefact);
            // set the owning side to null (unless already changed)
            if ($artefact->getZnPr() === $this) {
                $artefact->setZnPr(null);
            }
        }

        return $this;
    }
}

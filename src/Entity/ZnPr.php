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
     * @ORM\ManyToOne(targetEntity="App\Entity\Prizn", inversedBy="znPrs")
     */
    private $pr;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Artefacts", mappedBy="zn_pr")
     */
    private $artefacts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PriznaArea", inversedBy="znId")
     */
    private $priznaArea;

    /**
     * @var Klas
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Klas")
     * @ORM\JoinColumn(name="class", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $class;

    public function __construct()
    {
        $this->artefacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        return (string) $this->pr;
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

    public function getPriznaArea(): ?PriznaArea
    {
        return $this->priznaArea;
    }

    public function setPriznaArea(?PriznaArea $priznaArea): self
    {
        $this->priznaArea = $priznaArea;

        return $this;
    }

    /**
     * @param Klas $class
     *
     * @return ZnPr
     */
    public function setClass(Klas $class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return Klas
     */
    public function getClass()
    {
        return $this->class;
    }
}

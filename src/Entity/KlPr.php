<?php

namespace App\Entity;

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
}

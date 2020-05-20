<?php

namespace App\Entity;

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
}

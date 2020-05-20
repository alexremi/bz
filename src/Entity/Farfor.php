<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FarforRepository")
 */
class Farfor
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FarforCategory", mappedBy="relation")
     */
    private $farforCategories;

    public function __construct()
    {
        $this->farforCategories = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|FarforCategory[]
     */
    public function getFarforCategories(): Collection
    {
        return $this->farforCategories;
    }

    public function addFarforCategory(FarforCategory $farforCategory): self
    {
        if (!$this->farforCategories->contains($farforCategory)) {
            $this->farforCategories[] = $farforCategory;
            $farforCategory->setRelation($this);
        }

        return $this;
    }

    public function removeFarforCategory(FarforCategory $farforCategory): self
    {
        if ($this->farforCategories->contains($farforCategory)) {
            $this->farforCategories->removeElement($farforCategory);
            // set the owning side to null (unless already changed)
            if ($farforCategory->getRelation() === $this) {
                $farforCategory->setRelation(null);
            }
        }

        return $this;
    }
}

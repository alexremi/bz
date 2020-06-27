<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="corollas")
 */
class Corolla
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var Klas
     *
     * @ORM\ManyToOne(targetEntity="Klas")
     * @ORM\JoinColumn(name="corolla_class", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $corollaClass;

    /**
     * @var string
     *
     * @Assert\NotBlank(allowNull=false)
     *
     * @ORM\Column(name="image", type="string", length=1024, nullable=false)
     */
    private $image;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Klas $corollaClass
     *
     * @return Corolla
     */
    public function setCorollaClass(Klas $corollaClass)
    {
        $this->corollaClass = $corollaClass;

        return $this;
    }

    /**
     * @return Klas
     */
    public function getCorollaClass()
    {
        return $this->corollaClass;
    }

    /**
     * @param string $image
     *
     * @return Corolla
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}

<?php

namespace App\Entity;

use App\Repository\CoursCardsImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoursCardsImageRepository::class)
 */
class CoursCardsImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $src;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * @ORM\OneToOne(targetEntity=Cours::class, mappedBy="MainImage", cascade={"persist", "remove"})
     */
    private $cours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function setSrc(string $src): self
    {
        $this->src = $src;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        // unset the owning side of the relation if necessary
        if ($cours === null && $this->cours !== null) {
            $this->cours->setMainImage(null);
        }

        // set the owning side of the relation if necessary
        if ($cours !== null && $cours->getMainImage() !== $this) {
            $cours->setMainImage($this);
        }

        $this->cours = $cours;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Spatioport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(inversedBy: 'spatioport', targetEntity: Adress::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adress $adress = null;

    #[ORM\ManyToMany(targetEntity: Bestiary::class, mappedBy: 'spatioport')]
    private Collection $animaux;

    public function __construct()
    {
        $this->animaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAdress(): ?Adress
    {
        return $this->adress;
    }

    public function setAdress(Adress $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * @return Collection<int, Bestiary>
     */
    public function getAnimaux(): Collection
    {
        return $this->animaux;
    }

    public function addAnimaux(Bestiary $bestiary): static
    {
        if (!$this->animaux->contains($bestiary)) {
            $this->animaux->add($bestiary);
            $bestiary->addSpatioport($this);
        }

        return $this;
    }

    public function removeAnimaux(Bestiary $bestiary): static
    {
        if ($this->animaux->removeElement($bestiary)) {
            $bestiary->removeSpatioport($this);
        }

        return $this;
    }
}

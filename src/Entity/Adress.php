<?php

namespace App\Entity;

use App\Repository\AdressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdressRepository::class)]
class Adress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $coordonnees_orbitales = null;

    #[ORM\OneToOne(mappedBy: 'adress', cascade: ['persist', 'remove'])]
    private ?Spatioport $spatioport = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoordonneesOrbitales(): ?float
    {
        return $this->coordonnees_orbitales;
    }

    public function setCoordonneesOrbitales(float $coordonnees_orbitales): static
    {
        $this->coordonnees_orbitales = $coordonnees_orbitales;

        return $this;
    }

    public function getSpatioport(): ?Spatioport
    {
        return $this->spatioport;
    }

    public function setSpatioport(?Spatioport $spatioport): static
    {
        if ($spatioport !== null && $spatioport->getAdress() !== $this) {
            $spatioport->setAdress($this);
        }

        $this->spatioport = $spatioport;

        return $this;
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
}

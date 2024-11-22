<?php

namespace App\Entity;

use App\Repository\BestiaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BestiaryRepository::class)]
class Bestiary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\ManyToMany(targetEntity: Spatioport::class, inversedBy: 'animaux', cascade: ['persist', 'remove'])]
    private Collection $spatioport;

    #[ORM\JoinColumn(nullable: false)]
    private ?Spatioport $adress = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $dangerosity = null; // Pacifique, Neutre, Dangereux

    #[ORM\Column(length: 255)]
    private ?string $rarity = null; // Commun, Rare, Introuvable

    #[ORM\Column(length: 255)]
    private ?string $origin = null; // Planète ou lieu d'origine

    public function __construct()
    {
        $this->spatioport = new ArrayCollection();
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getAdress(): ?Spatioport
    {
        return $this->adress;
    }

    public function setAdress(Spatioport $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDangerosity(): ?string
    {
        return $this->dangerosity;
    }

    public function setDangerosity(string $dangerosity): static
    {
        $this->dangerosity = $dangerosity;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(string $rarity): static
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * @return Collection<int, spatioport>
     */
    public function getspatioport(): Collection
    {
        return $this->spatioport;
    }

    public function addspatioport(Spatioport $spatioport): static
    {
        if (!$this->spatioport->contains($spatioport)) {
            $this->spatioport->add($spatioport);
            $spatioport->addAnimaux($this);
        }

        return $this;
    }

    public function removespatioport(Spatioport $spatioport): static
    {
        if ($this->spatioport->removeElement($spatioport)) {
            $spatioport->removeAnimaux($this);
        }

        return $this;
    }
}
?>

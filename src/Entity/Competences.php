<?php

namespace App\Entity;

use App\Repository\CompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetencesRepository::class)]
class Competences
{   
    #[ORM\Id]

    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $lvl = null;

    /**
     * @var Collection<int, Mercenheros>
     */
    #[ORM\ManyToMany(targetEntity: Mercenheros::class, mappedBy: 'competences')]
    private Collection $mercenheros;

    public function __construct()
    {
        $this->mercenheros = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLvl(): ?int
    {
        return $this->lvl;
    }

    public function setLvl(int $lvl): static
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * @return Collection<int, Mercenheros>
     */
    public function getMercenheros(): Collection
    {
        return $this->mercenheros;
    }

    public function addMercenhero(Mercenheros $mercenhero): static
    {
        if (!$this->mercenheros->contains($mercenhero)) {
            $this->mercenheros->add($mercenhero);
            $mercenhero->addCompetence($this);
        }

        return $this;
    }

    public function removeMercenhero(Mercenheros $mercenhero): static
    {
        if ($this->mercenheros->removeElement($mercenhero)) {
            $mercenhero->removeCompetence($this);
        }

        return $this;
    }
}

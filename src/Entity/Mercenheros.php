<?php

namespace App\Entity;

use App\Repository\MercenherosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MercenherosRepository::class)]
class Mercenheros
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $isAvailable = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $etat = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?int $munitions = null;

    #[ORM\Column]
    private ?int $lvl = null;

    #[ORM\Column]
    private ?int $lifePoints = null;

    /**
     * @var Collection<int, Competences>
     */
    #[ORM\ManyToMany(targetEntity: Competences::class, inversedBy: 'mercenheros')]
    private Collection $competences;

    /**
     * @var Collection<int, Team>
     */
    #[ORM\ManyToMany(targetEntity: Team::class, mappedBy: 'members')]
    private Collection $teamMembers;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->teamMembers = new ArrayCollection();
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

    public function isAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getMunitions(): ?int
    {
        return $this->munitions;
    }

    public function setMunitions(int $munitions): static
    {
        $this->munitions = $munitions;

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

    public function getLifePoints(): ?int
    {
        return $this->lifePoints;
    }

    public function setLifePoints(int $lifePoints): static
    {
        $this->lifePoints = $lifePoints;

        return $this;
    }

    /**
     * @return Collection<int, Competences>
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competences $competence): static
    {
        if (!$this->competences->contains($competence)) {
            $this->competences->add($competence);
        }

        return $this;
    }

    public function removeCompetence(Competences $competence): static
    {
        $this->competences->removeElement($competence);

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeamMembers(): Collection
    {
        return $this->teamMembers;
    }

    public function addTeamMember(Team $teamMember): static
    {
        if (!$this->teamMembers->contains($teamMember)) {
            $this->teamMembers->add($teamMember);
            $teamMember->addMember($this);
        }

        return $this;
    }

    public function removeTeamMember(Team $teamMember): static
    {
        if ($this->teamMembers->removeElement($teamMember)) {
            $teamMember->removeMember($this);
        }

        return $this;
    }
}

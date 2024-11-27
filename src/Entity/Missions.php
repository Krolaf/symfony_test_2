<?php

namespace App\Entity;

use App\Repository\MissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionsRepository::class)]
class Missions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;



    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(length: 50)]
    private ?string $status = 'PENDING';


    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $completionTime = null; // Temps d'accomplissement en minutes


    /**
     * @var Collection<int, Competences>
     */
    #[ORM\ManyToMany(targetEntity: Competences::class)]
    private Collection $requiredCompetences;

    /**
     * @var Collection<int, Team>
     */
    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'missions')]
    #[ORM\JoinTable(name: 'missions_teams')] // Table de jointure missions_teams
    private Collection $assignedTeams;

    public function __construct()
    {
        $this->requiredCompetences = new ArrayCollection();
        $this->assignedTeams = new ArrayCollection();
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getCompletionTime(): ?int
    {
        return $this->completionTime;
    }

    public function setCompletionTime(?int $completionTime): static
    {
        $this->completionTime = $completionTime;

        return $this;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Competences>
     */
    public function getRequiredCompetences(): Collection
    {
        return $this->requiredCompetences;
    }

    public function addRequiredCompetence(Competences $requiredCompetence): static
    {
        if (!$this->requiredCompetences->contains($requiredCompetence)) {
            $this->requiredCompetences->add($requiredCompetence);
        }

        return $this;
    }

    public function removeRequiredCompetence(Competences $requiredCompetence): static
    {
        $this->requiredCompetences->removeElement($requiredCompetence);

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getAssignedTeams(): Collection
    {
        return $this->assignedTeams;
    }

    public function addAssignedTeam(Team $team): static
    {
        if (!$this->assignedTeams->contains($team)) {
            $this->assignedTeams->add($team);
            $team->addMission($this); // Si la relation est bidirectionnelle
        }

        return $this;
    }

    public function removeAssignedTeam(Team $team): static
    {
        if ($this->assignedTeams->removeElement($team)) {
            $team->removeMission($this); // Si la relation est bidirectionnelle
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mercenheros $leader = null;

    /**
     * @var Collection<int, Mercenheros>
     */
    #[ORM\ManyToMany(targetEntity: Mercenheros::class, inversedBy: 'teamMembers')]
    private Collection $members;

    /**
     * @var Collection<int, Missions>
     */
    #[ORM\OneToMany(targetEntity: Missions::class, mappedBy: 'assignedTeam', orphanRemoval: true)]
    private Collection $assignedMissions;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->assignedMissions = new ArrayCollection();
        $this->isActive = true; // Par défaut, une équipe est active
        $this->createdAt = new \DateTimeImmutable(); // Date de création initialisée
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

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;

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

    public function getLeader(): ?Mercenheros
    {
        return $this->leader;
    }

    public function setLeader(?Mercenheros $leader): static
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * @return Collection<int, Mercenheros>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Mercenheros $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
        }

        return $this;
    }

    public function removeMember(Mercenheros $member): static
    {
        $this->members->removeElement($member);

        return $this;
    }

    /**
     * @return Collection<int, Missions>
     */
    public function getAssignedMissions(): Collection
    {
        return $this->assignedMissions;
    }

    public function addAssignedMission(Missions $assignedMission): static
    {
        if (!$this->assignedMissions->contains($assignedMission)) {
            $this->assignedMissions->add($assignedMission);
            $assignedMission->setAssignedTeam($this);
        }

        return $this;
    }

    public function removeAssignedMission(Missions $assignedMission): static
    {
        if ($this->assignedMissions->removeElement($assignedMission)) {
            // set the owning side to null (unless already changed)
            if ($assignedMission->getAssignedTeam() === $this) {
                $assignedMission->setAssignedTeam(null);
            }
        }

        return $this;
    }
}

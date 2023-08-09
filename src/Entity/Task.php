<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $documentation = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Project $project = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dueDate = null;

    #[ORM\ManyToMany(targetEntity: Contributor::class, mappedBy: 'tasks')]
    private Collection $contributors;

    #[ORM\Column]
    private ?bool $isFinished = null;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'dependencyTasks')]
    private Collection $taskDependancies;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'taskDependancies')]
    private Collection $dependencyTasks;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: TaskHistory::class)]
    private Collection $taskHistories;

    #[ORM\ManyToMany(targetEntity: Media::class, inversedBy: 'tasks')]
    private Collection $media;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: Blocker::class, orphanRemoval: true)]
    private Collection $blockers;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->contributors = new ArrayCollection();
        $this->taskDependancies = new ArrayCollection();
        $this->dependencyTasks = new ArrayCollection();
        $this->taskHistories = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->blockers = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
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

    public function getDocumentation(): ?string
    {
        return $this->documentation;
    }

    public function setDocumentation(?string $documentation): static
    {
        $this->documentation = $documentation;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeInterface $dueDate): static
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @return Collection<int, Contributor>
     */
    public function getContributors(): Collection
    {
        return $this->contributors;
    }

    public function addContributor(Contributor $contributor): static
    {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors->add($contributor);
            $contributor->addTask($this);
        }

        return $this;
    }

    public function removeContributor(Contributor $contributor): static
    {
        if ($this->contributors->removeElement($contributor)) {
            $contributor->removeTask($this);
        }

        return $this;
    }

    public function isIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): static
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getTaskDependancies(): Collection
    {
        return $this->taskDependancies;
    }

    public function addTaskDependancy(self $taskDependancy): static
    {
        if (!$this->taskDependancies->contains($taskDependancy)) {
            $this->taskDependancies->add($taskDependancy);
        }

        return $this;
    }

    public function removeTaskDependancy(self $taskDependancy): static
    {
        $this->taskDependancies->removeElement($taskDependancy);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getDependencyTasks(): Collection
    {
        return $this->dependencyTasks;
    }

    public function addDependencyTask(self $dependencyTask): static
    {
        if (!$this->dependencyTasks->contains($dependencyTask)) {
            $this->dependencyTasks->add($dependencyTask);
            $dependencyTask->addTaskDependancy($this);
        }

        return $this;
    }

    public function removeDependencyTask(self $dependencyTask): static
    {
        if ($this->dependencyTasks->removeElement($dependencyTask)) {
            $dependencyTask->removeTaskDependancy($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TaskHistory>
     */
    public function getTaskHistories(): Collection
    {
        return $this->taskHistories;
    }

    public function addTaskHistory(TaskHistory $taskHistory): static
    {
        if (!$this->taskHistories->contains($taskHistory)) {
            $this->taskHistories->add($taskHistory);
            $taskHistory->setTask($this);
        }

        return $this;
    }

    public function removeTaskHistory(TaskHistory $taskHistory): static
    {
        if ($this->taskHistories->removeElement($taskHistory)) {
            // set the owning side to null (unless already changed)
            if ($taskHistory->getTask() === $this) {
                $taskHistory->setTask(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): static
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
        }

        return $this;
    }

    public function removeMedium(Media $medium): static
    {
        $this->media->removeElement($medium);

        return $this;
    }

    /**
     * @return Collection<int, Blocker>
     */
    public function getBlockers(): Collection
    {
        return $this->blockers;
    }

    public function addBlocker(Blocker $blocker): static
    {
        if (!$this->blockers->contains($blocker)) {
            $this->blockers->add($blocker);
            $blocker->setTask($this);
        }

        return $this;
    }

    public function removeBlocker(Blocker $blocker): static
    {
        if ($this->blockers->removeElement($blocker)) {
            // set the owning side to null (unless already changed)
            if ($blocker->getTask() === $this) {
                $blocker->setTask(null);
            }
        }

        return $this;
    }
}

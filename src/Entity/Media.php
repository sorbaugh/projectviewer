<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $file = null;

    #[ORM\ManyToMany(targetEntity: TaskHistory::class, mappedBy: 'media')]
    private Collection $taskHistories;

    #[ORM\ManyToMany(targetEntity: Task::class, mappedBy: 'media')]
    private Collection $tasks;

    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'media')]
    private Collection $projects;

    #[ORM\ManyToMany(targetEntity: Contribution::class, mappedBy: 'media')]
    private Collection $contributions;

    public function __construct()
    {
        $this->taskHistories = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->contributions = new ArrayCollection();
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

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile($file): static
    {
        $this->file = $file;

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
            $taskHistory->addMedium($this);
        }

        return $this;
    }

    public function removeTaskHistory(TaskHistory $taskHistory): static
    {
        if ($this->taskHistories->removeElement($taskHistory)) {
            $taskHistory->removeMedium($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->addMedium($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            $task->removeMedium($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->addMedium($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            $project->removeMedium($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Contribution>
     */
    public function getContributions(): Collection
    {
        return $this->contributions;
    }

    public function addContribution(Contribution $contribution): static
    {
        if (!$this->contributions->contains($contribution)) {
            $this->contributions->add($contribution);
            $contribution->addMedium($this);
        }

        return $this;
    }

    public function removeContribution(Contribution $contribution): static
    {
        if ($this->contributions->removeElement($contribution)) {
            $contribution->removeMedium($this);
        }

        return $this;
    }
}

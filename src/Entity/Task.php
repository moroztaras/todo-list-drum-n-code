<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    use UuidEntity;

    const TASK_STATUS_TODO = 'todo';
    const TASK_STATUS_DONE = 'done';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'status', type: 'string')]
    private string $status = self::TASK_STATUS_TODO;

    #[ORM\Column(name:  'priority', type:'integer', length: 1, nullable: false)]
    private int $priority;

    #[Assert\Length(
        min: 1,
        max: 256,
        minMessage: 'The title must be at least 1 characters',
        maxMessage: 'The title must be no more than 256 characters'
    )]
    #[ORM\Column(name: 'title', type: 'string')]
    private string $title;

    #[Assert\Length(
        min: 1,
        max: 1000,
        minMessage: 'The description must be at least 1 characters',
        maxMessage: 'The description must be no more than 1000 characters'
    )]
    #[ORM\Column(name: 'description', type: 'string', length: 1000, nullable: false)]
    private string $description;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'twitters')]
    private ?User $user;

    #[ORM\ManyToOne(targetEntity: 'Task')]
    #[ORM\JoinColumn(name: 'sub_task_id', referencedColumnName: 'id')]
    private $subTask;

    private bool $isSubTask = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTime $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTime $completedAt;

    public function setDateTime(): void
    {
        $this->createdAt = new \DateTime();
        $this->completedAt = new \DateTime();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function setSubTack(Task $task): self
    {
        $this->subTask = $task;

        return $this;
    }

    public function getSubTack(): Task|null
    {
        if (is_null($this->subTask)) {
            return $this->subTask;
        }
        $this->subTask->setIsSubTask(true);

        return $this->subTask;
    }

    public function isSubTask(): bool
    {
        return $this->isSubTask;
    }

    public function setIsSubTask(bool $isSubTask): self
    {
        $this->isSubTask = $isSubTask;

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCompletedAt(): \DateTime
    {
        return $this->completedAt;
    }

    public function setCompletedAt(\DateTime $completedAt): self
    {
        $this->completedAt = $completedAt;

        return $this;
    }
}

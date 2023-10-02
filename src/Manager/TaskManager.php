<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\TaskRepository;
use App\Validator\Helper\ApiObjectValidator;
use Doctrine\Persistence\ManagerRegistry;

class TaskManager
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private ApiObjectValidator $apiObjectValidator,
        private TaskRepository $taskRepository,
    ) {
    }

    public function getTasksOfUser(int $userId, string $sortBy)
    {
        return $this->taskRepository->getTasksOfUserAndSortByField($userId, $sortBy);

    }
}
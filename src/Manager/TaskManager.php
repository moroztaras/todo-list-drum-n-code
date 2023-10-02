<?php

namespace App\Manager;

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
}
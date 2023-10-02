<?php

namespace App\Controller\Api;

use App\Manager\TaskManager;
use App\Response\SuccessResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/task', name: 'api_twitter')]
class TaskController extends ApiController
{
    public function __construct(
        private TaskManager $taskManager,
    ) {
    }

}

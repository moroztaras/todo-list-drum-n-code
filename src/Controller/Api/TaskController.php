<?php

namespace App\Controller\Api;

use App\Entity\Task;
use App\Entity\User;
use App\Exception\Api\BadRequestJsonHttpException;
use App\Exception\Api\ForbiddenJsonHttpException;
use App\Manager\TaskManager;
use App\Response\SuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/task', name: 'api_task')]
class TaskController extends ApiController
{
    public function __construct(
        private TaskManager $taskManager,
    ) {
    }

    #[Route('', name: 'api_task_list', methods: 'GET')]
    public function list(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->getCurrentUser($request);
        $sortBy = $request->query->get('sort_by', 'createdAt');

        return $this->json([
            'tasks' => $this->taskManager->getTasksOfUser($user->getId(), (string) $sortBy),
        ], Response::HTTP_OK);
    }

    #[Route('', name: 'api_task_create', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser($request);

        if (!($content = $request->getContent())) {
            throw new BadRequestJsonHttpException('Bad Request.');
        }

        return $this->json(['task' => $this->taskManager->createNewTask($user, $content)], Response::HTTP_OK, [], ['create' => true]);
    }

    #[Route(path: '/{id}', name: 'api_task_edit', methods: 'PUT')]
    public function edit(Request $request, Task $task): JsonResponse
    {
        $user = $this->getCurrentUser($request);

        if ($user->getId() !== $task->getUser()->getId())
        {
            throw new ForbiddenJsonHttpException('403', 'Forbidden edit this task.');
        }

        if (!($content = $request->getContent())) {
            throw new BadRequestJsonHttpException('Bad Request.');
        }

        return $this->json(['task' => $this->taskManager->editTask($content, $task)], Response::HTTP_OK, [], ['edit' => true]);
    }

    #[Route(path: '/{id}', name: 'api_task_delete', methods: 'DELETE')]
    public function delete(Request $request, Task $task): JsonResponse
    {
        $user = $this->getCurrentUser($request);

        if (($user->getId() !== $task->getUser()->getId()) || ($task->getStatus() === Task::TASK_STATUS_TODO))
        {
            throw new ForbiddenJsonHttpException('403', 'Forbidden delete this task.');
        }

        $this->taskManager->removeTask($task);

        return new SuccessResponse('Task was deleted');
    }
}

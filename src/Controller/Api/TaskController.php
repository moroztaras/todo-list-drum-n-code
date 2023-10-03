<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Exception\Api\BadRequestJsonHttpException;
use App\Manager\TaskManager;
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

    // List tasks sort by field of user
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

    // Create new task
    #[Route('', name: 'api_task_create', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser($request);

        if (!($content = $request->getContent())) {
            throw new BadRequestJsonHttpException('Bad Request.');
        }

        return $this->json(['task' => $this->taskManager->createNewTask($user, $content)], Response::HTTP_OK, [], ['create' => true]);
    }
}

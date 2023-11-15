<?php

namespace App\Controller\Api;

use App\Entity\Task;
use App\Entity\User;
use App\Exception\Api\BadRequestJsonHttpException;
use App\Exception\Api\ForbiddenJsonHttpException;
use App\Exception\Api\TaskNotFoundException;
use App\Manager\TaskManager;
use App\Model\TaskResponseModel;
use App\Model\TaskRequestModel;
use App\Response\SuccessResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/tasks', name: 'api_task')]
class TaskController extends ApiController
{
    public function __construct(private TaskManager $taskManager)
    {
    }

    #[Route('', name: 'api_tasks_list', methods: 'GET')]
    public function list(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->getCurrentUser($request);
        $orderBy = $request->query->get('order_by', 'createdAt');
        $field = $request->query->get('field',null);
        $value = $request->query->get('value',null);

        $tasks = $this->taskManager->getTasksOfUser($user, $orderBy, $field, $value);

        if (!$tasks) {
            throw new TaskNotFoundException();
        }

        return $this->json(['tasks' => $tasks], Response::HTTP_OK);
    }

    #[Route('', name: 'api_tasks_create', methods: 'POST')]
    /**
     * @OA\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="X-API-KEY",
     *     @OA\Schema(type="string")
     * )
     * @OA\RequestBody(@Model(type=TaskRequestModel::class))
     * @OA\Response(
     *     response=200,
     *     description="New task created successful.",
     *     @Model(type=TaskResponseModel::class)
     * )
     * @OA\Response(response=400, description="Bad Request")
     * @OA\Response(response=401, description="User Not Unauthorized")
     */
    public function create(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser($request);

        if (!($content = $request->getContent())) {
            throw new BadRequestJsonHttpException('Bad Request.');
        }

        return $this->json(['task' => $this->taskManager->createNewTask($user, $content)], Response::HTTP_OK, [], ['create' => true]);
    }

    #[Route(path: '/{uuid}', name: 'api_tasks_edit', methods: 'PUT')]
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

    #[Route(path: '/{uuid}', name: 'api_tasks_delete', methods: 'DELETE')]
    public function delete(Request $request, Task $task): JsonResponse
    {
        $user = $this->getCurrentUser($request);

        if (($user->getId() !== $task->getUser()->getId()) || ($task->getStatus() === Task::TASK_STATUS_DONE))
        {
            throw new ForbiddenJsonHttpException('403', 'Forbidden delete this task.');
        }

        $this->taskManager->remove($task);

        return new SuccessResponse('Task was deleted');
    }
}

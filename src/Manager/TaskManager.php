<?php

namespace App\Manager;

use App\Entity\Task;
use App\Entity\User;
use App\Exception\Expected\ExpectedBadRequestJsonHttpException;
use App\Repository\TaskRepository;
use App\Validator\Helper\ApiObjectValidator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;

class TaskManager
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private ApiObjectValidator $apiObjectValidator,
        private TaskRepository $taskRepository,
    ) {
    }

    public function getTasksOfUser(User $user, string $orderBy, string|null $field, string|int|null $value):array
    {
        return $this->taskRepository->findTasksOfUserAndOrderByField($user, $orderBy, $field, $value);
    }

    public function createNewTask(?User $user, string $content):Task
    {
        /** @var Task $task */
        $task = $this->apiObjectValidator->deserializeAndValidate($content, Task::class, [
            UnwrappingDenormalizer::UNWRAP_PATH => '[task]',
            'create' => true,
        ]);

        if ($this->doctrine->getRepository(Task::class)->findOneBy(['title'=> $task->getTitle()])) {
            throw new ExpectedBadRequestJsonHttpException('Task already exists.');
        }

        $task->setUser($user)->setCreatedAt(new \DateTimeImmutable());
        $this->save($task);

        return $task;
    }

    public function editTask(string $content, Task $task): Task
    {
        $validationGroups = ['edit'];

        $this->apiObjectValidator->deserializeAndValidate($content, Task::class, [
            AbstractNormalizer::OBJECT_TO_POPULATE => $task,
            AbstractObjectNormalizer::DEEP_OBJECT_TO_POPULATE => true,
            UnwrappingDenormalizer::UNWRAP_PATH => '[task]',
        ], $validationGroups);

        $this->save($task);

        return $task;
    }

    private function save(Task $task): void
    {
        $this->doctrine->getManager()->persist($task);
        $this->doctrine->getManager()->flush();
    }

    public function remove(Task $task)
    {
        $this->doctrine->getManager()->remove($task);
        $this->doctrine->getManager()->flush();
    }
}
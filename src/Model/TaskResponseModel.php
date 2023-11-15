<?php

namespace App\Model;

class TaskResponseModel
{
    private TaskItemsResponseModel $task;

    /**
     * @param TaskItemsResponseModel $task
     */
    public function __construct(array $task)
    {
        $this->task = $task;
    }

    /**
     * @return TaskItemsResponseModel
     */
    public function getTask(): array
    {
        return $this->task;
    }
}

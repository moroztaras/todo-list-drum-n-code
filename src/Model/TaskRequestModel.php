<?php

namespace App\Model;

class TaskRequestModel
{
    private TaskItemsRequestModel $task;

    /**
     * @param TaskItemsRequestModel $task
     */
    public function __construct(array $task)
    {
        $this->task = $task;
    }

    /**
     * @return TaskItemsRequestModel
     */
    public function getTask(): array
    {
        return $this->task;
    }
}
<?php

namespace App\Normalizer;

use App\Entity\Task;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TaskNormalizer implements NormalizerInterface
{
    /**
     * @param Task    $object object to normalize
     * @param null    $format
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'priority' => $object->getPriority(),
            'title' => $object->getTitle(),
            'description' => $object->getDescription(),
            'status' => $object->getStatus(),
            'sub_task' => $object->isSubTask(),
            'created_at' => $object->getCreatedAt()->format('c'),
        ];
    }

    public function supportsNormalization($task, $format = null)
    {
        return $task instanceof Task;
    }
}
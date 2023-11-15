<?php

namespace App\Normalizer;

use App\Entity\Task;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TaskNormalizer implements NormalizerInterface
{
    /**
     * @param Task $object object to normalize
     * @param null $format
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        return [
            'uuid' => $object->getUuid(),
            'title' => $object->getTitle(),
            'description' => $object->getDescription(),
            'priority' => $object->getPriority(),
            'status' => $object->getStatus(),
            'subTask' => $object->isSubTask(),
            'completedAt' => $object->getCompletedAt()->format('c'),
            'createdAt' => $object->getCreatedAt()->format('c'),
        ];
    }

    public function supportsNormalization($task, $format = null)
    {
        return $task instanceof Task;
    }
}

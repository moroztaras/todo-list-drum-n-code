<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function getTasksOfUserAndSortByField(int $userId, string $sortBy)
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.user', 'user')
            ->where('user.id = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('t.'.$sortBy, Criteria::DESC)
            ->getQuery()
            ->getResult()
        ;
    }
}

<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
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

    public function getTasksOfUserAndOrderByField(User $user, string $orderBy):array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.user', 'user')
            ->where('user.uuid = :uuid')
            ->setParameter('uuid', $user->getUuid())
            ->orderBy('t.'.$orderBy, Criteria::ASC)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findTasksByFieldAndValue(User $user,string $field, string $value):array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.user', 'user')
            ->where('user.uuid = :uuid')
            ->setParameter('uuid', $user->getUuid())
            ->andWhere('t.'.$field.' = :value')
            ->setParameter('value', $value)
            ->getQuery()
            ->getResult()
            ;
    }
}

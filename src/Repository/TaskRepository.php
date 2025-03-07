<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * Find active tasks
     */
    public function findActiveTasks($sort = 'created_at', $order = 'DESC', $limit = 5, $offset = 0)
    {
        return $this->createQueryBuilder('t')
            ->where('t.deleted_at IS NULL')
            ->orderBy('t.' . $sort, $order) // Correct way to use field and order
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

}

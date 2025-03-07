<?php

// src/Service/TaskService.php

namespace App\Service;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TaskRepository;
use Psr\Log\LoggerInterface;

class TaskService
{
    private $entityManager;
    private $taskRepository;
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, TaskRepository $taskRepository, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->taskRepository = $taskRepository;
        $this->logger = $logger;
    }

    public function getTasks(int $page): array
    {
        $limit = 5;
        $offset = ($page - 1) * $limit;

        // Call repository to fetch active tasks with pagination
        return $this->taskRepository->findActiveTasks('created_at', 'DESC', $limit, $offset);
    }

    
    
    /*
    * Get total tasks (should move to the Repository)
    */
    public function getTotalTasks(): int
    {
        $queryBuilder = $this->entityManager->getRepository(Task::class)->createQueryBuilder('t')
            ->select('COUNT(t.id)');
        
        $count = $queryBuilder->getQuery()->getSingleScalarResult();

    
        return (int) $count;
    }


    public function addTask(Task $task): void
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function updateTask(Task $task): void
    {
        $this->entityManager->flush();
    }

    public function deleteTask(Task $task): void
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }

    public function toggleTask(int $id): bool
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);
        
        if ($task) {
            // Toggle the is_done property
            $task->setIsDone(!$task->getIsDone());

            // Persist changes to the database
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}

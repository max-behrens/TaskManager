<?php

// src/Controller/TaskController.php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    private $taskService;

    public function __construct(TaskService $taskService) 
    {
        $this->taskService = $taskService;
    }

    #[Route('/tasks', name: 'task_list', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        // Get the current page (default is 1).
        $page = (int) $request->get('page', 1);
    
        // Get tasks for the current page using the service method.
        $tasks = $this->taskService->getTasks($page);
    
        // Get the total number of tasks to calculate the total pages.
        $totalTasks = $this->taskService->getTotalTasks();
        $limit = 5;
        $totalPages = ceil($totalTasks / $limit);
    
        // Create form for adding new task
        $form = $this->createForm(TaskType::class, new Task());
    
        // Return the response explicitly with the rendered template.
        return $this->render('tasks/index.html.twig', [
            'tasks' => $tasks,
            'form' => $form->createView(),
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }
    
    

    /*
    * Add task
    */
    #[Route('/tasks/add', name: 'task_add', methods: ['POST'])]
    public function add(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskService->addTask($task);
            $this->addFlash('success', 'Calculation created successfully!');

            return $this->redirectToRoute('task_list');
        }
        

        return $this->render('tasks/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /*
    * Edit task
    */
    #[Route('/tasks/{id}/edit', name: 'task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task)
    {
        $form = $this->createForm(TaskType::class, $task, ['show_save_button' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskService->updateTask($task);
            return $this->redirectToRoute('task_list');
        }

        return $this->render('tasks/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /*
    * Delete task
    */
    #[Route('/tasks/{id}/delete', name: 'task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task)
    {
        $this->taskService->deleteTask($task);
        return $this->redirectToRoute('task_list');
    }

    /*
    * Toggle task (Done/Undone) via AJAX
    */
    #[Route('/tasks/{id}/toggle', name: 'task_toggle', methods: ['POST'])]
    public function toggle(int $id): JsonResponse
    {
        try {
            $success = $this->taskService->toggleTask($id);
            return new JsonResponse(['success' => $success]);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

}

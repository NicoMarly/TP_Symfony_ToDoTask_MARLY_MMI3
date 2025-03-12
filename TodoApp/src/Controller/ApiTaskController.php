<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/tasks', name: 'api_task_')]
class ApiTaskController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(TaskRepository $taskRepository): JsonResponse
    {
        $tasks = $taskRepository->findAll();
        return $this->json($tasks, Response::HTTP_OK, [], ['groups' => 'task:read']);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Task $task): JsonResponse
    {
        return $this->json($task, Response::HTTP_OK, [], ['groups' => 'task:read']);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['title']) || empty($data['title'])) {
            return $this->json(['error' => 'Le titre est requis'], Response::HTTP_BAD_REQUEST);
        }

        $task = new Task();
        $task->setTitle($data['title']);
        $task->setDescription($data['description'] ?? null);
        $task->setStatus($data['status'] ?? false);
        $task->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $this->json($task, Response::HTTP_CREATED, [], ['groups' => 'task:read']);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(Request $request, Task $task): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (isset($data['title'])) {
            $task->setTitle($data['title']);
        }
        if (isset($data['description'])) {
            $task->setDescription($data['description']);
        }
        if (isset($data['status'])) {
            $task->setStatus((bool) $data['status']);
        }

        $this->entityManager->flush();

        return $this->json($task, Response::HTTP_OK, [], ['groups' => 'task:read']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Task $task): JsonResponse
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return $this->json(['message' => 'Tâche supprimée avec succès'], Response::HTTP_NO_CONTENT);
    }
}

<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../Models/Task.php";




class TaskController
{
    public function list(): array
    {
        if (!isset($_SESSION['user_id']))
        {
            return [];
        }

        $userId = $_SESSION['user_id'];
        return Task::getAllByUser($userId);
    }

    public function create(string $title): bool
    {
        if (!isset($_SESSION['user_id']))
        {
            return false;
        }

        $userId = $_SESSION['user_id'];
        $task = new Task();
        return $task->create($userId, $title);
    }

    public function update(int $taskId, string $title, bool $is_completed): bool
    {
        if (!isset($_SESSION['user_id']))
        {
            return false;
        }

        $task = new Task();
        $task->id = $taskId;
        $task->user_id = $_SESSION['user_id'];

        return $task->update($title, $is_completed);
    }

    public function delete(int $taskId): bool
    {
        if (!isset($_SESSION['user_id']))
        {
            return false;
        }

        $task = new Task();
        $task->id = $taskId;
        $task->user_id = $_SESSION['user_id'];

        return $task->delete();
    }
}

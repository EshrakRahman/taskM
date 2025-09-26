<?php

declare(strict_types=1);
require_once __DIR__ . "/../config/Database.php";

class Task
{
    public int $id;
    public int $user_id;
    public string $title;
    public bool $is_completed;
    public string $created_at;

    public function create(int $userId, string $title): bool
    {
        $sql = "insert into tasks (user_id, title) values (:user_id, :title)";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":title", $title);
        return $stmt->execute();
    }


    public static function getAllByUser(int $userId): array
    {
        $sql = "select * from tasks where user_id = :user_id";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $tasks = [];

        foreach ($rows as $data)
        {
            $task = new self();
            $task->id = (int)$data['id'];
            $task->user_id = (int)$data['user_id'];
            $task->title = $data['title'];
            $task->is_completed = (bool)$data['is_completed'];
            $task->created_at = $data['created_at'];
            $tasks[] = $task;
        }

        return $tasks;
    }


    public function update(string $title, bool $is_completed): bool
    {
        $sql = "UPDATE tasks 
            SET title = :title, is_completed = :is_completed 
            WHERE id = :id AND user_id = :user_id";

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":is_completed", $is_completed, PDO::PARAM_BOOL);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);

        return $stmt->execute();
    }


    public function delete(): bool
    {
        $sql = "DELETE FROM tasks WHERE id = :id AND user_id = :user_id";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);

        return $stmt->execute();
    }
}

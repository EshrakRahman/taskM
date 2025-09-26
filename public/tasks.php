<?php
session_start();

require_once "../Controllers/TaskController.php";
require_once "../Controllers/AuthController.php";

if (!isset($_SESSION['user_id'])) {
    echo "Please log in first.";
    exit;
}

$taskController = new TaskController();
$authController = new AuthController();
$message = "";

// Add Task
if (isset($_POST['add_task']) && !empty($_POST['title'])) {
    $title = trim($_POST['title']);
    $success = $taskController->create($title);
    $message = $success ? "Task added successfully!" : "Failed to add task.";
}

$editTask = null;
$tasks = $taskController->list(); 

if (isset($_GET['edit'])) {
    $taskId = (int)$_GET['edit'];
    foreach ($tasks as $task) {
        if ($task->id === $taskId) {
            $editTask = $task;
            break;
        }
    }
}

if (isset($_POST['edit_task']) && !empty($_POST['title']) && isset($_POST['task_id'])) {
    $taskId = (int)$_POST['task_id'];
    $title = trim($_POST['title']);

    $currentTask = null;
    foreach ($tasks as $task) {
        if ($task->id === $taskId) {
            $currentTask = $task;
            break;
        }
    }

    if ($currentTask) {
        $taskController->update($taskId, $title, $currentTask->is_completed);
        $message = "Task updated.";
        $tasks = $taskController->list(); // refresh
    }
}

if (isset($_GET['delete'])) {
    $taskId = (int)$_GET['delete'];
    $success = $taskController->delete($taskId);
    $message = $success ? "Task deleted." : "Failed to delete task.";
    $tasks = $taskController->list();
}

if (isset($_GET['toggle'])) {
    $taskId = (int)$_GET['toggle'];
    foreach ($tasks as $task) {
        if ($task->id === $taskId) {
            $taskController->update($taskId, $task->title, !$task->is_completed);
            $message = "Task updated.";
            $tasks = $taskController->list();
            break;
        }
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../views/auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Tasks</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-2xl mx-auto mt-10">

    <?php if ($message): ?>
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <div class="flex justify-end mb-4">
        <a href="?logout=1" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</a>
    </div>

    <form action="" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6">
        <div class="mb-4">
            <input 
                type="text" 
                name="title" 
                placeholder="Enter new task..." 
                required 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            >
        </div>
        <button type="submit" name="add_task" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add Task
        </button>
    </form>

    <ul class="bg-white shadow-md rounded px-4 py-2">
        <?php if (empty($tasks)): ?>
            <li class="text-gray-500 py-2">No tasks yet.</li>
        <?php endif; ?>

        <?php foreach ($tasks as $task): ?>
            <li class="flex justify-between items-center border-b py-2">
                <?php if ($editTask && $editTask->id === $task->id): ?>
                    <form method="POST" class="flex w-full items-center space-x-2">
                        <input type="hidden" name="task_id" value="<?php echo $task->id; ?>">
                        <input type="text" name="title" value="<?php echo htmlspecialchars($task->title); ?>" class="shadow border rounded w-full py-1 px-2">
                        <button type="submit" name="edit_task" class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-2 rounded">Save</button>
                        <a href="tasks.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-1 px-2 rounded">Cancel</a>
                    </form>
                <?php else: ?>
                    <span class="<?php echo $task->is_completed ? 'line-through text-gray-500' : ''; ?>">
                        <?php echo htmlspecialchars($task->title); ?>
                    </span>
                    <div class="flex space-x-2">
                        <a href="?toggle=<?php echo $task->id; ?>" class="bg-green-500 hover:bg-green-700 text-white py-1 px-2 rounded">
                            <?php echo $task->is_completed ? 'Mark Incomplete' : 'Mark Complete'; ?>
                        </a>
                        <a href="?edit=<?php echo $task->id; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-2 rounded">Edit</a>
                        <a href="?delete=<?php echo $task->id; ?>" class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">Delete</a>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

</div>

</body>
</html>

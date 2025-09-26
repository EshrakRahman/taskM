<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to add tasks.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Task</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="max-w-md mx-auto mt-10">

    <!-- Add Task Form -->
    <form action="tasks.php" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-xl font-bold mb-4">Add New Task</h2>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                Task Title
            </label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                required 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Enter task..."
            >
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" name="add_task" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Add Task
            </button>
        </div>
    </form>

</div>

</body>
</html>

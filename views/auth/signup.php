<?php
session_start();
require_once "../../Controllers/AuthController.php";

$authController = new AuthController();
$message = "";

if (isset($_POST['signup']) && !empty($_POST['username']) && !empty($_POST['password']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $success = $authController->signup($username, $password);
    $message = $success ? "Signup successful! Redirecting to tasks..." : "Username already exists.";
    if ($success)
    {
        header("Location: ../../public/tasks.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body class="bg-gray-100">
    <div class="max-w-md mx-auto mt-10">
        <form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-xl font-bold mb-4">Sign Up</h2>

            <?php if ($message): ?>
                <div class="bg-red-200 text-red-800 p-2 rounded mb-4"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <div class="mb-4">
                <input type="text" name="username" placeholder="Username" required class="shadow border rounded w-full py-2 px-3">
            </div>
            <div class="mb-4">
                <input type="password" name="password" placeholder="Password" required class="shadow border rounded w-full py-2 px-3">
            </div>
            <button type="submit" name="signup" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php" class="text-blue-500">Login</a></p>
    </div>
</body>

</html>
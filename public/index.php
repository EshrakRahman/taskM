<?php
session_start();

// If user is logged in, go to tasks page
if (isset($_SESSION['user_id'])) {
    header("Location: tasks.php");
    exit;
} else {
    header("Location: ../views/auth/login.php");
    exit;
}

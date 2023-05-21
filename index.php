<?php
session_start();

require_once 'controllers/TaskController.php'; 
require_once 'controllers/AuthController.php';

// Значения параметров из URL
$action = $_GET['action'] ?? '';
$sortDate = $_GET['filterDate'] ?? null;
$filterType = $_GET['filterType'] ?? 'all';

// Проверка авторизации пользователя и переправление на страницу входа
if (!AuthController::isLoggedIn() && $action !== 'login' && $action !== 'register') {
    header("Location: index.php?action=login");
    exit();
}

// Обработка формы для создания задачи
if ($action === 'create' && !empty($_POST)) {
    $taskController = new TaskController();
    $created = $taskController->createTask($_POST);
    if ($created) {
        header("Location: index.php");
        exit();
    }
}

// Обработка формы для получения задачи
if ($action === 'view') {
    $id = $_GET['id'];
    $taskController = new TaskController();
    $task = $taskController->getTaskById($id);
    if ($task) {
        include 'views/task.php';
        exit();
    }
}

// Обработка формы для редактирования задачи
if ($action === 'edit' && !empty($_POST)) {
    $id = $_GET['id'];
    $taskController = new TaskController();
    $updated = $taskController->updateTask($id, $_POST);
    if ($updated) {
        header("Location: index.php");
        exit();
    }
}

// Обработка завершения задачи 
if ($action === 'complete') {
    $id = $_GET['id'];
    $taskController = new TaskController();
    $completed = isset($_POST['completed']);
    $updated = $taskController->updateTaskStatus($id, $completed);
    if ($updated) {
        header("Location: index.php");
        exit();
    }
}

// Обработка действий аутентификации
if ($action === 'login' && !AuthController::isLoggedIn()) {
    if (!empty($_POST)) {
        $authController = new AuthController();
        $loggedIn = $authController->login($_POST['username'], $_POST['password']);
        if ($loggedIn) {
            header("Location: index.php");
            exit();
        }
    }
    include 'views/login.php';
    exit();
}

// Обработка действий регистрации
if ($action === 'register' && !AuthController::isLoggedIn()) {
    if (!empty($_POST)) {
        $authController = new AuthController();
        $registered = $authController->register($_POST['username'], $_POST['password']);
        if ($registered) {
            header("Location: index.php");
            exit();
        }
    }
    include 'views/register.php';
    exit();
}

include 'views/home.php';
?>

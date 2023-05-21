<?php

require_once 'models/Task.php';
require_once 'database/db.php';

class TaskController
{
    // Функция создания класса
    public function createTask($data) {
        $theme = $data['theme'];
        $user_id = $_SESSION['user_id'];
        $type = $data['type'];
        $location = $data['location'];
        $datetime = $data['datetime'];
        $duration = $data['duration'];
        $comment = $data['comment'];

        // SQL запрос для вставки данных в базу данных в таблицу tasks
        $sql = "INSERT INTO tasks (theme, user_id, type, location, datetime, duration, comment)
        VALUES ('$theme','$user_id', '$type', '$location', '$datetime', '$duration', '$comment')";

        global $conn;
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Ошибка при создании задачи: " . $conn->error;
            return false;
        }
    }

    // Функция получения задач
    public function getTasks($sortDate = null, $filterType = 'all') {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM tasks WHERE user_id = '$user_id'";
    
    // Переменные для сортировки
    $currentDateTime = date('Y-m-d H:i:s');
    $nextDay = date('Y-m-d', strtotime('+1 day'));
    $currentDay = date('Y-m-d');
    $startOfСurrentWeek = date('Y-m-d', strtotime('monday this week'));
    $endOfСurrentWeek = date('Y-m-d', strtotime('sunday this week'));
    $startOfNextWeek = date('Y-m-d', strtotime('monday next week'));
    $endOfNextWeek = date('Y-m-d', strtotime('sunday next week'));

    // Сортировка задач по дате, статусу
    if ($sortDate) {
        $sql .= " AND DATE(datetime) = '$sortDate'";
    }
    if ($filterType === 'current') {
        $sql .= " AND DATE_ADD(datetime, INTERVAL duration MINUTE) > '$currentDateTime' AND status != 'завершено' ";
    } elseif ($filterType === 'overdue') {
        $sql .= "AND DATE_ADD(datetime, INTERVAL duration MINUTE) <= '$currentDateTime' AND status != 'завершено'";
    } elseif ($filterType === 'completed') {
        $sql .= " AND status = 'завершено'";
    } elseif ($filterType === 'current_day') {
        $sql .= " AND DATE(datetime) = '$currentDay'";
    } elseif ($filterType === 'next_day') {
        $sql .= " AND DATE(datetime) = '$nextDay'";
    } elseif ($filterType === 'current_week') {
        $sql .= " AND DATE(datetime) BETWEEN '$startOfСurrentWeek' AND '$endOfСurrentWeek'";
    } elseif ($filterType === 'next_week') {
        $sql .= " AND DATE(datetime) BETWEEN '$startOfNextWeek' AND '$endOfNextWeek'";
    }

    global $conn;
    $result = $conn->query($sql);
    $tasks = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $task = new Task();
            $task->id = $row['id'];
            $task->theme = $row['theme'];
            $task->type = $row['type'];
            $task->location = $row['location'];
            $task->datetime = $row['datetime'];
            $task->duration = $row['duration'];
            $task->comment = $row['comment'];
            $task->status = $row['status'];

            $tasks[] = $task;
        }
    }
    return $tasks;
}

    // Функция получения задачи (для редактирования)
    public function getTaskById($id) {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM tasks WHERE id = '$id' AND user_id = '$user_id'";
      
        global $conn;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $task = new Task();
            $task->id = $row['id'];
            $task->theme = $row['theme'];
            $task->type = $row['type'];
            $task->location = $row['location'];
            $task->datetime = $row['datetime'];
            $task->duration = $row['duration'];
            $task->comment = $row['comment'];

            return $task;
        } else {
            return null;
        }
    }
    
    // Функция редактирования задачи
    public function updateTask($id, $data) {
    $theme = $data['theme'];
    $type = $data['type'];
    $location = $data['location'];
    $datetime = $data['datetime'];
    $duration = $data['duration'];
    $comment = $data['comment'];
    $status = isset($data['completed']) ? 'завершено' : 'не завершено';
    $user_id = $_SESSION['user_id']; 

    $sql = "UPDATE tasks
            SET theme = '$theme', type = '$type', location = '$location', 
            datetime = '$datetime', duration = '$duration', comment = '$comment'
            WHERE id = '$id' AND user_id = '$user_id'"; 

    global $conn;
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "Ошибка при обновлении задачи: " . $conn->error;
        return false;
    }
}
    // Функция обновления статуса задачи
    public function updateTaskStatus($id, $completed) {
        $status = $completed ? 'завершено' : 'запланировано';
        $sql = "UPDATE tasks SET status = '$status' WHERE id = '$id'";

        global $conn;
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Ошибка при обновлении статуса задачи: " . $conn->error;
            return false;
        }
    }
}

?>
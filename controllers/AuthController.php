<?php

require_once 'database/db.php';

class AuthController
{   
    // Функция проверки авторизации пользователя
    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    // Функция регистрации нового пользователя 
    public function register($username, $password)
    {
        global $conn;
        $username = $conn->real_escape_string($username);
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            header("Location: index.php?action=register&error=register_failed");
            exit();
        }

        // Хэшируем пароль перед сохранением в базу данных
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Сохраняем пользователя в базу данных
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($query)) {
            return true;
        } else {
            echo "Ошибка при регистрации: " . $conn->error;
            return false;
        }
    }

    // Функция логина пользователя
    public function login($username, $password)
    {
        global $conn;
        $username = $conn->real_escape_string($username);
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($query);

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                return true;
            }
        }

        header("Location: index.php?action=login&error=login_failed");
        exit();

    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}

?>
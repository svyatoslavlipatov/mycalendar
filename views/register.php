<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-top: 50px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        .block{
            min-width: 355px;
        }


        form {
            background-color: #fff;
            max-width: 350px;
            margin: 0 auto;
            padding: 25px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            width: 50%;
            padding: 8px;
            background-color: #3b7894;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 auto; 
            display: block;
        }
            
        button[type="submit"]:hover {
            background-color: #2a6381;
        }

        button[type="submit"]:active {
            background-color: #13567C;
        }

        .error-message {
            font-size: 14px;
            color: #cc0000;
            text-align: center;
            margin-top: 10px
        }

        p {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
<div class="block">
    <h1>Регистрация</h1>
    <form method="POST" action="index.php?action=register">
        <input type="text" name="username" placeholder="Имя пользователя" required><br>
        <input type="password" name="password" placeholder="Пароль" required><br>
        <button type="submit">Зарегистрироваться</button>
        <?php 
            if (isset($_GET['error']) && $_GET['error'] === 'register_failed') {
            echo '<div class="error-message">Пользователь с таким именем уже существует</div>';
            } 
        ?>
    </form>
    <p>Уже зарегистрированы? <a href="index.php?action=login">Войдите</a></p>
</div>
</body>
</html>

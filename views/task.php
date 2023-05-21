<!DOCTYPE html>
<html>
<head>
    <title>Мой календарь - редактирование</title>
    <style>
    body {
        background-color: #f2f2f2;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
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

    h1 {
        color: #333;
        text-align: center;
        margin-top: 50px;
    }

    form {
        background-color: #fff;
        margin: 0 auto;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 10px;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="datetime-local"],
    select,
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button[type="submit"] {
        width: 60%;
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
            <h1>Редактирование задачи</h1>
            <form method="post" action="index.php?action=edit&id=<?php echo $task->id; ?>">
                <div class="form-group">
                    <label for="theme">Тема:</label>
                    <input type="text" id="theme" name="theme" value="<?php echo $task->theme; ?>">
                </div>

                <div class="form-group">
                    <label for="type">Тип:</label>
                    <select id="type" name="type" required>
                        <option value="встреча"<?php if ($task->type == "встреча") echo " selected"; ?>>Встреча</option>
                        <option value="звонок"<?php if ($task->type == "звонок") echo " selected"; ?>>Звонок</option>
                        <option value="совещание"<?php if ($task->type == "совещание") echo " selected"; ?>>Совещание</option>
                        <option value="дело"<?php if ($task->type == "дело") echo " selected"; ?>>Дело</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="location">Место:</label>
                    <input type="text" id="location" name="location" value="<?php echo $task->location; ?>">
                </div>

                <div class="form-group">
                    <label for="datetime">Дата и время:</label>
                    <input type="datetime-local" id="datetime" name="datetime" value="<?php echo date('Y-m-d\TH:i', strtotime($task->datetime)); ?>">
                </div>

                <div class="form-group">
                    <label for="duration">Длительность:</label>
                    <input type="text" id="duration" name="duration" value="<?php echo $task->duration; ?>">
                </div>

                <div class="form-group">
                    <label for="comment">Комментарий:</label>
                    <textarea id="comment" name="comment"><?php echo $task->comment; ?></textarea>
                </div>

                <button type="submit">Сохранить изменения</button>
            </form>
        </div>
    </div>
</body>
</html>
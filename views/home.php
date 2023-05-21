<!DOCTYPE html>
<html>
<head>
    <title>Мой календарь</title>
    <style>
    body {
        background-color: #f2f2f2;
        font-family: Arial, sans-serif;
    }

    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        text-align: center;
        background-color: #fff;
        padding: 10px 20px 10px 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgb(0 0 0 / 20%);
        margin-bottom: 10px;
    }

    .container-create-task {
        background-color: #fff;
        padding: 10px 20px 20px 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgb(0 0 0 / 20%);
        margin-bottom: 10px;
        justify-content: center;
    }

    .create-task {
        margin-top: 20px;
    }

    .show-tasks {
        margin-top: 20px;
        background-color: #fff;
        margin: 0 auto;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgb(0 0 0 / 20%);
        padding: 10px 20px 20px 20px;
    }

    .sorting-tasks {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .form-sorting-tasks {
        display: inline-block;
        margin-right: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    a {
        color: #0000cc;
        text-decoration: none;
    }

    button {
        padding: 5px 10px;
        background-color: #3b7894;
        color: white;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #2a6381;
    }

    button:active {
        background-color: #13567C;
    }

    .exit{
        width: 70px;
        height: 30px;
    }

    td {
        max-width: 200px; 
        overflow: hidden; 
        text-overflow: ellipsis; 
        white-space: nowrap;
    }

    .form-create-task{
        display: flex;
        justify-content: center;
    }

    input[name="theme"],
    input[name="location"],
    input[name="duration"],
    select[name="type"],
    input[name="datetime"],
    textarea[name="comment"]{
        width: 100%;
        padding: 5px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[name="filterDate"],
    select[name="filterType"]{
       padding: 3px;

    }

    .form-tasks {
        width: 50%;
        margin: 0 auto;
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

    .save-task{
        display: block;
        margin: 0 auto;
        padding: 8px;
    }

    .btn-sort{
        padding: 2px 10px;
        background-color: #3b7894;
        color: white;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }

    .heading-create-task{
        text-align: center;
    }

    </style>
</head>
<?php
    $taskController = new TaskController();
    $tasks = $taskController->getTasks($sortDate, $filterType);
    if ($action === 'logout') {
        $authController = new AuthController();
        $authController->logout();
    }
?>
<body>

    <div class="header">
        <h1>Мой календарь (<?php echo $_SESSION['username']; ?>)</h1>
        <form method="POST" action="index.php?action=logout">
            <button class="exit" type="submit">Выход</button>
        </form>
    </div>
    
    <div class="container-create-task">
        <div class="create-task">
        <h2 class="heading-create-task">Создать задачу</h2>
            <div class=form-create-task>
                <form class="form-tasks" action="index.php?action=create" method="POST">

                    <div class="form-group">
                        <label for="theme">Тема:</label>
                        <input type="text" id="theme" name="theme" required>
                    </div>

                    <div class="form-group">
                        <label for="type">Тип:</label>
                        <select id="type" name="type" required>
                            <option value="встреча">Встреча</option>
                            <option value="звонок">Звонок</option>
                            <option value="совещание">Совещание</option>
                            <option value="дело">Дело</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="location">Место:</label>
                        <input type="text" id="location" name="location" required>
                    </div>

                    <div class="form-group">
                        <label for="datetime">Дата и время:</label>
                        <input type="datetime-local" id="datetime" name="datetime" required>
                    </div>

                    <div class="form-group">
                        <label for="duration">Длительность (в минутах):</label>
                        <input type="number" id="duration" name="duration" required>
                    </div>

                    <div class="form-group">
                        <label for="comment">Комментарий:</label>
                        <textarea id="comment" name="comment"></textarea>
                    </div>

                    <button class="save-task" type="submit">Создать задачу</button>
                </form>
            </div>
        </div>
    </div>
<div class="show-tasks">
<h2>Список задач</h2>
    <div class="sorting-tasks">
        <div class="form-sorting-tasks">
            <form method="GET" action="index.php">
                <input type="hidden" name="action" value="filter">
                <label for="filterDate"></label>
                <input type="date" id="filterDate" name="filterDate" value="<?php echo $sortDate; ?>">
                <select name="filterType">
                    <option value="all">Все задачи</option>
                    <option value="current" <?php echo $filterType === 'current' ? 'selected' : ''; ?>>Текущие задачи</option>
                    <option value="overdue" <?php echo $filterType === 'overdue' ? 'selected' : ''; ?>>Просроченные задачи</option>
                    <option value="completed" <?php echo $filterType === 'completed' ? 'selected' : ''; ?>>Выполненные задачи</option>
                </select>
                <button class="btn-sort" type="submit">Применить</button>
            </form>
        </div>
        <div class="form-get-tasks-by-days">
            <form method="GET" action="index.php">
            <button name="filterType"class="btn-filter" type="submit" value="current_day">на сегодня</button>
            <button name="filterType"class="btn-filter" type="submit" value="next_day">на завтра</button>
            <button name="filterType"class="btn-filter" type="submit" value="current_week">на эту неделю</button>
            <button name="filterType"class="btn-filter" type="submit" value="next_week">на след.неделю</button>
        </div>
    </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>Тема</th>
                <th>Тип</th>
                <th>Место</th>
                <th>Дата и время</th>
                <th>Длительность</th>
                <th>Комментарий</th>
                <th>Статус</th> 
                <th>Завершено</th> 
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr id="task_<?php echo $task->id; ?>">
                <td>
                    <a href="index.php?action=view&id=<?php echo $task->id; ?>"><?php echo $task->theme; ?></a>
                </td>
                <td><?php echo $task->type; ?></td>
                <td><?php echo $task->location; ?></td>
                <td><?php echo $task->datetime; ?></td>
                <td><?php echo $task->duration; ?></td>
                <td><?php echo $task->comment; ?></td>
                <td><?php echo $task->status; ?></td>
                <td>
                    <form action="index.php?action=complete&id=<?php echo $task->id; ?>" method="POST">
                    <input type="checkbox" id="complete_<?php echo $task->id; ?>" name="completed" onclick="this.form.submit()" <?php echo $task->status === 'завершено' ? 'checked' : ''; ?>>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
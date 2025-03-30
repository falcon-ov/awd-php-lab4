<?php
// Подключаем файл с вспомогательными функциями
require_once __DIR__ . '/../../src/helpers.php';

// Путь к файлу с задачами
$storageFile = __DIR__ . '/../../storage/tasks.txt';

// Получаем все задачи
$tasks = getAllTasks($storageFile);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все задачи</title>
    <link rel="stylesheet" href="/../../src/css/style.css">
</head>
<body>
    <h1>Все задачи</h1>
    
    <nav>
        <ul>
            <li><a href="/index.php">Главная</a></li>
            <li><a href="/task/create.php">Добавить задачу</a></li>
        </ul>
    </nav>
    
    <?php if (empty($tasks)): ?>
        <p>Пока нет ни одной задачи. <a href="/task/create.php">Добавьте первую задачу</a>!</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <h3><?php echo $task->title; ?></h3>
                    <p>Приоритет: <?php echo $task->priority; ?></p>
                    <?php if (!empty($task->description)): ?>
                        <p>Описание: <?php echo $task->description; ?></p>
                    <?php endif; ?>
                    <?php if (!empty($task->due_date)): ?>
                        <p>Срок выполнения: <?php echo $task->due_date; ?></p>
                    <?php endif; ?>
                    <?php if (!empty($task->tags)): ?>
                        <p>Теги: <?php echo implode(', ', $task->tags); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($task->steps)): ?>
                        <p>Шаги выполнения:</p>
                        <ol>
                            <?php foreach ($task->steps as $step): ?>
                                <li><?php echo $step; ?></li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                    <p>Создано: <?php echo $task->created_at; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
<?php
/**
 * Обработчик формы добавления задачи
 */

// Подключаем файл с вспомогательными функциями
require_once __DIR__ . '/../helpers.php';

// Путь к файлу для хранения задач
$storageFile = __DIR__ . '/../../storage/tasks.txt';

// Массив для хранения ошибок валидации
$errors = [];

// Обрабатываем форму только при POST-запросе
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Фильтруем входные данные
    $title = filterInput($_POST['title'] ?? '');
    $description = filterInput($_POST['description'] ?? '');
    $priority = filterInput($_POST['priority'] ?? '');
    $dueDate = filterInput($_POST['due_date'] ?? '');
    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
    $steps = filterInput($_POST['steps'] ?? '');
    
    // Валидируем данные
    [$titleValid, $titleError] = validateTitle($title);
    if (!$titleValid) {
        $errors['title'] = $titleError;
    }
    
    [$descriptionValid, $descriptionError] = validateDescription($description);
    if (!$descriptionValid) {
        $errors['description'] = $descriptionError;
    }
    
    [$priorityValid, $priorityError] = validatePriority($priority);
    if (!$priorityValid) {
        $errors['priority'] = $priorityError;
    }
    
    [$dueDateValid, $dueDateError] = validateDueDate($dueDate);
    if (!$dueDateValid) {
        $errors['due_date'] = $dueDateError;
    }
    
    // Если ошибок нет, сохраняем данные
    if (empty($errors)) {
        // Подготавливаем массив с данными задачи
        $taskData = [
            'title' => $title,
            'description' => $description,
            'priority' => $priority,
            'due_date' => $dueDate,
            'tags' => $tags,
            'steps' => $steps ? explode("\n", $steps) : []
        ];
        
        // Создаем директорию, если она не существует
        $storageDir = dirname($storageFile);
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }
        
        // Сохраняем данные в файл
        if (saveTask($storageFile, $taskData)) {
            // Перенаправляем на главную страницу
            header('Location: /index.php');
            exit;
        } else {
            $errors['general'] = "Ошибка при сохранении задачи";
        }
    }
}
?>
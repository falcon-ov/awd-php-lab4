<?php
/**
 * Файл с вспомогательными функциями для работы с данными
 */

/**
 * Фильтрует входные данные
 *
 * @param string $data Данные для фильтрации
 * @return string Отфильтрованные данные
 */
function filterInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Валидирует название задачи
 *
 * @param string $title Название задачи
 * @return array Результат валидации [isValid, message]
 */
function validateTitle($title) {
    if (empty($title)) {
        return [false, "Название задачи обязательно для заполнения"];
    }
    if (strlen($title) < 3) {
        return [false, "Название задачи должно содержать минимум 3 символа"];
    }
    if (strlen($title) > 100) {
        return [false, "Название задачи не должно превышать 100 символов"];
    }
    return [true, ""];
}

/**
 * Валидирует описание задачи
 *
 * @param string $description Описание задачи
 * @return array Результат валидации [isValid, message]
 */
function validateDescription($description) {
    if (strlen($description) > 500) {
        return [false, "Описание задачи не должно превышать 500 символов"];
    }
    return [true, ""];
}

/**
 * Валидирует приоритет задачи
 *
 * @param string $priority Приоритет задачи
 * @return array Результат валидации [isValid, message]
 */
function validatePriority($priority) {
    $validPriorities = ['low', 'medium', 'high'];
    if (!in_array($priority, $validPriorities)) {
        return [false, "Выберите корректный приоритет задачи"];
    }
    return [true, ""];
}

/**
 * Валидирует дату выполнения
 *
 * @param string $dueDate Дата выполнения
 * @return array Результат валидации [isValid, message]
 */
function validateDueDate($dueDate) {
    if (!empty($dueDate)) {
        $date = date_create($dueDate);
        if (!$date) {
            return [false, "Неверный формат даты"];
        }
        
        $today = date_create('today');
        if ($date < $today) {
            return [false, "Дата выполнения не может быть в прошлом"];
        }
    }
    return [true, ""];
}

/**
 * Получает все задачи из файла
 *
 * @param string $filename Путь к файлу с задачами
 * @return array Массив с задачами
 */
function getAllTasks($filename) {
    if (!file_exists($filename)) {
        return [];
    }
    $tasks = file($filename, FILE_IGNORE_NEW_LINES);
    return array_map('json_decode', $tasks);
}

/**
 * Получает последние N задач из файла
 *
 * @param string $filename Путь к файлу с задачами
 * @param int $count Количество задач для получения
 * @return array Массив с последними задачами
 */
function getLatestTasks($filename, $count) {
    $tasks = getAllTasks($filename);
    return array_slice($tasks, -$count);
}

/**
 * Сохраняет задачу в файл
 *
 * @param string $filename Путь к файлу с задачами
 * @param array $taskData Данные задачи для сохранения
 * @return bool Результат сохранения
 */
function saveTask($filename, $taskData) {
    $taskData['id'] = uniqid();
    $taskData['created_at'] = date('Y-m-d H:i:s');
    return file_put_contents($filename, json_encode($taskData) . PHP_EOL, FILE_APPEND);
}
?>
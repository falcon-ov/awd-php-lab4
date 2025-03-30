# ToDo List
Проект для управления задачами.

## Структура
- `public/` — публичные файлы
  - `index.php` — главная страница (2 последние задачи)
  - `task/create.php` — форма добавления задачи
  - `task/index.php` — список всех задач без пагинации
- `src/` — исходный код
  - `handlers/create-task.php` — обработчик формы
  - `helpers.php` — вспомогательные функции
- `storage/tasks.txt` — файл для хранения задач

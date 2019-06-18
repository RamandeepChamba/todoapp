<?php

class TdbRoutes
{
  public function callAction($route)
  {
    include __DIR__ . '/../config/connection.php';
    include __DIR__ . '/DatabaseTable.php';

    $todosTable = new DatabaseTable($pdo, 'todos', 'id');

    // Routing
    if ($route == 'todo/edit') {
      include __DIR__ . '/../controllers/TodoController.php';
      $todoController = new TodoController($todosTable);
      $page = $todoController->edit();

    } elseif ($route == 'todo/delete') {
      include __DIR__ . '/../controllers/TodoController.php';
      $todoController = new TodoController($todosTable);
      $page = $todoController->delete();

    } else {
      include __DIR__ . '/../controllers/TodoController.php';
      $todoController = new TodoController($todosTable);
      $page = $todoController->home();
    }

    return $page;
  }
}

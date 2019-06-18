<?php
namespace Tdb;
use \Ninja\DatabaseTable;
use \Tdb\Controllers\Todo;

class TdbRoutes
{
  public function callAction($route)
  {
    include __DIR__ . '/../../includes/connection.php';

    $todosTable = new DatabaseTable($pdo, 'todos', 'id');

    // Routing
    if ($route == 'todo/edit') {
      $todoController = new Todo($todosTable);
      $page = $todoController->edit();

    } elseif ($route == 'todo/delete') {
      $todoController = new Todo($todosTable);
      $page = $todoController->delete();

    } else {
      $todoController = new Todo($todosTable);
      $page = $todoController->home();
    }

    return $page;
  }
}

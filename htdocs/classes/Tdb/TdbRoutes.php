<?php
namespace Tdb;
use \Ninja\DatabaseTable;
use \Ninja\Routes;
use \Tdb\Controllers\Todo;

class TdbRoutes implements Routes
{
  public function getRoutes()
  {
    include __DIR__ . '/../../includes/connection.php';

    $todosTable = new DatabaseTable($pdo, 'todos', 'id');
    $todoController = new Todo($todosTable);

    // Routing
    $routes = [
      'todo/edit' => [
        'POST' => [
          'controller' => $todoController,
          'action' => 'saveEdit'
        ],
        'GET' => [
          'controller' => $todoController,
          'action' => 'edit'
        ]
      ],
      'todo/delete' => [
        'POST' => [
          'controller' => $todoController,
          'action' => 'delete'
        ]
      ],
      '' => [
        'GET' => [
          'controller' => $todoController,
          'action' => 'home'
        ]
      ]
    ];

    return $routes;
  }
}

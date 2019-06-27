<?php
namespace Tdb;
use \Ninja\DatabaseTable;
use \Ninja\Routes;
use \Tdb\Controllers\Todo;
use \Tdb\Controllers\Register;

class TdbRoutes implements Routes
{
  public function getRoutes()
  {
    include __DIR__ . '/../../includes/connection.php';

    $todosTable = new DatabaseTable($pdo, 'todos', 'id');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');
    $todoController = new Todo($todosTable);
    $authorsController = new Register($authorsTable);

    // Routing
    $routes = [
      // Author
      'author/register' => [
        'POST' => [
          'controller' => $authorsController,
          'action' => 'registerUser'
        ],
        'GET' => [
          'controller' => $authorsController,
          'action' => 'registrationForm'
        ]
      ],
      'author/success' => [
        'GET' => [
          'controller' => $authorsController,
          'action' => 'success'
        ]
      ],
      'author/failure' => [
        'GET' => [
          'controller' => $authorsController,
          'action' => 'failure'
        ]
      ],
      // Todo
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

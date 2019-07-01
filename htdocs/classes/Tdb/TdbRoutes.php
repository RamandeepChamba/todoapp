<?php
namespace Tdb;
use \Ninja\Authentication;
use \Ninja\DatabaseTable;
use \Ninja\Routes;
use \Tdb\Controllers\Login;
use \Tdb\Controllers\Register;
use \Tdb\Controllers\Todo;

class TdbRoutes implements Routes
{

  private $todosTable;
  private $authorsTable;
  private $authentication;

  public function __construct()
  {
    include __DIR__ . '/../../includes/connection.php';

    $this->todosTable = new DatabaseTable($pdo, 'todos', 'id');
    $this->authorsTable = new DatabaseTable($pdo, 'authors', 'id');
    $this->authentication = new Authentication(
      $this->authorsTable, 'email', 'password'
    );
  }

  public function getRoutes(): array
  {
    $todoController = new Todo($this->todosTable,
      $this->authorsTable, $this->authentication);
    $authorsController = new Register($this->authorsTable);
    $loginController = new Login($this->authentication);

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
      // Login
      'login' => [
        'GET' => [
          'controller' => $loginController,
          'action' => 'loginForm'
        ],
        'POST' => [
          'controller' => $loginController,
          'action' => 'login'
        ]
      ],
      'login/error' => [
        'GET' => [
          'controller' => $loginController,
          'action' => 'error'
        ]
      ],
      'logout' => [
        'GET' => [
          'controller' => $loginController,
          'action' => 'logout'
        ],
        'login' => true
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
        ],
        'login' => true
      ],
      'todo/delete' => [
        'POST' => [
          'controller' => $todoController,
          'action' => 'delete'
        ],
        'login' => true
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

  public function getAuthentication(): Authentication
  {
    return $this->authentication;
  }
}

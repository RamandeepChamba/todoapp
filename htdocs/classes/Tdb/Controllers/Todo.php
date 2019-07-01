<?php
namespace Tdb\Controllers;
use \Ninja\DatabaseTable;
use \Ninja\Authentication;

class Todo
{
  private $todosTable;
  private $authentication;

  public function __construct(DatabaseTable $todosTable,
    DatabaseTable $authorsTable,
    Authentication $authentication)
  {
    $this->todosTable = $todosTable;
    $this->authorsTable = $authorsTable;
    $this->authentication = $authentication;
  }

  // List
  private function list()
  {
    // Fetch all Todos from db
    $result = $this->todosTable->fetchAll();
    $todos = [];

    // Display view
    if (count($result)) {
      foreach ($result as $todo) {
        $author = $this->authorsTable->fetch($todo['authorId']);
        $todo['name'] = $author['name'];
        $todo['email'] = $author['email'];

        $todos[] = array_merge($todo, [
          'name' => $author['name'],
          'email' => $author['email'],
          'authorId' => $author['id'],
        ]);
      }
      // Show Todos
      $title = 'TODO APP | TODOS';

    } else {
      // No Todos
      $output = '<h1>No TODOS</h1>';
      $title = 'TODO APP | No TODOS';
      return ['title' => $title, 'output' => $output];
    }

    $author = $this->authentication->getUser();

    return ['title' => $title,
      'template' => 'showTodos.html.php',
      'variables' => [
        'todos' => $todos,
        'userId' => $author['id'] ?? null
      ]
    ];
  }

  // Home
  public function home()
  {
    $result = $this->list();
    $result['title'] = 'TODO APP | Home';
    return $result;
  }

  // Delete
  public function delete()
  {
    // Check if valid request
    if (isset($_POST['id'])) {
      // Fetch current user
      $author = $this->authentication->getUser();
      // Fetch todo
      $todo = $this->todosTable->fetch($_POST['id']);
      // If user is not the author of this todo
      if (isset($todo['authorId']) &&
        $todo['authorId'] !== $author['id']) {
        return;
      }

      if ($this->todosTable->delete($_POST['id'])) {
        $msg = 'Todo deleted!';
      } else {
        $msg = 'Unable to delete Todo!';
      }
    } else {
      $msg = 'Permission denied!';
    }
    // Return output
    return ['title' => 'Redirecting...',
      'template' => 'redirect.php',
      'variables' => [
        'msg' => $msg
      ]
    ];
  }

  // Edit
  public function edit()
  {
    // Get current user
    $author = $this->authentication->getUser();

    // GET edit form
    $id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : NULL;
    if ($id) {
      // Fetch todo for access to description
      $todo = $this->todosTable->fetch($id);
      // Check if a todo is fetched
      if (isset($todo['id'])) {
        $title = 'TODO APP | Edit Todo';
        $template = 'todoForm.html.php';
        $variables['userId'] = $author['id'];
      } else {
        $title = 'TODO APP | Error';
        $msg = 'Permission denied!';
        $template = 'redirect.php';
        $variables = ['msg' => $msg];
      }
      $variables['todo'] = $todo;

    } else {
      // Get Add form
      $title = 'TODO APP | Add Todo';
      $template = 'todoForm.html.php';
    }

    // Return output
    return ['title' => $title,
      'template' => $template,
      'variables' => $variables ?? []
    ];
  }

  // Save Edit
  public function saveEdit()
  {
    if (isset($_POST['todo']['id'])) {
      // POST todo
      $description = htmlspecialchars(trim($_POST['todo']['description']));
      if (strlen($description) > 0) {
        // Add Todo
        $todo = $_POST['todo'];
        $author = $this->authentication->getUser();

        // If we are updating, check that user has permission
        $resultTodo = $this->todosTable->fetch($todo['id']);
        // Conditions:
        // 1. If user is trying to provide custom id
        // 2. If user is not the author of this todo
        if (ctype_digit($_POST['todo']['id']) &&
          !isset($resultTodo['authorId'])
          || (isset($resultTodo['authorId']) &&
          $resultTodo['authorId'] !== $author['id'])) {
          return;
        }

        $todo['authorId'] = $author['id'];

        if ($this->todosTable->save($todo)) {
          $title = 'TODO APP | Success';
          $msg = 'Todo added!';
        } else {
          $title = 'TODO APP | Error';
          $errCode = 409;
          $msg = 'Failed to add Todo!';
        }
      }
      else {
        $title = 'TODO APP | Error';
        $errCode = 400;
        $msg = 'Invalid input!';
        // Redirect to add form
        if ($_POST['todo']['id'] == '') {
          $url = '/todoapp/todo/edit';
        }
      }
      $template = 'redirect.php';
      $variables = [
        'msg' => $msg,
        'url' => $url ?? NULL,
        'errCode'=> $errCode ?? 200
      ];
    }

    // Return output
    return ['title' => $title,
      'template' => $template,
      'variables' => $variables ?? []
    ];
  }
}

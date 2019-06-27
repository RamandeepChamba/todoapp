<?php
namespace Tdb\Controllers;
use \Ninja\DatabaseTable;

class Todo
{
  private $todosTable;

  public function __construct(DatabaseTable $todosTable)
  {
    $this->todosTable = $todosTable;
  }

  // List
  private function list()
  {
    // Fetch all Todos from db
    $todos = $this->todosTable->fetchAll();
    // Display view
    if (count($todos)) {
      // Show Todos
      $title = 'TODO APP | TODOS';
    } else {
      // No Todos
      $output = '<h1>No TODOS</h1>';
      $title = 'TODO APP | No TODOS';
      return ['title' => $title, 'output' => $output];
    }
    return ['title' => $title,
      'template' => 'showTodos.html.php',
      'variables' => [
        'todos' => $todos ?? []
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
    // GET edit form
    $id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : NULL;
    if ($id) {
      // Fetch todo for access to description
      $todo = $this->todosTable->fetch($id);
      // Check if a todo is fetched
      if (isset($todo['id'])) {
        $title = 'TODO APP | Edit Todo';
        $template = 'todoForm.html.php';
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
        if ($this->todosTable->save($_POST['todo'])) {
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

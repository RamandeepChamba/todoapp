<?php

class TodoController
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
      ob_start();
      include __DIR__ . '/../templates/showTodos.html.php';
      $output = ob_get_clean();
      $title = 'TODO APP | TODOS';
    } else {
      // No Todos
      $output = '<h1>No TODOS</h1>';
      $title = 'TODO APP | No TODOS';
    }
    return ['title' => $title, 'output' => $output];
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
    ob_start();
    include __DIR__ . '/../inc/redirect.php';
    $output = ob_get_clean();
    return ['title' => 'Redirecting...', 'output' => $output];
  }

  // Edit
  public function edit()
  {
    if (isset($_POST['todo']['id'])) {
      // GET edit form
      if (isset($_POST['edit'])) {
        // Fetch todo for access to description
        $todo = $this->todosTable->fetch($_POST['todo']['id']);
        // Check if a todo is fetched
        if (isset($todo['id'])) {
          $title = 'TODO APP | Edit Todo';
          ob_start();
          include __DIR__ . '/../templates/todoForm.html.php';
          $output = ob_get_clean();
        } else {
          $title = 'TODO APP | Error';
          $msg = 'Permission denied!';
          ob_start();
          include __DIR__ . '/../inc/redirect.php';
          $output = ob_get_clean();
        }
      }
      // POST todo
      else {
        $description = htmlspecialchars(trim($_POST['todo']['description']));
        if (strlen($description) > 0) {
          // Add Todo
          if ($this->todosTable->save($_POST['todo'])) {
            $title = 'TODO APP | Success';
            $msg = 'Todo added!';
          } else {
            $title = 'TODO APP | Error';
            $msg = 'Failed to add Todo!';
          }
        }
        else {
          $title = 'TODO APP | Error';
          $msg = 'Invalid input!';
          // Redirect to add form
          if ($_POST['todo']['id'] == '') {
            $url = '/todoapp/index.php?action=edit';
          }
        }
        ob_start();
        include __DIR__ . '/../inc/redirect.php';
        $output = ob_get_clean();
      }
    }

    // GET add form
    else {
      $title = 'TODO APP | Add Todo';
      ob_start();
      include __DIR__ . '/../templates/todoForm.html.php';
      $output = ob_get_clean();
    }

    // Return output
    return ['title' => $title, 'output' => $output];
  }
}

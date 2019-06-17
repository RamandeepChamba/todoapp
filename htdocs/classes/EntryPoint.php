<?php

class EntryPoint
{
  private $route;

  public function __construct($route)
  {
    $this->route = $route;
    $this->checkUrl();
  }

  private function checkUrl()
  {
    if ($this->route !== strtolower($this->route)) {
      http_response_code(301);
      header('location: /' . strtolower($this->route));
    }
  }

  private function loadTemplate($template, $variables)
  {
    extract($variables);
    ob_start();
    include __DIR__ . $template;
    return ob_get_clean();
  }

  private function callAction()
  {
    include __DIR__ . '/../config/connection.php';
    include __DIR__ . '/DatabaseTable.php';

    $todosTable = new DatabaseTable($pdo, 'todos', 'id');

    // Routing
    if ($this->route == 'todo/edit') {
      include __DIR__ . '/../controllers/TodoController.php';
      $todoController = new TodoController($todosTable);
      $page = $todoController->edit();

    } elseif ($this->route == 'todo/delete') {
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

  public function run()
  {
    $page = $this->callAction();
    $title = $page['title'];

    if (isset($page['template']) && isset($page['variables'])) {
      $output = $this->loadTemplate($page['template'], $page['variables']);
    } else {
      $output = $page['output'];
    }
    include __DIR__ . '/../templates/layout.html.php';
  }
}

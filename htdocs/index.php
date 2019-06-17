<?php

function loadTemplate($template, $variables)
{
  extract($variables);
  ob_start();
  include __DIR__ . $template;
  return ob_get_clean();
}

try {
  include __DIR__ . '/config/connection.php';
  include __DIR__ . '/classes/DatabaseTable.php';
  include __DIR__ . '/controllers/TodoController.php';

  $todosTable = new DatabaseTable($pdo, 'todos', 'id');
  $todoController = new TodoController($todosTable);

  $action = $_GET['action'] ?? 'home';
  $page = $todoController->$action();

  $title = $page['title'];

  if (isset($page['template']) && isset($page['variables'])) {
    $output = loadTemplate($page['template'], $page['variables']);
  } else {
    $output = $page['output'];
  }
}
catch (PDOException $e) {
  $title = 'TODO APP | Error';
  $output =
    $e->getMessage() . ' in ' .
    $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/templates/layout.html.php';

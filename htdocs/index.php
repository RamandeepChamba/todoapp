<?php

try {
  include __DIR__ . '/config/connection.php';
  include __DIR__ . '/classes/DatabaseTable.php';
  include __DIR__ . '/controllers/TodoController.php';

  $todosTable = new DatabaseTable($pdo, 'todos', 'id');
  $todoController = new TodoController($todosTable);

  if (isset($_GET['edit'])) {
    $page = $todoController->edit();
  } elseif (isset($_GET['delete'])) {
    $page = $todoController->delete();
  } else {
    $page = $todoController->home();
  }
  $title = $page['title'];
  $output = $page['output'];
}
catch (PDOException $e) {
  $title = 'TODO APP | Error';
  $output =
    $e->getMessage() . ' in ' .
    $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/templates/layout.html.php';

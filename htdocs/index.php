<?php

try {
  include __DIR__ . '/config/connection.php';
  include __DIR__ . '/classes/DatabaseTable.php';
  include __DIR__ . '/controllers/TodoController.php';

  $todosTable = new DatabaseTable($pdo, 'todos', 'id');
  $todoController = new TodoController($todosTable);

  $action = $_GET['action'] ?? 'home';
  $page = $todoController->$action();

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

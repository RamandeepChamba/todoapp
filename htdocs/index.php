<?php

try {
  include __DIR__ . '/includes/autoload.php';

  $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
  $route = str_replace('todoapp/', '', $route);
  $entryPoint = new \Ninja\EntryPoint(
    $route, 
    $_SERVER['REQUEST_METHOD'],
    new \Tdb\TdbRoutes());
  $entryPoint->run();
}
catch (\PDOException $e) {
  $title = 'TODO APP | Error';
  $output =
    $e->getMessage() . ' in ' .
    $e->getFile() . ':' . $e->getLine();

  include __DIR__ . '/templates/layout.html.php';
}

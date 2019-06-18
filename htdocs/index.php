<?php

try {
  include __DIR__ . '/classes/EntryPoint.php';
  include __DIR__ . '/classes/TdbRoutes.php';

  $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
  $route = str_replace('todoapp/', '', $route);

  $entryPoint = new EntryPoint($route, new TdbRoutes());
  $entryPoint->run();
}
catch (PDOException $e) {
  $title = 'TODO APP | Error';
  $output =
    $e->getMessage() . ' in ' .
    $e->getFile() . ':' . $e->getLine();

  include __DIR__ . '/../templates/layout.html.php';
}

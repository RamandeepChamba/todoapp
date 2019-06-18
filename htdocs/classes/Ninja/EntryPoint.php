<?php
namespace Ninja;

class EntryPoint
{
  private $route;

  public function __construct(string $route, string $method, \Tdb\TdbRoutes $routes)
  {
    $this->route = $route;
    $this->method = $method;
    $this->routes = $routes;
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

  public function run()
  {
    $routes = $this->routes->getRoutes();
    // Default to home if route not in routes
    if (!isset($routes[$this->route])) {
      $this->route = '';
      $this->method = 'GET';
    }
    $controller = $routes[$this->route][$this->method]['controller'];
    $action = $routes[$this->route][$this->method]['action'];
    $page = $controller->$action();
    $title = $page['title'];

    if (isset($page['template']) && isset($page['variables'])) {
      $output = $this->loadTemplate($page['template'], $page['variables']);
    } else {
      $output = $page['output'];
    }
    include __DIR__ . '/../../templates/layout.html.php';
  }
}
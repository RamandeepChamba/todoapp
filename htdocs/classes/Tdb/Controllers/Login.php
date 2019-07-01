<?php
namespace Tdb\Controllers;
use \Ninja\Authentication;

class Login
{

  private $authentication;

  public function __construct(Authentication $authentication)
  {
    $this->authentication = $authentication;
  }

  public function loginForm()
  {
    return [
      'title' => 'Login',
      'template' => 'login.html.php'
    ];
  }

  public function login()
  {
    $username = $_POST['author']['email'];
    $password = $_POST['author']['password'];

    if ($this->authentication->login($username, $password)) {
      // Logged in
      return [
        'title' => 'Success | Logged in',
        'template' => 'redirect.php',
        'variables' => [
          'msg' => 'Logged in successfully!'
        ]
      ];
    } else {
      // Error / Wrong credentials
      return [
        'title' => 'Failed | Logging in',
        'template' => 'login.html.php',
        'variables' => [
          'error' => 'Failed to login'
        ]
      ];
    }
  }

  public function error()
  {
    return [
      'title' => 'Error | Not logged in',
      'template' => 'loginError.html.php'
    ];
  }

  // Logout
  public function logout()
  {
    session_destroy();
    return [
      'title' => 'Success | Logged out',
      'template' => 'redirect.php',
      'variables' => [
        'msg' => 'Logged out successfully!'
      ]
    ];
  }
}

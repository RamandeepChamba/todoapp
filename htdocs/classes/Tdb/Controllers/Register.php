<?php
namespace Tdb\Controllers;
use \Ninja\DatabaseTable;

class Register
{
  private $authorsTable;

  public function __construct(DatabaseTable $authorsTable)
  {
    $this->authorsTable = $authorsTable;
  }

  public function registrationForm()
  {
    return [
      'template' => 'register.html.php',
      'title' => 'Register an account'
    ];
  }

  public function success()
  {
    return [
      'template' => 'redirect.php',
      'variables' => [
        'msg' => 'Registration Successful!'
      ],
      'title' => 'Registration Successful'
    ];
  }

  public function registerUser()
  {
    $author = $_POST['author'];
    $errors = [];
    // Form validation
    foreach ($author as $key => $value) {
      if (empty($author[$key])) {
        $errors[] = $key . ' cannot be empty';
      }
    }

    // Email validation
    if (!filter_var($author['email'], FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'email must be of the form x@x.x';
    }
    else {
      // Convert email to lowercase
      $author['email'] = strtolower($author['email']);
      // Check if email available
      // (not in db already)
      if ($this->authorsTable->fetchByCol('email', $author['email'])) {
        $errors[] = 'email already registered';
      }
    }

    // If form valid
    if (empty($errors) && $this->authorsTable->save($author)) {
      header('Location: /todoapp/author/success');
    }
    else {
      return [
        'title' => 'Registeration Failed',
        'template' => 'register.html.php',
        'variables' => [
          'errors' => $errors,
          'author' => $author
        ]
      ];
    }
  }
}

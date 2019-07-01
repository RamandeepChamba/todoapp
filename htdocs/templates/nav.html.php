<nav>
  <ul>
    <li><a href="/todoapp/">Home</a></li>
    <li><a href="/todoapp/todo/edit">Add Todo</a></li>
    <li><a href="<?=$loggedIn ? '/todoapp/logout' : '/todoapp/login'?>">
      <?=$loggedIn ? 'Log out' : 'Login'?></a>
    </li>
  </ul>
</nav>

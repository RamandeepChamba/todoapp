<?php if (isset($error)) { ?>
  <div class="error"><?=$error?></div>
  <br>
<?php }; ?>

<form action="/todoapp/login" method="post">
  <label for="email">Your email address</label>
  <input name="author[email]" id="email" type="text">

  <label for="password">Password</label>
  <input name="author[password]" id="password" type="password">

  <input type="submit" name="login" value="Login">
</form>

<p>Don't have an account?
  <a href="/todoapp/author/register">Click here to register an account</a>
</p>

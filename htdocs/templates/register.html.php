<?php if (!empty($errors)) { ?>
  <div class="errors">
    <p>Your account couldn't be created,
    please check the following:</p>
    <ul>
      <?php foreach ($errors as $error) { ?>
        <li><?=$error?></li>
      <?php }; ?>
    </ul>
  </div>

<?php }; ?>

<form action="/todoapp/author/register" method="post">
  <label for="email">Your email address</label>
  <input name="author[email]" id="email" type="text"
    value="<?=$author['email'] ?? ''?>">

  <label for="name">Your name</label>
  <input name="author[name]" id="name" type="text"
    value="<?=$author['name'] ?? ''?>">

  <label for="password">Password</label>
  <input name="author[password]" id="password"
    type="password" value="<?=$author['password'] ?? ''?>">

  <input type="submit" name="register" value="Register">
</form>

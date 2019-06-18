<section id="section-todos">
  <h1>TODOS</h1>
  <hr>
  <?php foreach ($todos as $todo) { ?>
    <blockquote class="todo" style="display: flex;
      align-items: center;
      justify-content: space-between;">
      <!-- Description -->
      <p class="todo-description" style="flex-basis: 70%;
        letter-spacing: .6px;">
        <?=$todo['description']?><br>
        <em style="font-size: 90%; color: #444;">
          <?php
            $date = new DateTime($todo['created_at']);
            echo $date->format('jS F Y');
          ?>
        </em>
      </p>
      <div class="todo-buttons" style="display: flex; flex-basis: 30%;">
        <!-- Edit -->
        <form action="/todoapp/todo/edit" method="get"
          style="margin: 0 10px;">
          <input type="hidden" name="id" value="<?=$todo['id']?>">
          <input type="submit" value="Edit" style="padding: 8px;">
        </form>
        <!-- Delete -->
        <form action="/todoapp/todo/delete" method="post">
          <input type="hidden" name="id" value="<?=$todo['id']?>">
          <input type="submit" name="delete"
            value="Delete" style="padding: 8px;">
        </form>
      </div>
    </blockquote>
    <hr style="border: 1px solid #ddd;">
  <?php }; ?>
</section>

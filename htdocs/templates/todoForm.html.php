<!-- Only show form if it's an add form or
  edit form if user have permission to edit that todo -->
<?php if (!isset($todo['id']) || (isset($todo['id']) && $userId == $todo['authorId'])) { ?>
  <form class="todoForm" action="/todoapp/todo/edit" method="post">
    <input type="hidden" name="todo[id]" value="<?=$todo['id'] ?? ''?>">
    <textarea name="todo[description]" rows="6" cols="30" maxlength="100"
      placeholder="Todo description" style="resize:none;"><?=$todo['description'] ?? ''?></textarea>
    <br>
    <input type="submit" name="submit" value="<?=isset($todo) ? 'Update' : 'Add'?>">
  </form>
<?php } else { ?>
  <p>You don't have permission to edit this todo</p>
<?php }; ?>

<script type="text/javascript">
  let textarea = document.getElementsByTagName('textarea')[0];
  textarea.focus();
  textarea.setSelectionRange(textarea.value.length,textarea.value.length);
</script>

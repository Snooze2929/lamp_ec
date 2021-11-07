<div class="message_text">
  <?php foreach(get_errors() as $error){ ?>
    <p><?php print h_special($error); ?></p>
  <?php } ?>
  <?php foreach(get_messages() as $message){ ?>
    <p><?php print h_special($message); ?></p>
  <?php } ?>
</div>
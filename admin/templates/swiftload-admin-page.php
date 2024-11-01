<div class="wrap">
  <form method="post" action="options.php">
    <?php
    settings_fields('swiftload-settings');
    do_settings_sections('swiftload-settings');
    submit_button();
    ?>
  </form>
</div>
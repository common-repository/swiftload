<?php
function switfload_preloader() {
  if (!has_action('wp_footer', 'switfload_preloader')) {
    return;
  }

  $options = get_option('swiftload_wp_settings');
  $enabled = isset($options['enabled']) ? $options['enabled'] : false;

  if (!$enabled) {
    return;
  }

  $background = isset($options['background']) ? esc_attr($options['background']) : '#f7f7f7';
  $primary_color = isset($options['primary_color']) ? esc_attr($options['primary_color']) : '#00000';
  $bar_color = isset($options['bar_color']) ? esc_attr($options['bar_color']) : '#4169e1';
  $enabled_bar = isset($options['enabled_bar']) ? $options['enabled_bar'] : false;
  $enabled_icon = isset($options['enabled_icon']) ? $options['enabled_icon'] : false;
  $icon = isset($options['icon']) ? esc_attr($options['icon']) : '';

  $activateProgressBar = isset($options['enabled_bar']) ? $options['enabled_bar'] : false;
  $activateCounter = isset($options['enabled_icon']) ? $options['enabled_icon'] : false;

  // Adicionando classes com base nas opções
  $preloaderClasses = 'swiftload-preloader';
  if ($activateProgressBar) {
    $preloaderClasses .= ' activate-progress-bar';
  }
  if ($activateCounter) {
    $preloaderClasses .= ' activate-counter';
  }

  ?>
  <style>
    #swiftload-preloader {
      background-color: <?php echo $background; ?>;
    }

    #swiftload-counter {
      color: <?php echo $primary_color; ?>;
    }

    #swiftload-bar {
      background-color: <?php echo $bar_color; ?>;
    }

    <?php if ($icon != "loader-escale") : ?>
      .<?php echo $icon; ?> {
        color: <?php echo $primary_color; ?>;
      }
    <?php else : ?>
      .loader-escale {
        color: <?php echo $primary_color; ?>;
        background: <?php echo $primary_color; ?>;
      }
      .loader-escale:before,
      .loader-escale:after {
        background: <?php echo $primary_color; ?>;
      }
    <?php endif; ?>
  </style>

  <div id="swiftload-preloader" class="<?php echo esc_attr($preloaderClasses); ?>">
    <div class="swiftload-content">
      <?php if ($activateCounter) : ?>
        <div id="swiftload-counter-box" class="swiftload-box">
          <span class="<?php echo $icon; ?>"></span>
        </div>
      <?php else : ?>
        <div id="swiftload-counter">0</div>
      <?php endif; ?>
    </div>
    <?php if ($enabled_bar) : ?>
      <div id="swiftload-bar-container">
        <div id="swiftload-bar"></div>
      </div>
    <?php endif; ?>
  </div>
  <?php
}
?>

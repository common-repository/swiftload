<?php
if (!defined('WPINC')) {
  wp_die();
}

function swiftload_wp_admin_init()
{
  register_setting('swiftload-settings', 'swiftload_wp_settings', 'swiftload_wp_settings_validate');

  add_settings_section('swiftload-section', __('Swiftload Settings', 'swiftload-wp'), 'swiftload_wp_section_callback', 'swiftload-settings');

  add_settings_field('swiftload-background', __('Background Color', 'swiftload-wp'), 'swiftload_wp_background_callback', 'swiftload-settings', 'swiftload-section');
  add_settings_field('swiftload-primary-color', __('Primary Color', 'swiftload-wp'),  'swiftload_wp_primary_color_callback', 'swiftload-settings', 'swiftload-section');
  add_settings_field('swiftload-bar-color', __('Bar Color', 'swiftload-wp'),  'swiftload_wp_bar_color_callback', 'swiftload-settings', 'swiftload-section');
  add_settings_field('swiftload-icon', __('Icon', 'swiftload-wp'),  'swiftload_wp_icon_callback', 'swiftload-settings', 'swiftload-section');
  add_settings_field('swiftload-enable', __('Enable Preloader', 'swiftload-wp'),  'swiftload_wp_enable_callback', 'swiftload-settings', 'swiftload-section');
}

function swiftload_wp_section_callback()
{
  echo __('Configure the your preloader options:', 'swiftload-wp');
}

function swiftload_wp_background_callback()
{
  $options = get_option('swiftload_wp_settings');
  $color = isset($options['background']) ? $options['background'] : '#f7f7f7';
?>
  <input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="#ffffff" name="swiftload_wp_settings[background]" value="<?php echo esc_attr($color); ?>" />
  <p class="description" id="tagline-description"><?php _e('Choose the background color', 'swiftload-wp'); ?></p>
<?php
}

function swiftload_wp_primary_color_callback()
{
  $options = get_option('swiftload_wp_settings');
  $primary_color = isset($options['primary_color']) ? $options['primary_color'] : '#000000';
?>
  <input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="#000000" name="swiftload_wp_settings[primary_color]" value="<?php echo esc_attr($primary_color); ?>" />
  <p class="description" id="tagline-description"><?php _e('Choose the primary color.', 'swiftload-wp'); ?></p>
<?php
}

function swiftload_wp_bar_color_callback()
{
  $options = get_option('swiftload_wp_settings');
  $bar_color = isset($options['bar_color']) ? $options['bar_color'] : '#4169e1';
  $options = get_option('swiftload_wp_settings');
  $enabled = isset($options['enabled_bar']) ? $options['enabled_bar'] : false;
?>
  <label><input type="checkbox" name="swiftload_wp_settings[enabled_bar]" value="1" <?php checked($enabled, true); ?>><?php _e('Active', 'swiftload-wp'); ?></label><br><br>
  <input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="#ffaa00" name="swiftload_wp_settings[bar_color]" value="<?php echo esc_attr($bar_color); ?>" />
  <p class="description" id="tagline-description"><?php _e('Choose the color of the bar.', 'swiftload-wp'); ?></p>
<?php
}
function swiftload_wp_icon_callback() {
  $options = get_option('swiftload_wp_settings');
  $enabled_icon = isset($options['enabled_icon']) ? $options['enabled_icon'] : false;
  $selected_option = isset($options['icon']) ? $options['icon'] : '';

  $options_array = array(
      'loader-pointer' => __('loader-pointer', 'swiftload-wp'),
      'loader-line'    => __('loader-line', 'swiftload-wp'),
      'loader-escale'  => __('loader-escale', 'swiftload-wp'),
      'loader-square'  => __('loader-square', 'swiftload-wp')
  );
?>
  <label><input type="checkbox" name="swiftload_wp_settings[enabled_icon]" value="1" <?php checked($enabled_icon, true); ?>><?php _e('Active', 'swiftload-wp'); ?></label><br><br>

  <fieldset class="swiftload-fieldset">
      <?php foreach ($options_array as $key => $label) : ?>
        <div class="icon-admin">  
        <label>
              <input type="radio" name="swiftload_wp_settings[icon]" value="<?php echo $key; ?>" <?php checked($selected_option, $key); ?>>
              <span class="<?php echo $key; ?>" data-option="<?php echo $key; ?>"></span>
          </label>
      </div>
      <?php endforeach; ?>
  </fieldset>
<?php
}

function swiftload_wp_enable_callback()
{
  $options = get_option('swiftload_wp_settings');
  $enabled = isset($options['enabled']) ? $options['enabled'] : false;
?>
  <label><input type="checkbox" name="swiftload_wp_settings[enabled]" value="1" <?php checked($enabled, true); ?>><?php _e('Enabled', 'swiftload-wp'); ?></label>
<?php
}

function swiftload_wp_settings_validate($input)
{
  $output = array();
  if (isset($input['background'])) {
    $output['background'] = sanitize_hex_color($input['background']);
  }
  if (isset($input['primary_color'])) {
    $output['primary_color'] = sanitize_hex_color($input['primary_color']);
  }

  if (isset($input['enabled_bar'])) {
    $output['enabled_bar'] = (bool) $input['enabled_bar'];
  }
  if (isset($input['bar_color'])) {
    $output['bar_color'] = sanitize_hex_color($input['bar_color']);
  }

  if (isset($input['enabled_icon'])) {
    $output['enabled_icon'] = (bool) $input['enabled_icon'];
  }

  if (isset($input['icon'])) {
    $output['icon'] = sanitize_text_field($input['icon']);
  }

  if (isset($input['enabled'])) {
    $output['enabled'] = (bool) $input['enabled'];
  }
  return $output;
}

<?php
/*
Plugin Name: SwiftLoad
Plugin URI: https://www.tadeubrasil.com.br/plugins/swiftload-wp
Description:Introduce a preloader while your website page loads all components, providing a smoother experience for your visitors.
Version: 1.5.0
Author: Tadeu
Author URI: https://www.tadeubrasil.com.br
License: GPL2
Text Domain: swiftload-wp
Domain Path: /languages
*/

if (!defined('WPINC')) {
  wp_die();
}

class SwiftLoad
{

  public function __construct()
  {
    $this->load_dependencies();
    $this->init();

    register_deactivation_hook(plugin_dir_path(__FILE__) . 'swiftload.php', array($this, 'swiftload_cleanup_on_deactivation'));
  }

  private function load_dependencies()
  {
    add_action('wp_enqueue_scripts', array($this, 'swiftloadwp_enqueue_assets'));
    add_action('admin_enqueue_scripts',  array($this, 'swiftloadwp_admin_scripts'));
    add_action('admin_enqueue_scripts', array($this, 'swiftloadwp_admin_css'));
    add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'swifloadwp_settings_link'));
    add_action('admin_menu', array($this, 'swiftloadwp_add_plugin_page'));
    add_action('admin_init', array($this, 'swiftloadwp_admin_page'));
    add_action('admin_init', 'swiftload_wp_admin_init');
    add_action('wp_footer', 'switfload_preloader');
  }

  private function init()
  {
    include_once(plugin_dir_path(__FILE__) . 'inc/swiftload-preloader.php');
  }

  public function swiftloadwp_enqueue_assets()
  {
    wp_enqueue_style('swiftload-style', plugins_url('assets/css/swiftload.css', __FILE__), '', '1.0.1');
    wp_enqueue_script('swiftload-script', plugins_url('assets/js/swiftload.js', __FILE__), array('jquery'), '1.0.2', true);
  }

  public function swiftloadwp_admin_css() {
    wp_enqueue_style('swiftload-admin-styles', plugin_dir_url(__FILE__) . 'admin/assets/css/admin-styles.css', array(), '1.0.3');
  }

  public function swiftloadwp_admin_scripts()
  {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('wp-color-picker-init',  plugins_url('admin/assets/js/wp-color-picker-init.js',  __FILE__), array('wp-color-picker'), true);
  }

  public function swiftloadwp_add_plugin_page()
  {
    add_options_page(
      'Swiftload settings',
      'SwiftLoad',
      'manage_options',
      'swiftload',
      array($this, 'swiftloadwp_render_admin_page')
    );
  }

  public function swifloadwp_settings_link($links) {
    $settings_link = '<a href="' . admin_url('admin.php?page=swiftload') . '">' . __('Settings', 'swiftload-wp') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

  public function swiftloadwp_render_admin_page()
  {
    include_once(plugin_dir_path(__FILE__) . 'admin/templates/swiftload-admin-page.php');
  }

  public function swiftloadwp_admin_page()
  {
    include_once(plugin_dir_path(__FILE__) . 'admin/swiftload-admin.php');
  }

  public function swiftload_cleanup_on_deactivation()
  {
    delete_option('swiftload_wp_settings');
  }
}

$meu_plugin = new SwiftLoad();
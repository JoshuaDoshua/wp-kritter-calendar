<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Plugin Name: Kritter Calendar (ACF)
 * Plugin URI: https://github.com/joshuadoshua/kritter-calendar-acf
 * Description: Custom events handing with ACF
 * Version: 0.0.1
 * Author: JoshuaDoshua
 * Author URI: https://github.com/joshuadoshua
 */

// plugin init
// require ACF w/ notices
// register post_type & tax
// register options page and acf fields
// register templates

if (!defined('ABSPATH')) exit;

define('KRITTERCAL_VERSION', '0.0.1');
define('KRITTERCAL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('KRITTERCAL_PLUGIN_URL', plugin_dir_url(__FILE__));

add_action('admin_init', function() {
	if (is_admin() && current_user_can('activate_plugins') && 
	(!is_plugin_active('advanced-custom-fields-pro/acf.php')
		|| !is_plugin_active('acf-openstreetmap-field/index.php')
	)):
		add_action('admin_notices', function() {
			echo '<div class="error"><p>Kritter Calendar ACF requires <a href="https://www.advancedcustomfields.com/pro/" target="_blank">ACF Pro</a> and <a href="https://wordpress.org/plugins/acf-openstreetmap-field/">ACF OpenStreetMap Field</a>.</p></div>';
		});
        deactivate_plugins(plugin_basename(__FILE__));

        if (isset($_GET['activate'])) unset($_GET['activate']);

    endif;
});

function child_plugin_notice(){
    ?><div class="error"><p>Sorry, but Child Plugin requires the Parent plugin to be installed and active.</p></div><?php
}

require(__DIR__."/vendor/autoload.php");

global $kritter_calendar;

function kritterCalendar() {
	global $kritter_calendar;

	if (!isset($kritter_calendar)) {
		$kritter_calendar = new Kritter\Calendar;
		// $kritter_calendar->init();
	}

	return $kritter_calendar;
}

kritterCalendar();

// what can we remoeve from here and put in plugin class
require(__DIR__.'/includes/post_types.php');
require(__DIR__.'/includes/default_filters.php');
// require(__DIR__.'/includes/acf.php');
require(__DIR__.'/includes/functions.php');
require(__DIR__.'/includes/yoast.php');
// require(__DIR__.'/includes/cli.php');

// make plugin class
// do al things w/ that

// register_activation_hook(__FILE__, ['Kritter\\Calendar', '_activation']);
// register_deactivation_hook(__FILE__, ['Kriter\\Calendar', '_deactivation']);
// register_install_hook(__FILE__, ['Kriter\\Calendar', '_install']);
// register_uninstall_hook(__FILE__, ['Kriter\\Calendar', '_uninstall']);


// require(__DIR__."/acf-field-date-range/acf-field-date-range.php");

add_action('acf/input/admin_enqueue_scripts', function() {
	wp_enqueue_script('kritter-acf-events', KRITTERCAL_PLUGIN_URL . "/acf_kritter_calendar.js", [], true);
});


// TODO not working for schedule?

// if (!function_exists('kcal_get_template_part'))
// function kcal_get_template_part($slug, $args = []) {
// }
// endif; // !!kcal_get_template_part

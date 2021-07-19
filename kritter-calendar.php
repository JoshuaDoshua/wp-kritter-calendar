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
define('KRITTERCAL_DIR', plugin_dir_path(__FILE__));

require(__DIR__."/vendor/autoload.php");

global $kritter_calendar;

function kritterCalendar() {
	global $kritter_calendar;

	if (!isset($kritter_calendar)) {
		$kritter_calendar = new Kritter\Calendar\Calendar;
		// $kritter_calendar->init();
	}

	return $kritter_calendar;
}

kritterCalendar();

new Kritter\Calendar\Calendar;

// what can we remoeve from here and put in plugin class
require(__DIR__.'/includes/post_types.php');
// require(__DIR__.'/includes/acf.php');
require(__DIR__.'/includes/functions.php');
// require(__DIR__.'/includes/cli.php');

// make plugin class
// do al things w/ that

// register_activation_hook(__FILE__, ['Kritter\\Calendar', '_activation']);
// register_deactivation_hook(__FILE__, ['Kriter\\Calendar', '_deactivation']);
// register_install_hook(__FILE__, ['Kriter\\Calendar', '_install']);
// register_uninstall_hook(__FILE__, ['Kriter\\Calendar', '_uninstall']);


require(__DIR__."/acf-field-date-range/acf-field-date-range.php");

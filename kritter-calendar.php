<?php
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

\Carbon\Carbon::setWeekStartsAt(get_option('start_of_week'));

// what can we remoeve from here and put in plugin class
require(__DIR__.'/includes/post_types.php');
require(__DIR__.'/includes/acf.php');
require(__DIR__.'/includes/functions.php');
// require(__DIR__.'/includes/cli.php');

// make plugin class
// do al things w/ that

// register_activation_hook(__FILE__, ['Kritter\\Calendar', '_activation']);
// register_deactivation_hook(__FILE__, ['Kriter\\Calendar', '_deactivation']);
// register_install_hook(__FILE__, ['Kriter\\Calendar', '_install']);
// register_uninstall_hook(__FILE__, ['Kriter\\Calendar', '_uninstall']);


require(__DIR__."/acf-field-date-range/acf-field-date-range.php");

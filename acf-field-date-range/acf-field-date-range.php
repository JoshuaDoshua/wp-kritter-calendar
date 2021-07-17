<?php

// TODO
// ignore v4
// show warning

if (!defined('ABSPATH')) exit;

if (!class_exists('kritter_acf_plugin_date_range')) return;

class kritter_acf_plugin_date_range
{
	// @var array
	var $settings;
	
	function __construct() {
		
		$this->settings = [
			'version'	=> '1.0.0',
			'url'		=> plugin_dir_url(__FILE__),
			'path'		=> plugin_dir_path(__FILE__)
		];
		
		// include field
		add_action('acf/include_field_types', [$this, 'include_field']); // v5
		// add_action('acf/register_fields', [$this, 'include_field']); // v4
	}
	
	function include_field($version = false)
	{
		// support empty $version
		if(!$version) $version = 4;
		
		// include
		include_once("fields/class-kritter-acf-field-date_range-v{$version}.php");
	}
	
}

// initialize
new kritter_acf_plugin_date_range();

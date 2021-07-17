<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('kritter_acf_field_date_range')) return;

/**
 * potential js
 *
 * https://wakirin.github.io/Lightpick/
 * https://www.daterangepicker.com/
 */

class kritter_acf_field_date_range extends acf_field
{
	function __construct($settings)
	{
		$this->name = 'date_range';
		$this->label = 'Date Range';
		$this->category = 'jquery';
		$this->defaults = [
			'display_format' => 'd/m/Y',
			'return_format' => 'd/m/Y',
			'first_day' => 1,
		];

		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('FIELD_NAME', 'error');
		*/
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'TEXTDOMAIN'),
		);


		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/
		$this->settings = $settings;

		// do not delete!
    	parent::__construct();
	}


	// edit
	function render_field_settings($field)
	{
		global $wp_locale;

		$d_m_Y = date_i18n('d/m/Y');
		$m_d_Y = date_i18n('m/d/Y');
		$F_j_Y = date_i18n('F j, Y');
		$Ymd = date_i18n('Ymd');

		acf_render_field_setting($field,[
			'label' => "Display Format",
			'instructions' => "The format displayed when editing a post",
			'type' => 'radio',
			'name' => 'display_format',
			'other_choice' => 1,
			'choices' => [
				'd/m/Y' => "<span>{$d_m_Y}</span><code>d/m/Y</code>",
				'm/d/Y' => "<span>{$m_d_Y}</span><code>m/d/Y</code>",
				'F j, Y' => "<span>{$F_j_Y}</span><code>F j, Y</code>",
				'other' => "<span>Custom</span>",
			]
		]);

		acf_render_field_setting($field, [
			'label'			=> "Return Format",
			'instructions'	=> "The format returned via template functions",
			'type'			=> 'radio',
			'name'			=> 'return_format',
			'other_choice'	=> 1,
			'choices'		=> [
				'd/m/Y' => "<span>{$d_m_Y}</span><code>d/m/Y</code>",
				'm/d/Y' => "<span>{$m_d_Y}</span><code>m/d/Y</code>",
				'F j, Y' => "<span>{$F_j_Y}</span><code>F j, Y</code>",
				'Ymd' => "<span>{$Ymd}</span><code>Ymd</code>",
				'other' => "<span>Custom:</span>"
			]
		]);

		acf_render_field_setting($field, [
			'label'	=> "Week Starts On",
			'instructions' => '',
			'type' => 'select',
			'name' => 'first_day',
			'choices' => array_values($wp_locale->weekday)
		]);
	}

	// html interface
	function render_field($field)
	{
		$hidden_value = '';
		$display_value = '';

		if ($field['value']):
			$hidden_value = acf_format_date($field['value'], 'Ymd');
			$display_value = acf_format_date($field['value'], $field['display_format']);
		endif; // value

		$div = [
			'class' => "acf-date-picker acf-input-wrap",
			'data-date_format' => acf_convert_date_to_js($field['display_format']),
			'data-first_day' => $field['first_day'],
		];
		$hidden_input = [
			'id' => $field['id'],
			'name' => $field['name'],
			'value' => $hidden_value,
		];
		$text_input = [
			'class' => 'input',
			'value' => $display_value,
		];

		foreach(['readonly', 'disabled'] as $k):
			if (!empty($field[$k])) {
				$text_input[$k] = $k;
			}
		endforeach; // special attributes
		?>
		<div <?php acf_esc_attr_e( $div ); ?>>
			<?php acf_hidden_input( $hidden_input ); ?>
			<?php acf_text_input( $text_input ); ?>
		</div>
		<?php
	}

	// admin_enqueue_scripts
	function input_admin_enqueue_scripts()
	{
		// vars
		$url = $this->settings['url'];
		$version = $this->settings['version'];


		// register & include JS
		wp_register_script('TEXTDOMAIN', "{$url}assets/js/input.js", array('acf-input'), $version);
		wp_enqueue_script('TEXTDOMAIN');


		// register & include CSS
		wp_register_style('TEXTDOMAIN', "{$url}assets/css/input.css", array('acf-input'), $version);
		wp_enqueue_style('TEXTDOMAIN');
	}


	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function input_admin_head() {



	}

	*/


	/*
   	*  input_form_data()
   	*
   	*  This function is called once on the 'input' page between the head and footer
   	*  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and
   	*  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   	*  seen on comments / user edit forms on the front end. This function will always be called, and includes
   	*  $args that related to the current screen such as $args['post_id']
   	*
   	*  @type	function
   	*  @date	6/03/2014
   	*  @since	5.0.0
   	*
   	*  @param	$args (array)
   	*  @return	n/a
   	*/

   	/*

   	function input_form_data( $args ) {



   	}

   	*/


	/*
	*  input_admin_footer()
	*
	*  This action is called in the admin_footer action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_footer)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function input_admin_footer() {



	}

	*/


	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function field_group_admin_enqueue_scripts() {

	}

	*/


	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add CSS and JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function field_group_admin_head() {

	}

	*/


	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/

	/*

	function load_value( $value, $post_id, $field ) {

		return $value;

	}

	*/


	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/

	/*

	function update_value( $value, $post_id, $field ) {

		return $value;

	}

	*/

	// after loaded from db, before returned to template
	function format_value($value, $post_id, $field)
	{
		return acf_format_date($value, $field['return_format']);
	}

	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/

	/*

	function validate_value( $valid, $value, $field, $input ){

		// Basic usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = false;
		}


		// Advanced usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = __('The value is too little!','TEXTDOMAIN'),
		}


		// return
		return $valid;

	}

	*/


	/*
	*  delete_value()
	*
	*  This action is fired after a value has been deleted from the db.
	*  Please note that saving a blank value is treated as an update, not a delete
	*
	*  @type	action
	*  @date	6/03/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (mixed) the $post_id from which the value was deleted
	*  @param	$key (string) the $meta_key which the value was deleted
	*  @return	n/a
	*/

	/*

	function delete_value( $post_id, $key ) {



	}

	*/


	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	/*

	function load_field( $field ) {

		return $field;

	}

	*/


	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	/*

	function update_field( $field ) {

		return $field;

	}

	*/


	/*
	*  delete_field()
	*
	*  This action is fired after a field is deleted from the database
	*
	*  @type	action
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	n/a
	*/

	/*

	function delete_field( $field ) {



	}

	*/


}

// initialize
new kritter_acf_field_date_range($this->settings);

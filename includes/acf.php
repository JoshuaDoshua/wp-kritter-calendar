<?php

add_action('acf/init', function() {
	acf_add_options_sub_page([
		'parent_slug' => "edit.php?post_type=kritter_event",
		'page_title' => "Calendar Settings",
		'menu_title' => "Settings",
		'post_id' => "calendar_settings"
	]);
});


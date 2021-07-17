<?php

add_action('init', function() {
	register_post_type('kritter_event', [
		'label'                 => 'Event',
		'description'           => 'Kritter Calendar Event',
		'labels'                => [
			'name'                  => 'Events',
			'singular_name'         => 'Event',
			'menu_name'             => 'Calendar',
			'name_admin_bar'        => 'Events',
			'archives'              => 'Event Archives',
			'attributes'            => 'Event Attributes',
			'parent_item_colon'     => 'Parent Item:',
			'all_items'             => 'All Events',
			'add_new_item'          => 'Add New Event',
			'add_new'               => 'Add New',
			'new_item'              => 'New Event',
			'edit_item'             => 'Edit Event',
			'update_item'           => 'Update Event',
			'view_item'             => 'View Events',
			'view_items'            => 'View Events',
			'search_items'          => 'Search Events',
			'not_found'             => 'Not found',
			'not_found_in_trash'    => 'Not found in Trash',
			'featured_image'        => 'Featured Image',
			'set_featured_image'    => 'Set featured image',
			'remove_featured_image' => 'Remove featured image',
			'use_featured_image'    => 'Use as featured image',
			'insert_into_item'      => 'Insert into event',
			'uploaded_to_this_item' => 'Uploaded to this event',
			'items_list'            => 'Events list',
			'items_list_navigation' => 'Events list navigation',
			'filter_items_list'     => 'Filter events list',
		],
		'supports'              => ['title', 'editor', 'thumbnail'],
		'taxonomies'            => ['kritter_event_category', 'kritter_event_tag'],
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 10,
		'menu_icon'             => 'dashicons-calendar-alt',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'calendar',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => [
			'slug'                  => 'calendar/events',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		],
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		'rest_base'             => 'events',
	]);

	register_post_type('kritter_venue', [
		'label'                 => 'Venue',
		'description'           => 'Kritter Calendar Venue',
		'labels'                => [
			'name'                  => 'Venues',
			'singular_name'         => 'Venue',
			'menu_name'             => 'Calendar',
			'name_admin_bar'        => 'Venues',
			'archives'              => 'Venue Archives',
			'attributes'            => 'Venue Attributes',
			'parent_item_colon'     => 'Parent Item:',
			'all_items'             => 'Venues',
			'add_new_item'          => 'Add New Venue',
			'add_new'               => 'Add New',
			'new_item'              => 'New Venue',
			'edit_item'             => 'Edit Venue',
			'update_item'           => 'Update Venue',
			'view_item'             => 'View Venues',
			'view_items'            => 'View Venues',
			'search_items'          => 'Search Venues',
			'not_found'             => 'Not found',
			'not_found_in_trash'    => 'Not found in Trash',
			'featured_image'        => 'Featured Image',
			'set_featured_image'    => 'Set featured image',
			'remove_featured_image' => 'Remove featured image',
			'use_featured_image'    => 'Use as featured image',
			'insert_into_item'      => 'Insert into venue',
			'uploaded_to_this_item' => 'Uploaded to this venue',
			'items_list'            => 'Venues list',
			'items_list_navigation' => 'Venues list navigation',
			'filter_items_list'     => 'Filter venues list',
		],
		'supports'              => ['title', 'editor', 'thumbnail'],
		'taxonomies'            => [],
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => "edit.php?post_type=kritter_event",
		'menu_position'         => 10,
		'menu_icon'             => null,
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'calendar',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => [
			'slug'                  => 'calendar/venues',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		],
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		'rest_base'             => 'venues',
	]);

	register_taxonomy('kritter_event_category', ['kritter_event'], [
		'labels'                     => [
			'name'                       => 'Event Categories',
			'singular_name'              => 'Event Category',
			'menu_name'                  => 'Categories',
			'all_items'                  => 'All Event Categories',
			'parent_item'                => 'Parent Category',
			'parent_item_colon'          => 'Parent Category:',
			'new_item_name'              => 'New Event Category',
			'add_new_item'               => 'Add New Category',
			'edit_item'                  => 'Edit Category',
			'update_item'                => 'Update Category',
			'view_item'                  => 'View Category',
			'separate_items_with_commas' => 'Separate categories with commas',
			'add_or_remove_items'        => 'Add or remove categories',
			'choose_from_most_used'      => 'Choose from the most used',
			'popular_items'              => 'Popular Event Categories',
			'search_items'               => 'Search Categories',
			'not_found'                  => 'Not Found',
			'no_terms'                   => 'No Categories',
			'items_list'                 => 'Items list',
			'items_list_navigation'      => 'Categories list navigation',
		],
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => [
			'slug'                       => 'calendar/categories',
			'with_front'                 => true,
			'hierarchical'               => true,
		],
		'show_in_rest'               => true,
		'rest_base'                  => 'events/categories',
	]);
});

add_filter('the_post', function($post) {
	if ($post->post_type !== "kritter_event") return;

	$post->event = new \Kritter\Calendar\Event($post->ID);
});

return;

// VENUE ADMIN
// TODO move to class
add_filter('manage_kritter_venue_posts_columns', function($cols) {
	$date_col = $cols['date'];
	unset($cols['date']);

	$cols = array_merge($cols, [
		'street' => "Street",
		'city' => "City",
		'state' => "State",
		'postal' => "Postal",
		'events_count' => "Events Count",
	]);
	// $cols['date'] = $date_col;

	return $cols;
});

// TODO: bidirection event/venue
// https://www.advancedcustomfields.com/resources/bidirectional-relationships/
add_action('manage_kritter_venue_posts_custom_column', function($col, $pid) {
	$address_cols = ['street', 'city', 'state', 'postal'];
	if (!in_array($col, $address_cols) && $col !== "events_count") return;

	if ($col == "events_count"):
		// $q = new WP_Query(['post_type' => 'kritter_event', 'meta_query' => [['venue' => $pid]]]);
		echo "TODO";
	else:
		$address = get_field('address', $pid);
		echo $address[$col];
	endif;
}, 10, 2);

add_filter('manage_edit-kritter_venue_sortable_columns', function($cols) {
	$columns['street'] = 'street';
	$columns['city'] = 'city';
	$columns['state'] = 'state';
	$columns['postal'] = 'postal';
	return $columns;
});

add_action('pre_get_posts', function($query) {
	if (!is_admin()) return;
	$scr = get_current_screen();
	if ($scr->id !== "edit-kritter_venue") return;

	$orderby = $query->get('orderby');

	if ($orderby == 'state'):
		$query->set('meta_key', 'address_state');
		$query->set('orderby', 'meta_value');

	elseif ($orderby == 'city'):
		$query->set('meta_key', 'address_city');
		$query->set('orderby', 'meta_value');

	elseif ($orderby == 'street'):
		$query->set('meta_key', 'address_street');
		$query->set('orderby', 'meta_value');

	elseif ($orderby == 'postal'):
		$query->set('meta_key', 'address_postal');
		$query->set('orderby', 'meta_value');
	endif; // orderby
});

function add_course_section_filter() {
    $section = $_GET[ 'course_section' ][ 0 ] ?? $_GET[ 'course_section' ][ 1 ] ?? -1;
    echo ' <select name="course_section[]" style="float:none;"><option value="">Course Section...</option>';
    for ( $i = 1; $i <= 3; ++$i ) {
        $selected = $i == $section ? ' selected="selected"' : '';
        echo '<option value="' . $i . '"' . $selected . '>Section ' . $i . '</option>';
    }
    echo '</select>';
    echo '<input type="submit" class="button" value="Filter">';
}
add_action( 'restrict_manage_users', 'add_course_section_filter' );

function filter_users_by_course_section( $query ) {
    global $pagenow;

    if ( is_admin() && 'users.php' == $pagenow) {
        $section = $_GET[ 'course_section' ][ 0 ] ?? $_GET[ 'course_section' ][ 1 ] ?? null;
        if ( null !== $section ) {
            $meta_query = array(
                array(
                    'key' => 'course_section',
                    'value' => $section
                )
            );
            $query->set( 'meta_key', 'course_section' );
            $query->set( 'meta_query', $meta_query );
        }
    }
}
add_filter( 'pre_get_users', 'filter_users_by_course_section' );

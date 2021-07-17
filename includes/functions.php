<?php

// add our classes to the \WP_Post object
add_action('the_post', function($post) {

	if ($post->post_type === "kritter_event")
		kritter_set_post_event($post);

	// if ($post->post_type === "kritter_venue")
	// 	$kritter->event = new \Kritter\Calendar\Venue($post->ID);
});


function kritter_set_post_event($p = null) {
	global $post;
	$p = $p ?: $post;

	if (!$p->event)
		$p->event = new \Kritter\Calendar\Event($p->ID);
}


function get_the_event_date($p = null) {
	global $post;
	$p = $p ?: $post;
	kritter_set_post_event($p);

	return $p->event->date;
}
function the_event_date($p = null) {
	echo get_the_event_date($p);
}

function get_the_event_time($p = null) {
	global $post;
	$p = $p ?: $post;
	kritter_set_post_event($p);

	return $p->event->time;
}
function the_event_time($p = null) {
	echo get_the_event_time($p);
}

function is_event_all_day($p = null) {
	global $post;
	$p = $p ?: $post;
	kritter_set_post_event($p);

	return $p->event->meta['is_all_day'];
}

function is_event_multi_days($p = null) {
	global $post;
	$p = $p ?: $post;
	kritter_set_post_event($p);

	return $p->event->isMultiDay();
}

// TODO
function get_venue_events() {}
// TODO
function get_venue_events_query() {}

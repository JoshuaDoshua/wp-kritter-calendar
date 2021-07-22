<?php

// ensure a kritter event is setup
function kritter_set_post_event($p = null) {
	global $post;
	$p = $p ?: $post;

	if (!$p->event)
		$p->event = new \Kritter\Calendar\Event($p->ID);
}

// add our classes to the \WP_Post object
add_action('the_post', function($post) {

	if ($post->post_type === "kritter_event")
		kritter_set_post_event($post);

	// if ($post->post_type === "kritter_venue")
	// 	$kritter->event = new \Kritter\Calendar\Venue($post->ID);
});



return;





/* ===============
 *  TEMPLATE TAGS
 * ================ */


function get_the_event_date($p = null, $format = null) {
	global $post;
	$p = $p ?: $post;
	kritter_set_post_event($p);

	return (string) $p->event->date;

	// TODO find a way override the format here
	return $format
		? $p->event->date()->format($format)
		: (string) $p->event->date;
}
function the_event_date($p = null, $format = false) {
	echo get_the_event_date($p, $format);
}

function get_the_event_time($p = null, $format = null) {
	global $post;
	$p = $p ?: $post;
	kritter_set_post_event($p);

	return (string) $p->event->time;

	// TODO find way to override time
	return $format
		? $p->event->time()->format($format)
		: (string) $p->event->time;
}
function the_event_time($p = null, $format = false) {
	echo get_the_event_time($p, $format);
}

function get_event_schedule($p = null) {
	global $post;
	$p = $p ?: $post;
	kritter_set_post_event($p);

	return (string) $p->event->schedule;
}

function is_event_all_day($p = null) {
	global $post;
	$p = $p ?: $post;
	kritter_set_post_event($p);

	return $p->event->meta['is_all_day'];
}

function is_event_multiday($p = null) {
	global $post;
	$p = $p ?: $post;
	kritter_set_post_event($p);

	return $p->event->isMultiDay();
}

// TODO
function get_events($query = null) {}
// TODO custom query params
function get_future_events($query = null) {
	return get_events(array_merge([
		'event_start_after' => 'today',
	], $query));
}
function get_past_events($query = null) {
	return get_events(array_merge([
		'event_start_before' => 'today',
	], $query));
}
function get_venues($query = null) {}
// TODO
function get_venue_events() {}
// TODO
function get_venue_events_query() {}

<?php

add_filter('yoast_seo_development_mode', '__return_true');

add_filter('wpseo_schema_webpage', function($data) {
	return;

	global $post;
	if ($post->post_type !== "kritter_event") return $data;

	kritter_set_post_event($post);

	$data['@type'] = "Event";
	$data['startDate'] = $post->event->start()->format('c');
	$data['endDate'] = $post->event->end()->format('c');
	$data['duration'] = $post->event->interval;
	$data['description'] = get_the_excerpt($post->ID);

	if ($post->event->start()->isFuture()):
		$data['eventStatus'] = "https://schema.org/EventScheduled";
	endif; // future

	if (has_post_thumbnail($post))
		$data['image'] = get_the_post_thumbnail_url($post);

	// TYPE VirtualLocation
	if ($post->event->venue):
		$data['location'] = [
			'@type' => "Place",
			'name' => $post->event->venue->title,
			'address' => [
				'@type' => "PostalAddress",
				'streetAddress' => "1234 Main St",
				'addressLocality' => "Louisville",
				'addressRegion' => "KY",
				'postalCode' => "40222",
				'url' => "https://google.com",
			]
		];
	endif; // venue

	// if ($performers = get_field('performers', $post->ID)):
	// 	foreach ($performers as $p):
	// 		$data['performer'][] = [
	// 			'@type' => "Person",
	// 			'name' => $p['name'],
	// 			'url' => $p['links'][0]['url'],
	// 		];
	// 	endforeach; // performers
	// endif; // performers

	if (isset($post->event->type)): switch($post->event->type):
		case "online":
			$data['eventAttendanceMode'] = "https://schema.org/OnlineEventAttendanceMode";
			break;
		case "offline":
			$data['eventAttendanceMode'] = "https://schema.org/OfflineEventAttendanceMode";
			break;
		case "mixed":
			$data['eventAttendanceMode'] = "https://schema.org/MixedEventAttendanceMode";
			break;
	endswitch; endif; // event type

	// TODO?
	// if ($post->event->venue):
	// endif; // venue

	return $data;
});

<?php

namespace Kritter\Calendar\Maps;

class OpenStreetMap extends Map
{
	public function __construct(int $post_id) 
	{
		$meta = get_field('map', $post_id);

		$this->zoom = $meta['zoom'];
		$this->show_markers = get_field('show_markers', $post_id);

		$this->center = new Coords(
			$meta['center_lat'], $meta['center_lng']
		);
		$this->coords = new Coords(
			$meta['lat'], $meta['lng']
		);

		$this->markers = [];
		foreach ($meta['markers'] as $marker):
			$this->markers[] = new Marker(
				$marker['lat'],
				$marker['lng'],
				$marker['label']
			);
		endforeach; // markers
	}
}


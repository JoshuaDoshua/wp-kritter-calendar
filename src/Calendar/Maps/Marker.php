<?php

namespace Kritter\Calendar\Maps;

class Marker extends Coords
{
	public $label;
	public $icon;

	public function __construct(float $lat, float $lng, string $label = "", string $icon = null)
	{
		parent::__construct($lat, $lng);

		$this->label = $label;
		$this->icon = $icon;
	}
}


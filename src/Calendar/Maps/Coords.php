<?php

namespace Kritter\Calendar\Maps;

class Coords
{
	public float $lat;
	public float $lng;

	public function __construct(float $lat, float $lng)
	{
		$this->lat = $lat;
		$this->lng = $lng;
	}

	public function __toString(): string
	{
		return json_encode($this->toArray());
	}

	public function toArray(): array
	{
		return [
			'lat' => $this->lat,
			'lng' => $this->lng,
		];
	}
}


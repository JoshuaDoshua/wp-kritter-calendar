<?php

namespace Kritter\Calendar\Maps;

class Map
{
	public $post_id;

	public $address;
	public $coords;
	public $center;
	public $zoom;

	public $markers;
	public $show_markers = true;

	public function __toString(): string
	{
		ob_start(); ?>
			<div class="kritter-calendar-map"
				data-map-center="<?= $this->coords; ?>"
				data-map-zoom="<?= $this->zoom; ?>"
				<?php if ($this->show_markers): ?>
					data-map-markers="<?= json_encode($this->markers); ?>"
				<?php endif; // show markers ?>
				>ADDRESS PLACEHOLDER HERE</div>
		<?php return ob_get_clean();
	}

	public function directionsLink(string $text = "Map it", bool $new_tab = true): string
	{
		$str = "<a href=\"https://google.com/maps/@%f,%f,17z\">%s</a>";

		return sprintf($str, $this->coords->lat, $this->coords->lng, $text);
	}
}


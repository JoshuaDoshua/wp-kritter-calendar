<?php

namespace Kritter\Calendar\Maps;

class Map
{
	public $post_id;

	public $coords;
	public $center;
	public $zoom;
	public $markers;

	public function __toString(): string
	{
		ob_start(); ?>
			<div class="kritter-calendar-map"
				data-center="<?= $this->coords; ?>"
				data-zoom="<?= $this->zoom; ?>"
				data-markers="<?= json_encode($this->markers); ?>"
				>ADDRESS PLACEHOLDER HERE</div>
		<?php return ob_get_clean();
	}
}


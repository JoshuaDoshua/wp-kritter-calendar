<?php

namespace Kritter\Calendar;

use Carbon\Carbon;
use Carbon\CarbonInterval;

// TODO
// handle overrides here?

class Settings
{
	public function __construct()
	{
		// TODO
		// load schedule as fn, keep slim for event
		// we wont need time for schedules
		// and we can override/define in child classes
		// override in schedule w/ parent::format($carbon, 'schedule'); or something
		//
		// sup_ordinals
		// use_smart_spans
	}

	// type [type|time|schedule]
	// context [singular|start|end|list]
	// TODO overrides
	protected function format(Carbon $date, string $type, string $context): string
	{
		$format = $this->settings["format_{$type}_default"]
			? $this->wp_formats[$type]
			: $this->settings["format_{$type}_{$context}"];


		// TODO: pass post to filter
		$format = get_option("{$type}_format");
		$format = apply_filters('kritter/calendar/event/format/date', $format, $this);

		$ns = "kritter/calendar/event/format";

		if ($context == "span_start" || $context == "span_end")
			$format = apply_filters("{$ns}/date/span", $format, $this);
		if ($context == "span_start")
			$format = apply_filters("{$ns}/date/span/start", $format, $this);
		if ($context == "span_end")
			$format = apply_filters("{$ns}/date/span/end", $format, $this);

		return $date->format($format);
	}

	// type [type|time|schedule]
	protected function formatSpan(Carbon $start, Carbon $end, string $type): string
	{
		$span = [
			$this->format($start, $type, "span_start"),
			self::$separator,
			$this->format($end, $type, "span_end")
		];

		return implode(" ", $span);
	}

}


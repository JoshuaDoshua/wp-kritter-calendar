<?php

namespace Kritter\Calendar\Concerns;

use Carbon\Carbon;
use Kritter\Calendar;

trait HandlesDates
{
	// @var float
	protected $tz;

	// @var Carbon
	protected $start;

	// @var Carbon
	protected $end;

	public function setDates(string $start, string $end): void
	{
		// TODO
		// do we really need this?
		// should be set globally somewhere
		$this->tz = get_option('gmt_offset');

		$this->start = Carbon::createFromFormat("Ymd", $start, $this->tz);
		$this->end = Carbon::createFromFormat("Ymd", $end, $this->tz);
	}

	public function setTimes(bool $is_all_day = true, string $start = "", string $end = ""): void
	{
		if ($is_all_day) {
			$this->start->setTime(0,0,0);
			$this->end->setTime(23,59,59);
		} else {
			$this->start->setTimeFromTimeString($start, true);
			$this->end->setTimeFromTimeString($end, true);
		}
	}

	// type[date|time|schedule]
	// context[singular|start|end|list]
	public function formatSingle(Carbon $date, string $type, string $context = null): string
	{
		$format = $this->newFormat($type, $context);

		return Calendar::supOrdinals($date->format($format));
	}

	// type [date|time|schedule]
	public function formatSpan(Carbon $start, Carbon $end, string $type): string
	{
		$start_format = $this->newFormat($type, "span_start");
		$end_format = $this->newFormat($type, "span_end");

		$span_type = $type != "time" ? "date" : $type;

		$span = "&nbsp;&ndash;&nbsp;";

		if (!apply_filters('kritter/calendar/format/enable', false))
			return $start->format($start_format) . $span . $end->format($end_format);

		$span = apply_filters("kritter/calendar/separator", $span, $this);
		$span = apply_filters("kritter/calendar/separator_{$span_type}", $span, $this);

		if ($type == "schedule") // TODO ew?
			$span = apply_filters("kritter/calendar/separator_schedule", $span, $this);

		return Calendar::supOrdinals($start->format($start_format)
			. $span
			. Calendar::supOrdinals($end->format($end_format)));
	}

	private function newFormat(string $type = "date", $context = null): string
	{
		$ns = "kritter/calendar/format";

		// always apply wp default, date or time
		$wp_type = $type == "schedule" ? "date" : $type;
		$format = get_option("{$wp_type}_format");

		if (!apply_filters("{$ns}/enable", false)) return $format;

		$format = apply_filters("{$ns}/{$type}", $format, $this);

		if ($context):
			$full_context = "{$type}_{$context}";

			foreach (Calendar::FORMAT_FILTERS[$full_context] as $pre)
				$format = apply_filters("{$ns}/{$pre}", $format, $this);

			$format = apply_filters("{$ns}/{$full_context}", $format, $this);
		endif; // has context

		return $format;
	}
}

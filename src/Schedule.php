<?php

namespace Kritter\Calendar;

use Carbon\Carbon;
use Kritter\Calendar\Concerns\HandlesDates;

class Schedule extends Settings
{
	use HandlesDates;

	// @var int
	public $event_id;

	// @var string
	public $recurrence;

	// @var array
	public $meta;

	public function __construct(int $event_id, string $recurrence)
	{
		$this->event_id = $event_id;
		$this->recurrence = $recurrence;
		$this->meta = get_field('recurrence_meta', $event_id);

		$this->setDates(
			get_field('schedule_start', $event_id),
			get_field('schedule_end', $event_id)
		);
		$this->setTimes();
	}

	// after date has been filtered
	public function additionalFormatSingle(string $format, string $type, string $context): string
	{
		$ns = "kritter/calendar/schedule/format";
		$format = apply_filters($ns, $format, $this);
		$format = apply_filters("{$ns}/{$context}", $format, $this);

		return $format;
	}

	public function formatSpan(Carbon $start, Carbon $end, string $type): string
	{
		return $this->formatSingle($start, "schedule", "span_start")
			. "&nbsp;&ndash;&nbsp;"
			. $this->formatSingle($end, "schedule", "span_end");
	}

	public function start(): Carbon
	{
		return $this->start;
	}

	public function __get($var)
	{
		switch ($var):
			case "start":
				return $this->formatSingle($this->start, 'schedule', 'start');

			case "end":
				return $this->formatSingle($this->end, 'schedule', 'end');

			case "span":
				return $this->formatSpan($this->start, $this->end, 'span');

			default:
				return $this->$var;

		endswitch;
	}

	// __toString
	// getList
	// getFuture
	// getPast
	// getFirst
	// getLast
	// getNext
}


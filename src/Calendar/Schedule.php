<?php

namespace Kritter\Calendar;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Kritter\Calendar\Concerns\WithDates;
use Kritter\Calendar\Recurrences\Recurrence;

class Schedule 
{
	use WithDates;

	// @var int
	public $post_id;

	// @var string
	public $recurrence;

	public function __construct(int $post_id, string $recurrence)
	{
		$this->post_id = $post_id;
		$this->recurrence = $this->setRecurrence($recurrence);

		$start = get_field('schedule_meta_start', $post_id);
		$end = get_field('schedule_meta_end', $post_id);

		$this->setDates($start, $end);
		$this->period = CarbonPeriod::between($start, $end);

		$this->setTimes();
	}

	public function setRecurrence(string $recurrence): Recurrence
	{
		$map = [
			'day' => \Kritter\Calendar\Recurrences\Daily::class,
			'week' => \Kritter\Calendar\Recurrences\Weekly::class,
			'month_date' => \Kritter\Calendar\Recurrences\MonthlyDates::class,
			'month_day' => \Kritter\Calendar\Recurrences\MonthlyDays::class,
			'year' => \Kritter\Calendar\Recurrences\Annually::class,
		];

		return (new $map[$recurrence]($this->post_id));
	}

	public function __toString(): string
	{
		return (string) $this->summary;
	}

	public function __get($var)
	{
		switch ($var):
			case "start":
				return $this->formatSingle($this->start, 'schedule', 'start');
			case "end":
				return $this->formatSingle($this->end, 'schedule', 'end');
			case "span":
				return $this->formatSpan($this->start, $this->end, 'schedule');
			case "summary":
				return $this->recurrence->getSummary();
				// return "schedule_summary";
			default:
				return $this->$var;
		endswitch;
	}

	public function start(): Carbon
	{
		return $this->start;
	}

	public function end(): Carbon
	{
		return $this->end;
	}

	public function doStuffWithFilter(): void
	{
		// set filter
		$weekendFilter = function ($date) {
			return $date->isWeekend();
		};
		$this->period->filter($weekendFilter);
	}

	// __toString
	// getList
	// getFuture
	// getPast
	// getFirst
	// getLast
	// getNext
}


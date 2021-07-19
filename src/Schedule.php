<?php

namespace Kritter\Calendar;

use Carbon\Carbon;
use Kritter\Calendar\Concerns\HandlesDates;
use Kritter\Calendar\Recurrences\Recurrence;

class Schedule 
{
	use HandlesDates;

	// @var int
	public $post_id;

	// @var string
	public $recurrence;

	public function __construct(int $post_id, string $recurrence)
	{
		$this->post_id = $post_id;
		$this->recurrence = $this->setRecurrence($recurrence);

		$this->setDates(
			get_field('recurrence_meta_schedule_start', $post_id),
			get_field('recurrence_meta_schedule_end', $post_id)
		);
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

	// __toString
	// getList
	// getFuture
	// getPast
	// getFirst
	// getLast
	// getNext
}


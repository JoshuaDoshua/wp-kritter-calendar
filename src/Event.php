<?php

namespace Kritter\Calendar;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Kritter\Calendar\Schedule;
use Kritter\Calendar\Concerns\HandlesDates;

class Event
{
	use HandlesDates;

	// @var int
	public $post_id;

	// @var Carbon\Carbon
	protected $start;

	// @var Carbon\Carbon
	protected $end;

	// @var bool
	public $is_all_day;

	// @var bool
	public $is_multi_day;

	// @var bool
	public $hide_end_time;

	// @var Carbon\CarbonInterval
	protected $interval;

	// @var \Kritter\Calendar\Venue 
	public $venue;

	// @var \Kritter\Calendar\Schedule
	public $schedule;

	public function __construct(int $post_id)
	{
		$this->post_id = $post_id;
		
		$start_date = get_field('start_date', $post_id);
		if (!$start_date) return;

		$this->setDates($start_date, get_field('end_date', $post_id));
		$this->is_all_day = get_field('is_all_day', $post_id);
		$this->is_multi_day = !$this->start->isSameDay($this->end);
		$this->setTimes(
			$this->is_all_day,
			get_field('start_time', $post_id),
			get_field('end_time', $post_id)
		);
		$this->hide_end_time = get_field('hide_end_time', $post_id);

		// so ugly, but need to handle 24 hrs & isSameDay together somehow
		// and Round Carbon method wasnt working
		$this->interval = $this->is_all_day
			? $this->start->diffAsCarbonInterval($this->end->copy()->addSeconds(1), true)
			: $this->start->diffAsCarbonInterval($this->end, true);

		$venue_id = get_field('venue', $post_id);
		$this->venue = $venue_id
			? new Venue($venue_id)
			: false;
		
		$recurrence = get_field('recurrence', $post_id);
		$this->schedule = $recurrence == "once"
			? false
			: new Schedule($this->post_id, $recurrence);
	}


	public function __get($var): string
	{
		switch ($var):

			case "date":
				return $this->getDate();
			case "start_date":
				return $this->getDate("start");
			case "end_date":
				return $this->getDate("end");

			case "time":
				return $this->getTime();
			case "start_time":
				return $this->getTime("start");
			case "end_time":
				return $this->getTime("end");

			case "length":
				return $this->hide_end_time
					? false
					: (string) $this->interval;

			default:
				return (string) $this->$var;

		endswitch; // $var
	}

	// TODO
	// reset __get to format to string
	// and method to format to Carbon
	public function start(): Carbon
	{
		return $this->start;
	}
	public function end(): Carbon
	{
		return $this->end;
	}
	public function interval(): CarbonInterval
	{
		return $this->interval;
	}

	public function isMultiDay(): bool
	{
		return !$this->start->isSameDay($this->end);
	}

	public function getDate($type = false): string
	{
		if ($type)
			return $this->formatSingle($this->$type, "date", $type);

		$str = $this->isMultiDay()
			? $this->formatSpan($this->start, $this->end, 'date')
			: $this->formatSingle($this->start, "date");

		// $str = $this->supOrdinal($str);
		return $str;
	}

	public function getTime($type = false): string
	{
		// TODO: all day text setting
		$all_day_text = "All Day";

		if ($this->is_all_day && $all_day_text)
			return $all_day_text;

		if ($type)
			return $this->formatSingle($this->$type, "time", $type);

		return $this->hide_end_time
			? $this->formatSingle($this->start, "time")
			: $this->formatSpan($this->start, $this->end, 'time');
	}

	// TODO? start/end?
	// public function getDateTime(): string {}
}

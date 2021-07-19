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

	// @var array
	public $meta;

	// @var Carbon\CarbonInterval
	private $interval;

	// @var \Kritter\Calendar\Venue 
	public $venue;

	// @var \Kritter\Calendar\Schedule
	public $schedule;

	public function __construct(int $post_id)
	{
		$this->post_id = $post_id;
		
		$this->meta = [
			'start_date' => get_field('start_date', $post_id),
			'end_date' => get_field('end_date', $post_id),
			'is_all_day' => get_field('is_all_day', $post_id),
			'start_time' => get_field('start_time', $post_id),
			'end_time' => get_field('end_time', $post_id),
			'hide_end_time' => get_field('hide_end_time', $post_id),
			'venue' => get_field('venue', $post_id),
			'recurrence' => get_field('recurrence', $post_id),
		];

		if (!$this->meta) return;

		$this->setDates($this->meta['start_date'], $this->meta['end_date']);
		$this->setTimes(
			$this->meta['is_all_day'],
			$this->meta['start_time'],
			$this->meta['end_time']
		);

		// so ugly, but need to handle 24 hrs & isSameDay together somehow
		// and Round Carbon method wasnt working
		$this->interval = $this->meta['is_all_day']
			? $this->start->diffAsCarbonInterval($this->end->copy()->addSeconds(1), true)
			: $this->start->diffAsCarbonInterval($this->end, true);

		$this->venue = $this->meta['venue']
			? new Venue($this->meta['venue'])
			: false;
		
		$this->schedule = $this->meta['recurrence'] == "once"
			? false
			: new Schedule($this->post_id, $this->meta['recurrence']);
	}


	public function __get($var): string
	{
		switch ($var):
			case "date":
				return (string) $this->getDate();
			case "time":
				return (string) $this->getTime();
			case "length":
				return $this->meta['hide_end_time']
					? false
					: (string) $this->interval;
			
			// TODO: find way to format this once
			// combine other into getDateTime()
			// "start", so we can combine __get ter w/ concern
			//
			// case "start_datetime":
			// 	return $this->format($this->start, 'date', 'singular') . " " . $this->format($this->start, 'time', 'singular');
			// case "end_datetime":
			// 	return $this->format($this->end, 'date', 'singular') . " " . $this->format($this->end, 'time', 'singular');

			// case "start_date":
			// 	return $this->format($this->start, 'date', 'singular');
			// 
			// case "end_date":
			// 	return $this->format($this->end, 'date', 'singular');
			// 
			// case "start_time":
			// 	return $this->format($this->start, 'time', 'singular');
			// 
			// case "end_time":
			// 	return $this->format($this->end, 'time', 'singular');

			default:
				return $this->$var;

		endswitch;
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

	public function getDate(): string
	{
		$str = $this->isMultiDay()
			? $this->formatSpan($this->start, $this->end, 'date')
			: $this->formatSingle($this->start, "date");

		// $str = $this->supOrdinal($str);

		return $str;
	}

	public function getTime(): string
	{
		// TODO: all day text setting
		$all_day_text = "All Day";

		if ($this->meta['is_all_day'] && $all_day_text)
			return $all_day_text;

		return $this->meta['hide_end_time']
			? $this->formatSingle($this->start, "time")
			: $this->formatSpan($this->start, $this->end, 'time');
	}

	// TODO? start/end?
	// public function getDateTime(): string {}
}

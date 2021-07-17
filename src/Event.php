<?php

namespace Kritter\Calendar;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Kritter\Calendar\Concerns\HandlesDates;

class Event
{
	use HandlesDates;

	// @var int
	public $post_id;

	// @var array
	public $meta;

	// @var Carbon\CarbonInterval
	public $interval;

	// @var \Kritter\Calendar\Venue 
	public $venue;

	// @var \Kritter\Calendar\Schedule
	public $schedule;

	public function __construct(int $post_id)
	{
		$this->post_id = $post_id;
		
		// TODO do specific fields
		// so they're easily accessible outside of class
		$this->meta = get_fields($post_id);

		$this->setDates($this->meta['start_date'], $this->meta['end_date']);
		$this->setTimes(
			$this->meta['is_all_day'],
			$this->meta['start_time'],
			$this->meta['end_time']
		);

		// TODO ugly
		$this->interval = $this->meta['is_all_day']
			? $this->start->diffAsCarbonInterval($this->end->copy()->addSeconds(1), true)
			: $this->start->diffAsCarbonInterval($this->end, true);


		$this->venue = $this->meta['venue']
			? new Venue($this->meta['venue'])
			: false;
		
		$this->schedule = $this->meta['recurrence'] == "onetime"
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
				return (string) $this->interval;
			
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
			? $this->formatSingle($this->start, "time", "singular")
			: $this->formatSpan($this->start, $this->end, 'time');
	}

	// TODO? start/end?
	// public function getDateTime(): string {}
}

// TODO
// do we really need Carbon?
// makes it easy for the front-end
// but how much do we anticipate manipulating dates?
//
// NOTE GREAT IDEA
// use custom filters for date formatting!
// replace CalendarSettings formatting options!
// this plugin is for me/us, don't rly care about the users being able

// filters for all defined in calendar settings
// narrow by tax/cat?
// put overrides in acf_fields per event? et al?

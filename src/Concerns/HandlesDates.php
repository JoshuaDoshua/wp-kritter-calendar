<?php

namespace Kritter\Calendar\Concerns;

use Carbon\Carbon;

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

	protected function supOrdinals(string $string): string
	{
		$sup = apply_filters('kritter/calendar/format/sup_ordinals', true, $this);

		if (!$sup) return $string;

		return preg_replace('/(\d)(st|nd|rd|th)([^\w\d]|$)/', '$1<sup>$2</sup>$3', $string);
	}

	// type[date|time|schedule]
	// context[singular|start|end|list]
	public function formatSingle(Carbon $date, string $type, string $context = null): string
	{
		$format = $this->getFormat($type, $context);

		return $date->format($format);
	}

	// type [date|time|schedule]
	public function formatSpan(Carbon $start, Carbon $end, string $type): string
	{
		$start_format = $this->getFormat($type, "span_start");
		$end_format = $this->getFormat($type, "span_end");

		return $start->format($start_format)
			. "&nbsp;&ndash;&nbsp;"
			. $end->format($end_format);
	}

	// type[date|time|schedule]
	// schedule does date first
	// context[null|span_start|span_end|list]
	private function getFormat(string $type = "date", $context = null): string
	{
		$ns = "kritter/calendar/format";

		// wp default, date or time
		$wp_type = $type == "schedule" ? "date" : $type;
		$f = get_option("{$wp_type}_format");

		// runs { date | time }
		$f = apply_filters("{$ns}/{$wp_type}", $f, $this);

		// runs { time_span | time_span_[start|end] }
		if ($type == "time"):
			if (strpos($context, "span") !== false) {
				// { time_span }
				$f = apply_filters("{$ns}/time_span", $f, $this);
				// { time_span_[start|end] }
				$f = apply_filters("{$ns}/time_{$context}", $f, $this);
			}

			// bail early for times
			return $this->supOrdinals($f);
		endif; // bail early for time

		// { date_span | date_span_[start|end] }
		if (strpos($context, "span") !== false || $type == "schedule"):
			// { date_span }
			$f = apply_filters("{$ns}/date_span", $f, $this); 

			// { date_span_start }
			if (strpos($context, "start") !== false) {
				$f = apply_filters("{$ns}/date_span_start", $f, $this); 
			}

			// { date_span_end }
			if (strpos($context, "end") !== false) {
				$f = apply_filters("{$ns}/date_span_end", $f, $this); 
			}

		endif; // span or any schedule

		// { schedule | schedule_[start|end|list] }
		if ($context == "schedule"):
			// { schedule }
			$f = apply_filters("{$ns}/schedule", $f, $this);
			// { schedule_[start|end] }
			$f = apply_filters("{$ns}/{$context}", $f, $this);
		endif; // schedule

		return $this->supOrdinals($f);
	}
}
// kritter/calendar/format/date
// kritter/calendar/format/date_span
// kritter/calendar/format/date_span_start
// kritter/calendar/format/date_span_end
// kritter/calendar/format/schedule	(date|date_span)
// kritter/calendar/format/schedule_start (date|date_span|date_span_start)
// kritter/calendar/format/schedule_end (date|date_span|date_span_end)
// kritter/calendar/format/schedule_list (date)

// order for dates & schedules
//
// all times			  :: { time }
// time_span_[start|end]  :: { time, time_span, time_span_[start|end] }
//
// all dates			  :: { date }
// date_span_[start|end]  :: { date, date_span, date_span_[start|end] }
// all schedules		  :: { date, date_span, schedule }
// schedule_[start|end]	  :: { date, date_span, schedule, schedule_[start|end] }
// schedule_list		  :: { date, schedule, schedule_list }
//

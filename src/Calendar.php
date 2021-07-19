<?php

namespace Kritter\Calendar;

class Calendar
{
	// TODO?
	public static $wp_tz;
	public static $wp_date_format;
	public static $wp_time_format;

	const WEEKDAYS = [
		"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
	];

	// TODO, explore other ways to handle this
	const FORMAT_FILTERS = [
		'time_start' => ['time'],
		'time_end' => ['time'],
		'time_span' => ['time'],
		'time_span_start' => [
			'time',
			'time_start',
			'time_span',
		],
		'time_span_end' => [
			'time',
			'time_end',
			'time_span',
		],
		'date_start' => ['date'],
		'date_end' => ['date'],
		'date_span' => ['date'],
		'date_span_start' => [
			'date',
			'date_start',
			'date_span',
		],
		'date_span_end' => [
			'date',
			'date_end',
			'date_span',
		],
		'schedule_start' => [
			'date',
			'schedule',
		],
		'schedule_end' => [
			'date',
			'schedule',
		],
		'schedule_span' => [
			'date',
			'date_span',
			'schedule',
		],
		'schedule_span_start' => [
			'date',
			'date_start',
			'date_span',
			'schedule',
			'schedule_span',
		],
		'schedule_span_end' => [
			'date',
			'date_end',
			'date_span',
			'schedule',
			'schedule_span',
		],
		'schedule_list' => [
			'date',
			'schedule',
		],
	];

	public function __construct()
	{
		\Carbon\Carbon::setWeekStartsAt(get_option('start_of_week'));
	}

	public static function arrayToCsv(array $arr, $and = "&amp;"): string
	{
		$n = count($arr);
		if ($n === 1) return $arr[0];
		elseif ($n === 2) return "{$arr[0]} {$and} {$arr[1]}";

		$arr[$n-1] = "{$and} {$arr[$n-1]}";

		return implode(", ", $arr);
	}

	public static function addOrdinal(int $num): string
	{
		$ends = ['th','st','nd','rd','th','th','th','th','th','th'];

		return (($num % 100 >= 11) && (($num % 100) <= 13))
			? "{$num}th"
			: $num . $ends[$num % 10];
	}

	public static function supOrdinals(string $string): string
	{
		$sup = apply_filters('kritter/calendar/format/sup_ordinals', true);

		if (!$sup) return $string;

		return preg_replace('/(\d)(st|nd|rd|th)([^\w\d]|$)/', '$1<sup>$2</sup>$3', $string);
	}
}


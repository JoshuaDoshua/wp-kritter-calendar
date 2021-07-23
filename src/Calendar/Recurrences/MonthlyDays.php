<?php

namespace Kritter\Calendar\Recurrences;

use Carbon\Carbon;

use Kritter\Calendar;

class MonthlyDays extends Recurrence
{
	public $singular = "month";
	public $plural = "months";

	public $month_days;

	public function __construct(int $post_id)
	{
		parent::__construct($post_id);

		$this->setMonthDays();
	}

	private function setMonthDays(): void
	{
		$days = get_field('schedule_meta_month_days', $this->post_id);

		array_walk($days, function(&$day, $key) {
			array_walk($day, function(&$item, $k) {
				$item = (int) $item;
			});
		});

		$this->month_days = $days;
	}


	public function getSummary(): string
	{
		$str = parent::getSummary() . " on ";

		// this works, use it to add a format filter
		// dd(new Carbon("Sat"));
		
		// dd($this->month_days);

		$week_days = [];
		foreach ($this->month_days as $week_day => $month_day):
			if (count($month_day) === 0) continue;
			array_walk($month_day, function(&$num) {
				$num = $num === -1
					? "last"
					: Calendar::addOrdinal((int) $num);
			});
			$week_days[] = "the " . Calendar::arrayToCsv($month_day) . " " . ucwords($week_day);
		endforeach; // this->month_days

		$str .= Calendar::arrayToCsv($week_days);

		return $str;

		$days = [];
		foreach ($this->days as $day):
			$days[] = Calendar::addOrdinal($day['number']) . " " . $day['day'];
		endforeach; // days

		// sort days by [number => day][1 (1st) => 6 (friday)]
		// group by [day]
		// want it to basically say
		// 1st and 3rd Mon, 2nd and last Thu of every month

		return $str;
	}
}

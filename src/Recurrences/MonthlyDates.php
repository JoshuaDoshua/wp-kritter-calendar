<?php

namespace Kritter\Calendar\Recurrences;

use Carbon\Carbon;

use Kritter\Calendar\Calendar;

class MonthlyDates extends Recurrence
{
	public $singular = "month";
	public $plural = "months";

	public $dates;

	public function __construct(int $post_id)
	{
		parent::__construct($post_id);

		$this->setDates();
	}

	public function setDates(): void
	{
		$dates = get_field('recurrence_meta_month_dates', $this->post_id);

		array_walk($dates, function(&$item) {
			$item = (int) $item['date'];
		});
		
		sort($dates, SORT_NUMERIC);

		$this->dates = $dates;
	}

	public function getSummary(): string
	{
		$dates = array_map(function($date) {
			return $date < 32
				? Calendar::addOrdinal($date)
				: "last day";
		}, $this->dates);

		$dates_str = Calendar::arrayToCsv($dates);

		if ($this->frequency === 1)
			return sprintf("On the %s of every month", $dates_str);
		elseif ($this->frequency === 2)
			return sprintf("On the %s every other month", $dates_str);
		else
			return sprintf("On the %s of every %s month", $dates_str, Calendar::addOrdinal($this->frequency));
	}
}

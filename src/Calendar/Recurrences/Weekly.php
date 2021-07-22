<?php

namespace Kritter\Calendar\Recurrences;

use Carbon\Carbon;

use Kritter\Calendar\Calendar;

class Weekly extends Recurrence
{
	public $singular = "week";
	public $plural = "weeks";

	public function __construct(int $post_id)
	{
		parent::__construct($post_id);

		$this->setDays($post_id);
	}

	private function setDays(int $post_id): void
	{
		$days = get_field('recurrence_meta_week_days', $post_id);
		$this->days = array_map(function($day) {
			return \Kritter\Calendar\Calendar::WEEKDAYS[intval($day)];
		}, $days);
	}

	public function getSummary(): string
	{
		$days_str = Calendar::arrayToCsv($this->days);

		if ($this->frequency === 1)
			return sprintf("Every %s", $days_str);
		elseif ($this->frequency === 2 && count($this->days) === 1)
			return sprintf("Every other %s", $days_str);

		return parent::getSummary() . " on " . $days_str;
	}
}


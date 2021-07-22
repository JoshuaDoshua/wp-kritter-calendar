<?php

namespace Kritter\Calendar\Recurrences;

use Carbon\Carbon;

use Kritter\Calendar\Calendar;

class Annually extends Recurrence
{
	public $singular = "year";
	public $plural = "years";

	public function getSummary(): string
	{
		global $post;

		$str = parent::getSummary();

		// TODO
		// need to pull event date w/ format filters
		$str .= " on {$post->event->start()->format("F jS")}";

		return $str;
	}
}

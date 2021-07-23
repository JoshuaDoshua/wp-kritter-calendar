<?php

namespace Kritter\Calendar\Recurrences;

class Recurrence 
{
	public $post_id;
	public $frequency;

	public $singular;
	public $plural;

	// TODO, store and save?
	public $meta_key;

	public function __construct(int $post_id)
	{
		$this->post_id = $post_id;

		$this->frequency = (int) get_field('schedule_meta_frequency', $post_id);

		// TODO
		// do CarbonPeriod in Schedule, pull from here
		// inclusive/excludsive start/end TODO use this to fix Schedule
		// schedule extends CarbonPeriod?
		// should i just use carbon period for...everything?
		// filter
		// recurrence
		// if hasFilter(method)
	}

	public function getSummary(): string
	{
		if ($this->frequency === 1)
			return sprintf("Every %s", $this->singular);
		elseif ($this->frequency === 2)
			return sprintf("Every other %s", $this->singular);
		else
			return sprintf("Every %d %s", $this->frequency, $this->plural);
	}
}


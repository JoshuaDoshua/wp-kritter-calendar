<?php

namespace Kritter\Calendar;

use Kritter\Calendar\Maps\OpenStreetMap;

class Venue extends Settings
{
	// @var int
	public $post_id;

	// @var str
	public $title;

	// @var array
	protected $address;

	// @var array
	public $map;

	// @var array
	protected $contact;

	public function __construct(int $post_id)
	{
		$this->post_id = $post_id;

		$this->title = get_the_title($post_id);

		$this->address = get_field('address', $post_id);
		$this->map = new OpenStreetMap($post_id);
		$this->contact = get_field('contact', $post_id);
	}

	// TODO
	// either
	// street() method
	// address() method
	// filter with named parameters
	public function __get($var): string
	{
		if (isset($this->address[$var]) && $this->address[$var] !== "")
			return $this->address[$var];

		elseif (isset($this->contact[$var]))
			return $this->contact[$var];

		if ($var == "description")
			return get_the_excerpt($this->post_id);

		return (string) $this->$var;
	}

	// TODO check map
	public function __toString(): string
	{
		$str_arr = [
			$this->title,
			$this->address['street'],
			"{$this->address['city']}",
			$this->address['state'],
			$this->address['post_code']
		];

		return implode(" ", $str_arr);
	}

	public function toHtml(string $css_class = ""): string
	{
		ob_start(); ?>
		<address class="address <?= $css_class; ?>">
			<strong class="address__line address__line--block address__line--name"><?= get_the_title($this->post_id); ?></strong>
			<span class="address__line address__line--block address__line--street"><?= $this->address['street']; ?></span>
			<span class="address__line address__line--inline address__line--city"><?= $this->address['city']; ?>,</span>
			<span class="address__line address__line--inline address__line--state"><?= $this->address['state']; ?></span>
			<span class="address__line address__line--inline address__line--postal"><?= $this->address['postal']; ?></span>
		</address>
		<?php return ob_get_clean();
	}

	public function toHtmlSchema(string $css_class = ""): string
	{
		// using microdata
		ob_start(); ?>
		<address class="address <?= $css_class; ?>" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
			<strong class="address__line address__line--block address__line--name" itemprop="name"><?= get_the_title($this->post_id); ?></strong>
			<span class="address__line address__line--block address__line--street" itemprop="streetAddress"><?= $this->address['street']; ?></span>
			<span class="address__line address__line--inline address__line--city" itemprop="addressLocality"><?= $this->address['city']; ?>,</span>
			<span class="address__line address__line--inline address__line--state" itemprop="addressRegion"><?= $this->address['state']; ?></span>
			<span class="address__line address__line--inline address__line--postal" itemprop="postalCode"><?= $this->address['postal']; ?></span>
		</address>
		<?php return ob_get_clean();
	}

	// TODO
	// public function toJsonLD(): string {}

	// TODO
	// public function toMap(): string {}
}


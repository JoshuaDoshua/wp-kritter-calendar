<?php

namespace Kritter\Calendar;

class Venue extends Settings
{
	// @var int
	protected $post_id;

	// @var array
	protected $meta;

	// @var array
	protected $address;

	// @var array
	protected $map;

	// @var array
	protected $contact;

	public function __construct(int $post_id)
	{
		$this->post_id = get_post($post_id);

		// $meta = get_fields($post_id);
		// 
		// $this->address = $meta['address'];
		// $this->map = $meta['map'];
		// $this->contact = $meta['contact'];

		$this->address = get_field('address', $post_id);
		$this->map = get_field('map', $post_id);
		$this->contact = get_field('contact', $post_id);
	}

	public function __toString(): string
	{
		$str_arr = [
			get_the_title($this->post_id),
			$this->address['street'],
			"{$this->address['city']}",
			$this->address['state'],
			$this->address['postal']];

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


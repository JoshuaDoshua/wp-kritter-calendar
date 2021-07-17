> About this plugin
>
> This plugin is intended for developers. It requires ACF Pro and, while some defaults have been setup, typically requires some template coding setup & filters.

# Kritter Calendar Events

## Important Reference Links

- (php DateTime::format)[https://www.php.net/manual/en/datetime.format.php]
- (Carbon)[https://carbon.nesbot.com/docs/]

# Formatting Filters

You can utilize Carbons many helpers to make customizing formatting fast and flexible.

Filter Structure

`kritter/calendar/format/{type}?/{contexts}`

> All format filters accept $format and $object parameters
>
> `$format` is the current format in the filter execution
> `$object` is the \Kritter\Calendar\MODEL object and has a `$post_id` reference to the `\WP_Post`

## Date Filters

```
kritter/calendar/format/date
kritter/calendar/format/date/span
kritter/calendar/format/date/span/start
kritter/calendar/format/date/span/end

```

## Schedule Filters

> These  filters inherit date filters because they are dates as well

```
kritter/calendar/format/schedule
kritter/calendar/format/schedule/start
kritter/calendar/format/schedule/end
kritter/calendar/format/schedule/list

# TODO: recurrence specific?
kritter/calendar/format/schedule/daily
kritter/calendar/format/schedule/daily/start
kritter/calendar/format/schedule/daily/end
kritter/calendar/format/schedule/daily/list
```

## Time Filters

```
kritter/calendar/format/time
kritter/calendar/format/time/span
kritter/calendar/format/time/span/start
kritter/calendar/format/time/span/end
```

## ?? Venue Filters ??

## Common Format Filters

### Time Spans

Only show start am/pm in time span if they're different

> "10:00 am - 4:00 pm" vs "2:00 - 4:00 pm"

```php
<?php

// time_span_start
add_filter('kritter/calendar/format/time_span_start', function($format, $event) {
	if ($event->start()->format('a') == $event->end()->format('a'))
		return "g:i";

	return "g:i a";
}, 10, 2);
```

Only show minutes if not :00 and am/pm if different

> e.g. "2 - 4 pm" or "2:15 - 4 pm" or "2:30 - 4 pm"

```php
<?php

// time_span_start
add_filter('kritter/calendar/format/time_span_start', function($format, $event) {
	$is_same_ampm = ($event->start()->format('a') === $event->end()->format('a'));

	if ($event->start()->minute === 0) {
		return $is_same_ampm
			? "g"
			: "g a";
	}

	return $is_same_ampm
		? "g:i"
		: "g:i a";
}, 10, 2);

// time_span_end
add_filter('kritter/calendar/format/time_span_end', function($format, $event) {
	return $event->end()->minute === 0
		? "g a"
		: "g:i a";

	if ($event->end()->format('a') == $event->end()->format('a'))
		return "g:i";

	return "g:i a";

	return 'c';
}, 10, 2);
```

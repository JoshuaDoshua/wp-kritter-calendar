> About this plugin
>
> This plugin is intended for developers. It requires ACF Pro and, while some defaults have been setup, typically requires some template coding setup & filters.

# Kritter Calendar Events

## Important Reference Links

- (php DateTime::format)[https://www.php.net/manual/en/datetime.format.php]
- (Carbon)[https://carbon.nesbot.com/docs/]

# DateTime Format Customization

By default, this plugin uses the default date/time format from the WP admin. I've added a number of filters, with different specificities, that you can use to format how date/times look in different places. You can utilize Carbons many helpers to make customizing formatting fast and flexible.

**Filter Structure**

`kritter/calendar/format/TYPE(?_CONTEXT)`

**Callback Arguments**

- `$format` - the current format in the execution hierarchy
- `$kritter` - the \Kritter\Calendar\MODEL class
	- This contains a reference to the appropriate \WP_Post via `$kritter->post_id`
	- But not the entire post object to prevent recusive overloading

## Date Filters


#### `kritter/calendar/format/date`

All Dates

```php
<?php
// *all* dates
add_filter('kritter/calendar/format/date', function($format, $kritter) {
	// ...
}, 10, 2);
```

#### `kritter/calendar/format/date_span`

All dates that are "n to n"

```php
<?php
add_filter('kritter/calendar/format/date_span', function($format, $kritter) {
	// ...
}, 10, 2);
```

#### `kritter/calendar/format/date_span_start`

All first dates that are "N to n"

```php
<?php
add_filter('kritter/calendar/format/date_span_start', function($format, $kritter) {
	// ...
}, 10, 2);
```

#### `kritter/calendar/format/date_span_end`

All last dates that are "n to N"

```php
<?php
add_filter('kritter/calendar/format/date_span_end', function($format, $kritter) {
	// ...
}, 10, 2);
```

## Time Filters

#### `kritter/calendar/format/time`

All Times

```php
<?php
add_filter('kritter/calendar/format/time', function($format, $kritter) {
	// ...
}, 10, 2);
```

#### `kritter/calendar/format/time/span`

All times that are "n to n"

```php
<?php
add_filter('kritter/calendar/format/time_span', function($format, $kritter) {
	// ...
}, 10, 2);
```

#### `kritter/calendar/time_span_start`

All first times that are "N to n"

```php
<?php
add_filter('kritter/calendar/format/time_span_start', function($format, $kritter) {
	// ...
}, 10, 2);
```

#### `kritter/calendar/format/time_span_end`

All last times that are "n to N"

```php
<?php
add_filter('kritter/calendar/format/time_span_end', function($format, $kritter) {
	// ...
}, 10, 2);
```

## Schedule Filters

> These  filters inherit date filters because they are dates as well
> 
> TODO outline how date, date_span works here

```php
<?php
// all date formats from a schedule
// kritter/calendar/format/schedule
add_filter('kritter/calendar/format/schedule', function($format, $kritter) {
	// ...
}, 10, 2);
// kritter/calendar/format/schedule/start
// kritter/calendar/format/schedule/end
// kritter/calendar/format/schedule/list

```

# TODO: recurrence specific?
kritter/calendar/format/schedule/daily
kritter/calendar/format/schedule/daily/start
kritter/calendar/format/schedule/daily/end
kritter/calendar/format/schedule/daily/list

## ?? Venue Filters ??

## Common Format Filters

### Common Time Spans

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
		return $is_same_ampm ? "g" : "g a";
	}

	return $is_same_ampm ? "g:i" : "g:i a";
}, 10, 2);

// time_span_end
add_filter('kritter/calendar/format/time_span_end', function($format, $event) {
	return $event->end()->minute === 0 ? "g a" : "g:i a";

	if ($event->end()->format('a') == $event->end()->format('a'))
		return "g:i";

	return "g:i a";
}, 10, 2);
```

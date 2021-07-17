# Kritter Calendar Events

> Requires ACF Pro

## Important Reference Links

- (php DateTime::format)[https://www.php.net/manual/en/datetime.format.php]
- (Carbon)[https://carbon.nesbot.com/docs/]

# Formatting Filters

```
apply_filters('kritter/calendar/event/format/...', function($format, $eventOrSchedule) {
	return 'l F jS, Y';
}, 10, 2);

# TODO: multimple function reuse

# TODO: eventOrSchedule methods
# $obj->start->isSameYear($obj->end) ? ...
```

```
kritter/calendar/event/format/date
kritter/calendar/event/format/date/span
kritter/calendar/event/format/date/span/start
kritter/calendar/event/format/date/span/end

kritter/calendar/event/format/time
kritter/calendar/event/format/time/span
kritter/calendar/event/format/time/span/start
kritter/calendar/event/format/time/span/end

# inherits date
kritter/calendar/event/format/schedule
kritter/calendar/event/format/schedule/start
kritter/calendar/event/format/schedule/end
kritter/calendar/event/format/schedule/list

# TODO: recurrence specific?
kritter/calendar/event/format/schedule/daily
kritter/calendar/event/format/schedule/daily/start
kritter/calendar/event/format/schedule/daily/end
kritter/calendar/event/format/schedule/daily/list

# TODO: venue output
```

## Common Format Filters

```
// only show start am/pm in time span if different
// e.g. 10:00 am - 4:00 pm vs 2:00 - 4:00 pm
add_filter('kritter/calendar/format/time_span_start', function($format, $event) {
	if ($event->start()->format('a') == $event->end()->format('a'))
		return "g:i";

	return "g:i a";
}, 10, 2);
```

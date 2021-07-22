<?php

$ns = "kritter/calendar";

add_filter("{$ns}/format/date", 'kritter_default_format_date', 1, 2);
function kritter_default_format_date($f, $k) { return "F jS, Y"; }

add_filter("{$ns}/format/time", 'kritter_default_format_time', 1, 2);
function kritter_default_format_time($f, $kritter) { return "g:i a"; }

add_filter("{$ns}/format/date_span_start",'kritter_default_format_date_span_start', 1, 2); 
function kritter_default_format_date_span_start($f, $kritter) {
	if ($kritter->start()->isSameYear($kritter->end()))
		return "D M jS";

	return "D M jS Y";
}

add_filter("{$ns}/format/date_span_end", 'kritter_default_format_date_span_end', 1, 2);
function kritter_default_format_date_span_end($f, $kritter) { return "D M jS Y"; }

add_filter("{$ns}/format/time_span_start", 'kritter_default_format_time_span_start', 1, 2);
function kritter_default_format_time_span_start($f, $kritter) {
	if ($kritter->start()->format('a') === $kritter->end()->format('a'))
		return "g:i";

	return "g:i a";
}

add_filter("{$ns}/separator_schedule", 'kritter_default_separator_schedule', 1, 2);
function kritter_default_separator_schedule($span, $kritter) { return "&nbsp;until&nbsp;"; }

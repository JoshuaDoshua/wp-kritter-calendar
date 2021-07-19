
console.log('HEY', acf);

/*
 * what this script should do:
 *
 * update the min max values to match start
 * update min max values to match schedule
 * wrong show alert if dates are out of scope?
 * update the summary for schedules (and if missing)
 * list out all dates in summary (css to style grid w/ mq)
 * show error if custom dates are out of range
 *
 * manage requirements?
 */


acf.addAction('ready', function() {
	const startDateField = acf.getField('field_60f4bf3537145');
	const endDateField = acf.getField('field_60f4bf5937147');
	const allDayField = acf.getField('field_60f4bf6d4f0f1');

	const startTimeField = acf.getField('field_60f4bfab02b7f');
	const endTimeField = acf.getField('field_60f4bfbd02b80');
	const hideEndField = acf.getField('field_60f4bfc402b81');

	const venueFIeld = acf.getField('field_60f4c00b18e25');

	const recurrenceField = acf.getField('field_60f4c02818e26');

	const frequencyField = acf.getField('field_60f4c21927a24');
	const scheduleStartField = acf.getField('field_60f4c2b527a26');
	const scheduleEndField = acf.getField('field_60f4c3ae27a27');

	// TODO recurrence meta fields

	const $summary = jQuery('ID').find('.acf-input');

	startDateField.on('change', function(event) {
		// endDateField.$el.find('.input').datepicker('setDate', startDateField.val());

		endDateField.val(startDateField.val());
		endDateField.$el.find('.input').val(startDateField.$el.find('.input').val());
		endDateField.$el.find('.acf-input').hide().fadeIn();
	});

	function updateFrequencyAppend() {
		let v = recurrenceField.val()
		if (v == "month_day" || v == "month_date") {
			v = "month";
		}
		if (frequencyField.val() > 1) {
			v += "s";
		}

		frequencyField.$el.find('.acf-input-append').text(v);
	}

	recurrenceField.on('change', function(event) {
		updateFrequencyAppend();
	});
	frequencyField.on('change', function(event) {
		updateFrequencyAppend();
	});
});

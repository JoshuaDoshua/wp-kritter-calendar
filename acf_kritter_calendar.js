
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
	const startDateField = acf.getField('ID');
	const endDateField = acf.getField('ID');

	const allDayField = acf.getField('ID');

	const startTimeField = acf.getField('ID');
	const endTimeField = acf.getField('ID');

	const recurrenceField = acf.getField('ID');
	const scheduleStartField = acf.getField('ID');
	const scheduleEndField = acf.getField('ID');

	const frequencyField = acf.getField('ID');

	// TODO recurrence meta fields

	const $summary = jQuery('ID').find('.acf-input');

	startDateField.on('change', function(event) {
		endDateField.val(startDateField.val());
	});
});

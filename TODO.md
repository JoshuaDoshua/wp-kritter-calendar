# TODO

- [ ] store post_type key as static var
- [ ] Default to Google Maps API
- [ ] Better internationalization
- [x] Add a separator filter
- [-] Move static vars to a base plugin class
- [ ] add cron job to update event to next occurence
- [ ] add filter for default wp format (all/date/time);
	- define our own default filters
	- override w/ wp default filter
- [ ] use wp's first day of week for hard-coded acf fields
- [ ] acf validation
- [ ] look into `current_theme_supports`
	- vs adding a filter to remove all formatting filters
	- make filters opt-in
- [ ] yoast seo data for events/venues

---

- [ ] update admin to show recurrences
- [ ] Find a way to add specific times?
	- e.g. volleyball, mondays at different times

list out occurences in the meta box (js?)
add an "exclude" next to each one
	save, but save as excluded

---

- [ ] add filters for recurrence summary
	- make the filter a sprintf string
	- also have one for the values that get entered
	- or just have a filter for the summary per recurrence

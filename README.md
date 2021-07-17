> 🚧 UNDER ACTIVE DEVELOPMENT


> This plugin is intended for developers. It requires ACF Pro and, while some defaults have been setup, typically requires some template coding setup & filters.

# Kritter Calendar Events

**For Developers**

- Custom post types for Events (`kritter_event`) and Venues (`kritter_venue`)
- Hard-coded ACF fields
- Global `wp_post` hook to add `\WP_Post $post->event = new \Kritter\Calendar\Event($post->ID)`
- Some basic template functions following the standard `get_` and `the_` structure
- Gutenberg blocks for events & venues

> You'll notice that templates are exlcuded from this list.
> I'm trying to figure out (read: waiting on wp core team), to determine how I want to handletemplates vs guten-blocks

**For Users**

- Event time, location, map
- Recurring events with complex schedules
- Venues & event lists

## Important Reference Links

- [Wiki](/JoshuaDoshua/wp-kritter-calendar/wiki)
- [php DateTime::format](https://www.php.net/manual/en/datetime.format.php)
- [Carbon](https://carbon.nesbot.com/docs)

## Requirements

- php v?
- ACF Pro (v?)
- Google Maps API Key ? for maps

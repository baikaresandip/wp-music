# WP Music

##

Create a custom post type Music
* Create a custom hierarchical taxonomy Genre
* Create a custom non-hierarchical taxonomy Music Tag
* Create a custom meta box to save music meta information like Composer Name, Publisher, Year of recording, Additional Contributors, URL, Price, etc.
* Create a custom meta table and save all music meta information in that table.
* Create a custom admin settings page for Music. Settings option should contain options for changing currency, number of musics displayed per page, etc. Settings menu should be displayed under the Musics menu.
* Create a shortcode [music] to display the music(s) information. Shortcode attributes should be year, genre.


## Installation

1. Upload the `wp-music` directory to your `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit the 'Music > Settings' menu item in your admin sidebar to update the setting

## Shortcodes

Shortcodes will be used in any pages.

- `[music genre="GENRE_ID" show_title=false]`   to show musics list on anywhere in page
    - where,
    - `genre` - Taxonomy ID to show the music from that taxonomy. Default: ''
    - `show_title` - Show/Hide the title from the shortcode. Defalut: false


## Screenshots

![Music List View](/images/musics-list-view.png)
*Figure: Music List View with pagination via shortcode*

![Music Grid View](/images/musics-grid-view.png)
*Figure: Music Grid View with pagination via shortcode*

![Music Music settings](/images/WP-Music-Settings.png)
*Figure: Music setting API admin screen*



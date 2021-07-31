# WP Music

WP Music Plugin helps user to add the music list with music information. It has number of fields to show on the page like Publisher, Compser Name, Year of recording, Additional Contributors, URL, Price, etc. We can easily show the list of musics on page via shortcode.

## Instructions of this plugin

* Created a custom post type Music
* Created a custom hierarchical taxonomy Genre
* Created a custom non-hierarchical taxonomy Music Tag
* Created a custom meta box to save music meta information like Composer Name, Publisher, Year of recording, Additional Contributors, URL, Price, etc.
* Created a custom meta table and save all music meta information in that table.
* Created a custom admin settings page for Music. Settings option should contain options for changing currency, number of musics displayed per page, etc. Settings menu should be displayed under the Musics menu.
* Created a shortcode `[music]` to display the music(s) information. Shortcode attributes should genre, show_title.

### Extra Enhancemnets
* Added music display view, List view and Grid view
* Added feature to show/hide the title for the shortcode
* Added numbered pagination in shortcode  
* Update the default setting on the plugin activation  


## Future Enhancements
* Music custom Template Structure
* Setting for thumbnail image
* Improvements in the page meta fields
* Improvements payment integration
* Orders, transaction history, users, etc

## Installation

1. Upload the `wp-musics` directory to your `/wp-content/plugins/` directory
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



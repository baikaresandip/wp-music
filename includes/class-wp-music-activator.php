<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/baikaresandip
 * @since      1.0.0
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Music
 * @subpackage Wp_Music/includes
 * @author     Baikare Sandip <baikare.sandeep007@gmail.com>
 */
class Wp_Music_Activator {

	/**
	 * Create a table on plugin activation
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Update the default setting fields if already not updated
		if( !get_option('activated_wp_music', false) ){

			// Create a Custom meta table if already not created 
			global $wpdb;
			$table_name = $wpdb->prefix.'music_meta';

			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE IF NOT EXISTS $table_name (
					`id` bigint(20) NOT NULL AUTO_INCREMENT,
					`music_id` bigint(20) NOT NULL DEFAULT '0',
					`composer_name` varchar(200) NOT NULL DEFAULT '',
					`publisher` varchar(200) NOT NULL DEFAULT '',
					`year_recording` varchar(4) NOT NULL DEFAULT '',
					`contributors` varchar(200) NOT NULL DEFAULT '',
					`url` varchar(100) NOT NULL DEFAULT '',
					`price` int(10) NOT NULL DEFAULT '0',
					PRIMARY KEY (`id`)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		
		
			update_option( 'wpm_wpmusic_basic_setting', array('currency' => 'INR', 'per_page' => 9, 'music_view' => 'list-view') );
			update_option('activated_wp_music', true);
		}
	}


}

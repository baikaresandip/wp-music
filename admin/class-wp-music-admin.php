<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/baikaresandip
 * @since      1.0.0
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/admin
 * @author     Baikare Sandip <baikare.sandeep007@gmail.com>
 */
class Wp_Music_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Music_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Music_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-music-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Music_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Music_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-music-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function wpm_add_plugin_admin_menu() {
		add_submenu_page( 
			'edit.php?post_type=music', 
			__( 'WP Music Settings', 'wp-music' ),
			__( 'Settings', 'wp-music' ),
			'manage_options', 
			'setting-wp-music', 
			array($this, 'wpm_display_plugin_setup_page')
		);
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function wpm_add_action_links( $links ) {
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
		);
		return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function wpm_display_plugin_setup_page() {
		include_once( 'partials/wp-music-admin-setting-display.php' );
	}

	/**
	 * Create a Music Post type 
	 * 
	 */
	public function wpm_create_music_post_type(){
		// Create a custom post type music
		register_post_type('music',
			array(
				'labels'      => array(
					'name'                  => _x( 'Musics', 'Post Type General Name', 'wp-music' ),
					'singular_name'         => _x( 'Music', 'Post Type Singular Name', 'wp-music' ),
					'menu_name'             => __( 'Musics', 'wp-music' ),
					'name_admin_bar'        => __( 'Musics', 'wp-music' ),
					'archives'              => __( 'Item Archives', 'wp-music' ),
					'attributes'            => __( 'Item Attributes', 'wp-music' ),
					'parent_item_colon'     => __( 'Parent Music:', 'wp-music' ),
					'all_items'             => __( 'All Musics', 'wp-music' ),
					'add_new_item'          => __( 'Add New Music', 'wp-music' ),
					'add_new'               => __( 'Add New', 'wp-music' ),
					'new_item'              => __( 'New Music', 'wp-music' ),
					'edit_item'             => __( 'Edit Music', 'wp-music' ),
					'update_item'           => __( 'Update Music', 'wp-music' ),
					'view_item'             => __( 'View Music', 'wp-music' ),
					'view_items'            => __( 'View Musics', 'wp-music' ),
					'search_items'          => __( 'Search Music', 'wp-music' ),
					'not_found'             => __( 'Not found', 'wp-music' ),
					'not_found_in_trash'    => __( 'Not found in Trash', 'wp-music' ),
					'featured_image'        => __( 'Featured Image', 'wp-music' ),
					'set_featured_image'    => __( 'Set featured image', 'wp-music' ),
					'remove_featured_image' => __( 'Remove featured image', 'wp-music' ),
					'use_featured_image'    => __( 'Use as featured image', 'wp-music' ),
					'insert_into_item'      => __( 'Insert into music', 'wp-music' ),
					'uploaded_to_this_item' => __( 'Uploaded to this music', 'wp-music' ),
					'items_list'            => __( 'Items list', 'wp-music' ),
					'items_list_navigation' => __( 'Items list navigation', 'wp-music' ),
					'filter_items_list'     => __( 'Filter items list', 'wp-music' ),
				),
				'public'      => true,
				'has_archive' => true,
				'has_archive' => true,
				'rewrite'     => array( 'slug' => 'musics' ), // my custom slug
			)
		);

		// Create a custom taxonomy Genre
		$labels = array(
			'name'              => _x( 'Genre', 'taxonomy general name' ),
			'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Genre' ),
			'all_items'         => __( 'All Genre' ),
			'parent_item'       => __( 'Parent Genre' ),
			'parent_item_colon' => __( 'Parent Genre:' ),
			'edit_item'         => __( 'Edit Genre' ),
			'update_item'       => __( 'Update Genre' ),
			'add_new_item'      => __( 'Add New Genre' ),
			'new_item_name'     => __( 'New Genre Name' ),
			'menu_name'         => __( 'Genre' ),
		);
		$args   = array(
			'hierarchical'      => true, // make it hierarchical (like categories)
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'genre' ],
		);
		register_taxonomy( 'genre', [ 'music' ], $args );

		// Create a custom taxonomy Music Tags
		$labels = array(
			'name'              => _x( 'Music Tags', 'taxonomy general name' ),
			'singular_name'     => _x( 'Music Tag', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Music Tag' ),
			'all_items'         => __( 'All Music Tag' ),
			'parent_item'       => __( 'Parent Music Tag' ),
			'edit_item'         => __( 'Edit Music Tag' ),
			'update_item'       => __( 'Update Music Tag' ),
			'add_new_item'      => __( 'Add New Music Tag' ),
			'new_item_name'     => __( 'New  Music Tag' ),
			'menu_name'         => __( 'Music Tags' ),
		);
		$args   = array(
			'hierarchical'      => false, // make it hierarchical (like categories)
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'menu_icon'         => 'dashicons-format-audio',
			'rewrite'           => [ 'slug' => 'music-tags' ],
		);
		register_taxonomy( 'music-tags', [ 'music' ], $args );


	}

	/**
	 * Show Music Custom Post Metabox
	 * 
	 * @author Sandip Baikare
	 * @since 1.0.1
	 */
	public function wpm_music_notice_meta_box() {

		$screens = array( 'music' );
	
		foreach ( $screens as $screen ) {
			add_meta_box(
				'music-information',
				__( 'Music Information', 'wp-music' ),
				array($this, 'music_inforation_meta_box_callback'),
				$screen
			);
		}
	}
	/**
	 * Show MEtabox Fields on Music Post
	 * 
	 * @author Sandip Baikare
	 * @since 1.0.1
	 */
	public function music_inforation_meta_box_callback($post){
		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'music_info_nonce', 'music_info_nonce' );
		global $wpdb;
		$tablename = $wpdb->prefix .'music_meta';
		$music = $wpdb->get_row( "SELECT * FROM $tablename WHERE music_id =" . $post->ID, ARRAY_A);
		//print_r($music);

		$composer_name 	= !empty($music['composer_name']) ? esc_attr( $music['composer_name'] ): '';
		$publisher 		= !empty($music['publisher']) ? esc_attr( $music['publisher'] ): '';
		$year_recording = !empty($music['year_recording']) ? esc_attr( $music['year_recording'] ): '';
		$contributors 	= !empty($music['contributors']) ? esc_attr( $music['contributors'] ): '';
		$url 			= !empty($music['url']) ? esc_attr( $music['url'] ): '';
		$price 			= !empty($music['price']) ? esc_attr( $music['price'] ): '';
		
		?>
		<div class='wrap musicinfo'>	
			<div class="field row">
				<label for="composer_name"><?php _e('Composer Name', 'wp-music') ?></label>
				<input type="text" style="width:100%" id="composer_name" name="composer_name" value="<?php echo $composer_name; ?>">
				<span><?php _e('Please add composer name.', 'wp-music'); ?></span>
			</div>
			
			<div class="field row even">
				<label for="publisher"><?php _e('Publisher', 'wp-music'); ?></label>
				<input type="text" style="width:100%" id="publisher" name="publisher" value="<?php echo $publisher; ?>">
				<span ><?php _e('Please add publisher name.', 'wp-music'); ?></span>
			</div>
			<div class="field row">
				<label for="year_recording"><?php _e('Year Recording', 'wp-music'); ?></label>
				<input type="number" style="width:100%" id="year_recording" name="year_recording" value="<?php echo $year_recording; ?>">
				<span ><?php _e('Please add Year Recording.', 'wp-music'); ?></span>
			</div>
			
			<div class="field row even">
				<label for="contributors"><?php _e('Contributors', 'wp-music'); ?></label>
				<input type="text" style="width:100%" id="contributors" name="contributors" value="<?php echo  $contributors; ?>">
				<span ><?php _e('Please add contributors seperated by comma(,).', 'wp-music'); ?></span>
			</div>
			
			<div class="field row">
				<label for="url"><?php _e('URL', 'wp-music'); ?></label>
				<input type="text" style="width:100%" id="url" name="url" value="<?php echo $url; ?>">
				<span ><?php _e('Please add music url.', 'wp-music'); ?></span>
			</div>
			
			<div class="field row even">
				<label for="price"><?php  _e('Price', 'wp-music'); ?></label>
				<input type="number" style="width:100%" id="price" name="price" value="<?php echo $price; ?>">
				<span ><?php _e('Please add music price.', 'wp-music'); ?></span>
			</div>
		</div>
		<?php
	}

	public function save_music_info_meta_box_data( $post_id ) {
		
		// Return if post type is not Music
		if ( isset( $_POST['post_type'] ) && 'music' != $_POST['post_type'] ) {
			return;
		}

		// Check if our nonce is set.
		if ( ! isset( $_POST['music_info_nonce'] ) ) {
			return;
		}
	
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['music_info_nonce'], 'music_info_nonce' ) ) {
			return;
		}
	
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'music' == $_POST['post_type'] ) {
	
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
	
		}
		else {
	
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		global $wpdb;
		$tablename = $wpdb->prefix. "music_meta";
	
		// Sanitize user input.
		$composer_name 	= sanitize_text_field( $_POST['composer_name'] );
		$publisher 		= sanitize_text_field( $_POST['publisher'] );
		$year_recording = sanitize_text_field( $_POST['year_recording'] );
		$contributors 	= sanitize_text_field( $_POST['contributors'] );
		$url 			= sanitize_text_field( $_POST['url'] );
		$price 			= sanitize_text_field( $_POST['price'] );


		$music_count = $wpdb->get_var( 
			$wpdb->prepare(
				"SELECT id 
				FROM $tablename WHERE music_id=%d",
				$post_id
			) 
		);
		
		
		if( NULL != $music_count && $music_count ){ 
			$wpdb->update( 
				$wpdb->prefix.'music_meta', 
				array(					
					'music_id' 			=> $post_id,
					'composer_name' 	=> $composer_name,
					'publisher' 		=> $publisher,
					'year_recording' 	=> $year_recording,
					'contributors' 		=> $contributors,
					'url' 				=> $url,
					'price' 			=> $price,
				),
				array(
					'id' 				=> $music_count
				)
			);
		}else{
			//echo "Music ".$music_count;
			//die;
			$wpdb->insert( 
				$wpdb->prefix.'music_meta', 
				array(
					'music_id' 			=> $post_id,
					'composer_name' 	=> $composer_name,
					'publisher' 		=> $publisher,
					'year_recording' 	=> $year_recording,
					'contributors' 		=> $contributors,
					'url' 				=> $url,
					'price' 			=> $price,
				)
			);
			//echo $wpdb->insert_id; die;
			
		}
	}
	/**
	 * Delete music meta on post delete
	 * 
	 * @author Sandip Baikare
	 * @since 1.0.1
	 */
	public function wpm_delete_music_meta( $post_id ){
		// return if post type is not music
		if ( get_post_type( $post_id ) != 'music' )
			return; 
		// check if user can delete post
		if( current_user_can('delete_post', $post_id) ){
			global $wpdb;
			$tablename = $wpdb->prefix . 'music_meta';
			$wpdb->delete( $tablename, array( 'music_id' => $post_id ), array( '%d' ) );
		}
	}

}

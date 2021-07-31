<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/baikaresandip
 * @since      1.0.0
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/public
 * @author     Baikare Sandip <baikare.sandeep007@gmail.com>
 */
class Wp_Music_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-music-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-music-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Create a music shortcode
	 * 
	 * Create a [music] shortcode to shoe the music on the pages
	 * 
	 * @author Sandip Baikare
	 * @since 1.0.0
	 */
	public function music_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'genre' => '',
			'year' => date('Y')
		), $atts );

		$output = '';

		
		global $post;
		$music_args = array(
			'post_type' 		=> 'music',
			'posts_per_page' 	=> 5,
			//'offset'         	=> 1				
		);

		if( isset( $atts['genre'] ) ){
			$music_args = array_merge(
				$music_args,
				array(
					'tax_query' => array(
							array(
								'taxonomy' => 'genre',
								'field'    => 'id',
								'terms'    => array( esc_attr( $atts['genre'] ) )
							)
						)
					)
				);
		}

		$musics = get_posts( $music_args ); 
		//print_r($music_args);
		
		$output.= '<div class="musics-wrapper">';
		if ( $musics ) {
			$view = wpm_get_option('music_view', 'list-view');
			$output.= '<div class="musics-list ' . $view . '">';
			foreach ( $musics as $music ) : 
				setup_postdata( $music );
				//$output.= print_r($music->ID, true);
				$output.= 	'<div class="music-item music-' . $music->ID . '">';
				$output.= 	'	<div class="image">
									<img class="music-thumb" src="'. get_the_post_thumbnail_url($music->ID, array(300, 300)).'" alt="'. get_the_title($music->ID).'" />
								</div>
								<div class="music-content">
									<h4><a class="music-link" href="'. get_the_permalink($music->ID).'">'. get_the_title($music->ID).'</a></h4>';									
								$output.= 	get_all_music_meta($music->ID);
								$output.= 	'</div>';
				$output.= 	'</div>';
			endforeach;

			wp_reset_postdata();

			$output.= '</div>';
		}else{
			$output.= '<p>'. __( 'No Musics founds.' ) .'</p>';
		}
		$output.= '</div>';

		return $output;
	}


	/**
	 * Append Music Meta to the Single Music Page
	 * 
	 * @author Sandip Baikare
	 * @since 1.0.0
	 */
	public function append_music_meta($content){
		if ( get_post_type( get_the_ID() ) == 'music'){
			$meta = get_all_music_meta( get_the_ID() );
			return $content . $meta; 
		}

		return $content; 
	}

}

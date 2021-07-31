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
	 * @param array 	$atts Shortcode Attributes
	 * @author Sandip Baikare
	 * @since 1.0.0
	 */
	public function music_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'genre' 		=> '',
			'hide_title' 	=> false,
			//'year' 			=> date('Y')
		), $atts );

		$output = $termname = '';
		
		global $post, $paged;
    	$music_per_page = wpm_get_option('per_page', 3);
		$music_args = array(
			'post_type' 		=> 'music',
			'order' 			=> 'ASC', 
			'paged' 			=> $paged,
			'showposts' 		=> $music_per_page, 				
		);

		if( intval( esc_attr( $atts['genre'] ) ) ){
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
			$termname = sprintf(' %s %s ', __('with Genre: ') , get_term( $atts['genre'] )->name);
		}
			
		$musics_query = new WP_Query( $music_args );	
		$total_found_posts = $musics_query->found_posts;
		$total_page = ceil($total_found_posts / $music_per_page);
		
		$output.= '<div class="musics-wrapper">';
			// Hide Title 
			if( ! $atts['hide_title'] ) 
				$output.= sprintf('<h2 class="musics-title">%s %s</h2>', __( 'Musics', 'wp-music' ), $termname);
				//$output.= '<h2 class="musics-title"> '. __( 'Musics', 'wp-music' )  . $termname . '</h2>';

		if ( $musics_query ) {
			$view = wpm_get_option('music_view', 'list-view');
			$output.= '<div class="musics-list ' . $view . '">';
			while($musics_query->have_posts()) : $musics_query->the_post();
				setup_postdata( $post );
				//$output.= print_r($music->ID, true);
				$output.= 	'<div class="music-item music-' . $post->ID . '">';
				$output.= 	'	<div class="image">
									<img class="music-thumb" src="'. get_the_post_thumbnail_url($post->ID, array(300, 300)).'" alt="'. get_the_title($post->ID).'" />
								</div>
								<div class="music-content">
									<h4><a class="music-link" href="'. get_the_permalink($post->ID).'">'. get_the_title($post->ID).'</a></h4>';									
								$output.= 	get_all_music_meta($post->ID);
								$output.= 	'</div>';
				$output.= 	'</div>';
			endwhile;

			$output.= '<div class="pagination">';
			$big = 999999999; // need an unlikely integer
			$output.= paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $musics_query->max_num_pages //$q is your custom query
			) );
			$output.= '</div>';

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
	 * @param string $content 	Post Content 
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

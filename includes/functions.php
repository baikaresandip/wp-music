<?php
/**
 * Get Currencies
 *
 * @since 1.0
 * @return array $currencies A list of the available currencies
 */
function wpm_get_currencies() {
	$currencies = array(
		'USD'  => __( 'US Dollars (&#36;)', 'wp-music' ),
		'EUR'  => __( 'Euros (&euro;)', 'wp-music' ),
		'GBP'  => __( 'Pound Sterling (&pound;)', 'wp-music' ),
		'AUD'  => __( 'Australian Dollars (&#36;)', 'wp-music' ),
		'BRL'  => __( 'Brazilian Real (R&#36;)', 'wp-music' ),
		'CAD'  => __( 'Canadian Dollars (&#36;)', 'wp-music' ),
		'CZK'  => __( 'Czech Koruna', 'wp-music' ),
		'DKK'  => __( 'Danish Krone', 'wp-music' ),
		'HKD'  => __( 'Hong Kong Dollar (&#36;)', 'wp-music' ),
		'HUF'  => __( 'Hungarian Forint', 'wp-music' ),
		'ILS'  => __( 'Israeli Shekel (&#8362;)', 'wp-music' ),
		'JPY'  => __( 'Japanese Yen (&yen;)', 'wp-music' ),
		'MYR'  => __( 'Malaysian Ringgits', 'wp-music' ),
		'MXN'  => __( 'Mexican Peso (&#36;)', 'wp-music' ),
		'NZD'  => __( 'New Zealand Dollar (&#36;)', 'wp-music' ),
		'NOK'  => __( 'Norwegian Krone', 'wp-music' ),
		'PHP'  => __( 'Philippine Pesos', 'wp-music' ),
		'PLN'  => __( 'Polish Zloty', 'wp-music' ),
		'SGD'  => __( 'Singapore Dollar (&#36;)', 'wp-music' ),
		'SEK'  => __( 'Swedish Krona', 'wp-music' ),
		'CHF'  => __( 'Swiss Franc', 'wp-music' ),
		'TWD'  => __( 'Taiwan New Dollars', 'wp-music' ),
		'THB'  => __( 'Thai Baht (&#3647;)', 'wp-music' ),
		'INR'  => __( 'Indian Rupee (&#8377;)', 'wp-music' ),
		'TRY'  => __( 'Turkish Lira (&#8378;)', 'wp-music' ),
		'RIAL' => __( 'Iranian Rial (&#65020;)', 'wp-music' ),
		'RUB'  => __( 'Russian Rubles', 'wp-music' ),
		'AOA'  => __( 'Angolan Kwanza', 'wp-music' ),
	);

	return apply_filters( 'wpm_currencies', $currencies );
}

/**
 * Get the store's set currency
 *
 * @since  1.0.0
 * @return string The currency code
 */
function wpm_get_currency() {
	$currency = wpm_get_option( 'currency', 'USD' );
	return apply_filters( 'wpm_currency', $currency );
}

/**
 * Given a currency determine the symbol to use. If no currency given, site default is used.
 * If no symbol is determine, the currency string is returned.
 *
 * @since   1.0.0
 * @param  string $currency The currency string
 * @return string           The symbol to use for the currency
 */
function wpm_currency_symbol( $currency = '' ) {
	if ( empty( $currency ) ) {
		$currency = wpm_get_currency();
	}

	switch ( $currency ) :
		case "GBP" :
			$symbol = '&pound;';
			break;
		case "BRL" :
			$symbol = 'R&#36;';
			break;
		case "EUR" :
			$symbol = '&euro;';
			break;
		case "USD" :
		case "AUD" :
		case "NZD" :
		case "CAD" :
		case "HKD" :
		case "MXN" :
		case "SGD" :
			$symbol = '&#36;';
			break;
		case "JPY" :
			$symbol = '&yen;';
			break;
		case "AOA" :
			$symbol = 'Kz';
			break;
		case "INR" :
			$symbol = '₹';
			break;
		default :
			$symbol = $currency;
			break;
	endswitch;

	return apply_filters( 'wpm_currency_symbol', $symbol, $currency );
}

/**
 * Get the name of a currency
 *
 * @since  1.0.0
 * @param  string $code The currency code
 * @return string The currency's name
 */
function wpm_get_currency_name( $code = 'INR' ) {
	$currencies = wpm_get_currencies();
	$name       = isset( $currencies[ $code ] ) ? $currencies[ $code ] : $code;
	return apply_filters( 'wpm_currency_name', $name );
}

/**
 * Get the Music setting field value
 *
 * @since 1.0.0
 * @param  string $name 		Name of the field
 * @param  string $default 		Default value
 * @return string The currency's name
 */
function wpm_get_option( $name, $default = '' ){
	$setting = get_option('wpm_wpmusic_basic_setting');
	if( isset($setting[$name]) )
		return $setting[$name];

	return $default;	
}

/**
 * Get the Music meta data by post id
 *
 * @since 1.0.0
 * @param  string 		$post_id 		Music Post ID
 * @return array|null 	$music_data		Return meta row if exist or null
 */

function get_music_meta_by_id( $post_id ){

	if( ! intval( $post_id ) )
		return null;

	global $wpdb;
	$music_meta = $wpdb->prefix . 'music_meta';	
	$music_data = $wpdb->get_row( "SELECT * FROM $music_meta WHERE music_id = $post_id", ARRAY_A  );
	return $music_data;
}

/**
 * Get music price with curreny
 * 
 * @param 	float 	$price	Price of music 	 
 * @author 	Sandip Baikare
 * @since 	1.0.0
 */
function get_price_with_currency( $price = 0 ){
	$currency = wpm_currency_symbol();	 
	return sprintf("%s %01.2f", $currency, $price);  
}

/**
 * Get music meta information
 * 
 * @param  int $music_id 	Music Post ID
 * @author Sandip Baikare
 * @since 1.0.0
 */
function get_all_music_meta( $music_id ){
	$output = '';	
	if ( ! $music_id )
		return $output;

	// Get all music meta
	$music_meta = get_music_meta_by_id( $music_id );
	if( is_array( $music_meta ) ){
		if(is_single( ) ){
			$output.= sprintf( "<h3>%s</h3>", __('Music Information: ', 'wp-music') );
		}
		$output.= 	'<ul class="music-meta">';
			$output.= 	'<li class="composer">';
				$output.= 	'<span class="mleft">';
					$output.= 	__('Composer Name: ', 'wp-music');
				$output.= 	'</span>';
				$output.= 	'<span class="mright">';
					$output.= 	esc_attr( $music_meta['composer_name'] );
				$output.= 	'</span>';
			$output.= 	'</li>';

			$output.= 	'<li class="composer">';
				$output.= 	'<span class="mleft">';
					$output.= 	__('Publisher: ', 'wp-music');
				$output.= 	'</span>';
				$output.= 	'<span class="mright">';
					$output.= 	esc_attr( $music_meta['publisher'] );
				$output.= 	'</span>';
			$output.= 	'</li>';

			$output.= 	'<li class="composer">';
				$output.= 	'<span class="mleft">';
					$output.= 	__('Year of Recording: ', 'wp-music');
				$output.= 	'</span>';
				$output.= 	'<span class="mright">';
					$output.= 	esc_attr( $music_meta['year_recording'] );
				$output.= 	'</span>';
			$output.= 	'</li>';

			$output.= 	'<li class="composer">';
				$output.= 	'<span class="mleft">';
					$output.= 	__('Publisher: ', 'wp-music');
				$output.= 	'</span>';
				$output.= 	'<span class="mright">';
					$output.= 	esc_attr( $music_meta['publisher'] );
				$output.= 	'</span>';
			$output.= 	'</li>';

			$output.= 	'<li class="composer">';
				$output.= 	'<span class="mleft">';
					$output.= 	__('Url: ', 'wp-music');
				$output.= 	'</span>';
				$output.= 	'<span class="mright">';
					$output.= '<a target="_blank" href="' . esc_attr( $music_meta['url'] ) . '">Open Music</a>';
				$output.= 	'</span>';
			$output.= 	'</li>';

			$output.= 	'<li class="composer">';
				$output.= 	'<span class="mleft">';
					$output.= 	__('Price: ', 'wp-music');
				$output.= 	'</span>';
				$output.= 	'<span class="mright">';
					$output.= 	get_price_with_currency( esc_attr( $music_meta['price'] ) );
				$output.= 	'</span>';
			$output.= 	'</li>';

			// Show Tags on List view and details page
			$view = wpm_get_option('music_view', 'list-view');
			if( 'list-view' == $view || is_single( ) ){
				$output.= 	'<li class="composer">';
					$output.= 	'<span class="mleft">';
						$output.= 	__('Genre: ', 'wp-music');
					$output.= 	'</span>';
					$tags = get_the_terms( $music_id, 'genre');

					//$output.= 	print_r( $tags, 1 );
					$output.= 	'<span class="mright">';
						if( !empty( $tags ) ){
							foreach ($tags as $key => $term) {
								$term_link = get_term_link( $term );
								$output.= '<span class="tag"><a href="' . esc_url( $term_link ) . '">' . $term->name . '</a></span>';
							}
						}
					$output.= 	'</span>';
				$output.= 	'</li>';
			}

			// Show Tags on List view and details page
			$view = wpm_get_option('music_view', 'list-view');
			if( 'list-view' == $view || is_single( ) ){
				$output.= 	'<li class="composer">';
					$output.= 	'<span class="mleft">';
						$output.= 	__('Tags: ', 'wp-music');
					$output.= 	'</span>';
					$tags = get_the_terms( $music_id, 'music-tags');

					//$output.= 	print_r( $tags, 1 );
					$output.= 	'<span class="mright">';
						if( !empty( $tags ) ){
							foreach ($tags as $key => $tag) {
								$output.= '<span class="tag">'. esc_attr( $tag->name ) . '</span>';
							}
						}
					$output.= 	'</span>';
				$output.= 	'</li>';
			}
														
		$output.= 	'</ul>';
		return $output;
		
	}

}
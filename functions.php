<?php
/**
 * ClassiPress child theme functions.
 *
 * BEFORE USING: Move the classiPress-child theme into the /themes/ folder.
 *
 * @package ClassiPress\Functions
 * @author  AppThemes
 * @since   ClassiPress 3.0
 */

/**
 * Registers the stylesheet for the child theme.
 */
function classipress_child_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_uri() );

	// Disable the ClassiPress default styles.
	//wp_dequeue_style( 'at-main' );

	// Disable the Foundation framework styles.
	//wp_dequeue_style( 'foundation' );
}
add_action( 'wp_enqueue_scripts', 'classipress_child_styles', 999 );

/**
 * Registers the scripts for the child theme.
 */
function classipress_child_scripts() {
	wp_enqueue_script( 'child-script', get_stylesheet_directory_uri() . '/general.js' );

	// Disable the ClassiPress default scripts.
	//wp_dequeue_script( 'theme-scripts' );

	// Disable the Foundation framework scripts.
	//wp_dequeue_script( 'foundation' );
	//wp_dequeue_script( 'foundation-motion-ui' );
}
add_action( 'wp_enqueue_scripts', 'classipress_child_scripts', 999 );

/**
 * This function migrates parent theme mods to the child theme.
 */
function classipress_child_assign_mods_on_activation() {

	if ( empty( get_theme_mod( 'migrated_from_parent' ) ) ) {
		$theme = get_option( 'stylesheet' );
		update_option( "theme_mods_$theme", get_option( 'theme_mods_classipress' ) );
		set_theme_mod( 'migrated_from_parent', 1 );
	}
}
add_action( 'after_switch_theme', 'classipress_child_assign_mods_on_activation' );

add_action( 'wp_enqueue_scripts', 'ad_tags_filters_ss' );

function ad_tags_filters_ss() {
	// absolutely need it, because we will get $wp_query->query_vars and $wp_query->max_num_pages from it.
	global $wp_query;

	// when you use wp_localize_script(), do not enqueue the target script immediately
	wp_register_script( 'filters_ss', get_stylesheet_directory_uri() . '/script.js', array('jquery') );

	// passing parameters here
	// actually the <script> tag will be created and the object "misha_loadmore_params" will be inside it
	wp_localize_script( 'filters_ss', 'misha_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => $wp_query->query_vars['paged'] ? $wp_query->query_vars['paged'] : 1,
		'max_page' => $wp_query->max_num_pages
	) );

	wp_enqueue_script( 'filters_ss' );
}


function ad_tags_filter(){
	$args = array(
		'orderby' => 'date',
		'post_type' => 'ad_listing',
		'posts_per_page' => -1
	);


//brand checkboxes
	if( $brands = get_terms( array( 'taxonomy' => 'ad_tag' ) ) ) :
		$all_terms = array();

		foreach( $brands as $brand ) {
			if( isset( $_POST['brand_' . $brand->term_id ] ) && $_POST['brand_' . $brand->term_id] == 'on' )
				$all_terms[] = $brand->slug;
		}

		if( count( $all_terms ) > 0 ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'ad_tag',
					'field' => 'slug',
					'terms'=> $all_terms
				)
			);
		}

	endif;
	$query = new WP_Query( $args );

	if( $query->have_posts() ) :
		while( $query->have_posts() ): $query->the_post();
			get_template_part( 'parts/content-item', get_post_type() );
		endwhile;
		wp_reset_postdata();
	else :
		echo 'No posts found';
	endif;
	die();
}
add_action('wp_ajax_myfilter', 'ad_tags_filter');
add_action('wp_ajax_nopriv_myfilter', 'ad_tags_filter');



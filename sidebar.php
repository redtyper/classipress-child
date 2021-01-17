<?php
/**
 * Generic Sidebar template.
 *
 * @package ClassiPress\Templates
 * @author  AppThemes
 * @since   ClassiPress 1.0
 */

global $cp_options;
?>

<div id="sidebar" class="m-large-3 columns" role="complementary">
    <div class="filters-cointainer">
    <form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
		<?php
		if ( $brands = get_terms( array( 'taxonomy' => 'ad_tag' ) ) ) :
            echo '<ul class="ajax-tags">';
			foreach ( $brands as $brand ) :
				echo '<li class="ajax-tags-item"><input type="checkbox" id="brand_' . $brand->term_id . '" name="brand_' . $brand->term_id . '" /><span class="check"></span><label for="brand_' . $brand->term_id . '">' . $brand->name . '</label></li>';
			endforeach;
			echo '</ul>';
		endif;
		?>
        <input type="hidden" name="action" value="myfilter">
    </form>
    </div>
	<?php appthemes_before_sidebar_widgets( 'main' ); ?>

	<?php appthemes_after_sidebar_widgets( 'main' ); ?>

</div><!-- #sidebar -->


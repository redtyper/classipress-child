<?php
/**
 * Custom listing loop content template.
 *
 * @package ClassiPress\Templates
 * @since 4.0.0
 */

$featured = cp_display_style( 'featured', false );
$id = get_the_id();
$title = get_the_title();
$title_link = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>', esc_url( get_permalink() ), esc_attr( $title ), $title );
$price = cp_get_price( $id, 'cp_price', false );
?>
<div class="column" >

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'listing-item', 'listing-map-data', 'content-wrap', 'display-grid' ) ); ?> <?php echo apply_filters( 'cp_listing_data_attributes', '', false ); ?> role="article">

	<div class="row">

		<div class="small-12 medium-grid columns">

			<a class="entry-thumbnail" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Thumbnail image for %s', APP_TD ), get_the_title() ) ); ?>" aria-hidden="true">
				<div <?php echo apply_filters( 'cp_background_cover', 'item-cover entry-cover', array( 'size' => 'large' ) ); ?>>
					<span class="screen-reader-text"><?php the_title(); ?></span>
				</div>
			</a>

		</div> <!-- .columns -->

		<div class="small-12 medium-grid columns">

			<div class="description_ad">
                <div class="category_ad">
                   <?php echo get_the_term_list( $post->ID, APP_TAX_CAT, '', ', ', '' ); ?>
                </div>
                <div class="title_ad">
                    <?php echo $title_link;?>
                </div>
                <div class="price_ad">
                   <?php if (!empty($price) && '&nbsp;' !== $price ) {
                   echo $price_link = '<span class="price_ad">Od '. $price.'</span>';
                    }?>
                </div>

			</div> <!-- .content-inner -->

		</div> <!-- .columns -->

	</div> <!-- .row -->

</article>
</div>
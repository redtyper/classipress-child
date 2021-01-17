<?php
/**
 * Template Name: Full Width Page
 *
 * @package ClassiPress\Templates
 * @author  AppThemes
 * @since   ClassiPress 1.0
 */
?>
<?php if ( get_theme_mod( 'front_page_hero', 1 ) ) { ?>

  <?php while ( have_posts() ) : the_post(); ?>

    <?php get_template_part( 'parts/hero', 'cover' );?>
				<?php the_content(); ?>

  <?php endwhile; ?>

<?php }


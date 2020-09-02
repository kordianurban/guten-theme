<?php
/**
 * Post listing view
 * HTML markup for listing with sidebar
 */

$args = get_query_var('args');
$items = get_query_var('items');
?>

<section class="widget post-listing <?php echo (!empty($args['blockPaddingTop']) ? $args['blockPaddingTop'] : '') . ' ' . (!empty($args['blockPaddingBottom']) ? $args['blockPaddingBottom'] : '') . ' ' . (!empty($args['blockOverlapTop']) && $args['blockOverlapTop'] ? 'overlap-top' : '') . ' ' . (!empty($args['blockOverlapBottom']) && $args['blockOverlapBottom'] ? 'overlap-bottom' : '' ) . ' ' . (!empty($args['blockDarkMode']) && $args['blockDarkMode'] ? 'dark-mode' : ''); ?>">
	<div class="container">
		<div class="row">

			<?php while( $items->have_posts() ): $items->the_post();

				get_template_part( 'views/postbox', $post->post_type );

			endwhile; ?>

		</div>
	</div>
</section>

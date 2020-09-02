<?php
namespace guten\gutenberg;

/**
 * Class PostListing
 * Custom Gutenberg block
 * showing list of posts with sidebar
 */
class PostListing {

	/**
	 * Blocks constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'registerBlock' ) );
	}

	/**
	 * Registering the dynamic blocks.
	 */
	public function registerBlock() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		register_block_type( 'guten/post-listing', [
			'render_callback' => array( $this, 'renderBlock' ),
		] );
	}

	/**
	 * Return the block HTML.
	 *
	 * @param array $args Array of arguments.
	 * @return string
	 */
	public function renderBlock( $args ) {
		global $post;

		ob_start();

		$items = new \WP_Query(array(
			'post_type' => 'post',
			'posts_per_page' => 5,
		));

		if ( $items->have_posts() ) {
			set_query_var( 'args', $args );
			set_query_var( 'items', $items );
			get_template_part('src/gutenberg/src/post-listing/view/post-listing');
		}

		wp_reset_postdata();

		$output = ob_get_clean();

		return $output;
	}

}

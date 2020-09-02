<?php
/**
 * Archive
 */

get_header(); ?>

    <section class="post-listing">
        <div class="container">
            <div class="row">
                <?php if ( have_posts() ):

                    while ( have_posts() ): the_post();
                        get_template_part( 'views/postbox', $post->post_type );
                    endwhile;

                else:

                    echo __('Nothing has been found.', 'guten');

                endif; ?>
            </div>

            <div class="pagination">
                <?php echo get_previous_posts_link( __('Previous articles', 'guten') ); ?>
                <?php echo get_next_posts_link( __('More articles', 'guten') ); ?>
            </div>
        </div>
    </section>

<?php get_footer();
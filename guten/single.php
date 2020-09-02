<?php get_header();

    while ( have_posts() ): the_post();
        get_template_part( 'views/single', $post->post_type );
    endwhile;

get_footer();
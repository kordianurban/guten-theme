<?php
/**
 * Default post box
 * Used for post listing (archives etc)
 */
?>

<div class="col-lg-4 col-md-6 col-sm-12">
    <article>
        <a href="<?php the_permalink(); ?>" class="thumb" <?php echo \guten\Theme::getThumbnailBg('medium', $post->ID); ?>></a>
        <time><?php echo get_the_date('Y.m.d', $post->ID); ?></time>
        <span><?php the_author(); ?></span>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php the_excerpt(); ?>
    </article>
</div>
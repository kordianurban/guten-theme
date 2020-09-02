<?php get_header(); ?>

    <section class="widget image-section dark-mode padding-top-large padding-bottom-large">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <h2><?php echo __( 'We are sorry!', 'guten' );?></h2>
                    <p>
                        <?php echo __( 'Error 404', 'guten' );?>, <br />
                        <?php echo __( 'Page you are looking for can not be found', 'guten' );?>. <br /><br />
                    </p>

                    <a class="btn" href="<?php echo home_url('/'); ?>">
                        <?php echo __( 'Back to Home page', 'guten' );?>
                    </a>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="thumb">
                        <img src="<?php echo \guten\Theme::asset('intro.jpg'); ?>" />
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php get_footer();

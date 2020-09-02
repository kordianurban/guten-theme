    </div><!-- #main -->

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <?php dynamic_sidebar('footer-column-1'); ?>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <?php dynamic_sidebar('footer-column-2'); ?>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <?php dynamic_sidebar('footer-column-3'); ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <?php dynamic_sidebar('footer-column-4'); ?>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <?php dynamic_sidebar('footer-column-5'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <?php dynamic_sidebar('footer-bottom-column-1'); ?>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <?php dynamic_sidebar('footer-bottom-column-2'); ?>
                </div>
            </div>
        </div>
    </footer>

<?php wp_footer(); ?>

</body>
</html>

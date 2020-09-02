<?php
namespace guten;

/**
 * Class Footer
 *
 * Contains footer setup
 * adds registrations
 *
 * @author Kordian Urban <kordianurban@gmail.com>
 */
class Footer {

    /**
     * Number of footer columns
     */
    const COLUMNS = 5;
    const COLUMNS_BOTTOM = 2;

	/**
	 * Initializes Footer
	 */
    public function __construct() {
        add_action( 'widgets_init', array($this, 'registerWidget') );
    }

    /**
     * Registers widget
     */
    public function registerWidget() {
        // columns
        for ( $i = 1; $i <= self::COLUMNS; $i++ ) {
            register_sidebar(array(
                'id' => 'footer-column-' . $i,
                'name' => __( 'Footer column ' . $i, 'guten' ),
                'before_widget' => '<div class="widget">',
                'after_widget' => '</div>',
                'before_title' => '<h5>',
                'after_title' => '</h5>',
            ));
        }

        // bottom columns
        for ( $i = 1; $i <= self::COLUMNS_BOTTOM; $i++ ) {
            register_sidebar(array(
                'id' => 'footer-bottom-column-' . $i,
                'name' => __( 'Footer bottom column ' . $i, 'guten' ),
                'before_widget' => '<div class="widget">',
                'after_widget' => '</div>',
                'before_title' => '<h5>',
                'after_title' => '</h5>',
            ));
        }
    }
}

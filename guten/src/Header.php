<?php
namespace guten;

/**
 * Class Header
 *
 * Contains header setup
 * adds registrations
 *
 * @author Kordian Urban <kordianurban@gmail.com>
 */
class Header {

	/**
	 * Initializes Header
	 */
    public function __construct() {
        add_action( 'widgets_init', array($this, 'registerWidget') );
    }

    /**
     * Registers widget area (sidebar)
     */
    public function registerWidget() {
        register_sidebar(array(
            'id' => 'header-sidebar',
            'name' => __( 'Header Sidebar', 'guten' ),
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => '',
        ));
    }
}

<?php
namespace guten;

/**
 * Class IntroPost
 *
 * Custom Gutenber block
 * showing intro section with selected post data
 *
 * @author Kordian Urban <kordianurban@gmail.com>
 */
class Gutenberg {

    /**
     * Initializes block
     */
    public function __construct() {
        add_action( 'enqueue_block_assets', array($this, 'registerAssets') );
        add_action( 'enqueue_block_editor_assets', array($this, 'registerBackendAssets') );
    }

    /**
     * Registers block assets
     */
    public function registerAssets() {
        wp_enqueue_style(
            'guten_gutenberg_style',
            get_template_directory_uri() . '/src/gutenberg/dist/blocks.build.css',
            array('wp-blocks')
        );
    }

    /**
     * Registers backend assets
     */
    public function registerBackendAssets() {
        wp_enqueue_script(
            'guten_gutenberg_editor',
            get_template_directory_uri() . '/src/gutenberg/dist/blocks.build.js',
            array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-api')
        );
    }


}

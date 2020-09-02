<?php

/**
 * Includes
 */
// Default theme functionalities
require_once 'src/Theme.php';
new \guten\Theme();

// Header functionaliteis
require_once 'src/Header.php';
new \guten\Header();

// Footer functionaliteis
require_once 'src/Footer.php';
new \guten\Footer();

// Gutenberg features
require_once 'src/Gutenberg.php';
new \guten\Gutenberg();


/**
 * Gutenberg blocks
 */
// Post listing widget
require_once 'src/gutenberg/src/post-listing/post-listing.php';
new \guten\gutenberg\PostListing();


/**
 * Nice dump
 * @param $variable
 */
function dump($variable) {
    echo '<pre>';
    print_r($variable);
    echo '</pre>';
}

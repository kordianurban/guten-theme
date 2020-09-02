<?php
namespace guten;

/**
 * Class Theme
 *
 * Contains full theme setup
 * adds registrations
 * removes unnecessary default functionalities
 * modifies default Wordpress output
 *
 * @author Kordian Urban <kordianurban@gmail.com>
 */
class Theme {

    const TEXT_DOMAIN = 'guten';
    const HELPER_INPUT = 'guten_helper_input';
    const HELPER_INPUT_VALUE = 'save';
    const NONCE = 'guten_nonce';

    /**
     * Titan Framework Instance
     * @var
     */
    public static $titan;

	/**
	 * Initializes Theme
	 */
    public function __construct() {
        $this->setupBackend();
        $this->setupFrontend();
        $this->setupLoginScreen();
    }

    /**
     * Setup backend
     * Register functionalities
     */
    public function setupBackend() {
        add_theme_support( 'post-thumbnails' );
        add_action( 'after_setup_theme', array($this, 'registerNavigation') );
        add_action( 'tf_create_options', array($this, 'initTitan') );

        add_action( 'admin_enqueue_scripts', array($this, 'registerBackendAssets') );

        add_filter( 'wp_targeted_link_rel', function( $rel, $link ) {
            return false;
        }, 10, 2 );
    }

    /**
     * Setup frontend functionalities
     * Register functionalities
     * Modify default HTML output
     */
    public function setupFrontend() {
        add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption',));
        add_filter( 'body_class', array($this, 'modifyBodyClass') );
        add_filter( 'nav_menu_css_class', array($this, 'modifySpecificNavClasses'), 10, 2 );
        add_action( 'wp_nav_menu', array($this, 'modifyNavClasses') );
        add_action( 'wp_list_pages', array($this, 'modifyNavClasses') );
        add_action( 'wp_list_categories', array($this, 'modifyNavClasses') );
        add_filter( 'the_content', array($this, 'disableImgAutoP') );
        add_filter( 'excerpt_more', array($this, 'customExcerptMore') );
        add_filter( 'excerpt_length', array($this, 'customExcerptLength'), 999);
        add_filter( 'wp_get_attachment_link', array($this, 'galleryMediaLink'), 10, 4 );
        add_action( 'init', array($this, 'disableEmoji') );

        add_action( 'wp_print_styles', array($this, 'removeCF7Styles'), 100 );
        add_action( 'wp_enqueue_scripts', array($this, 'registerAssets') );
    }

    /**
     * Initializes Titan Framework instance
     */
    public function initTitan() {
        self::$titan = \TitanFramework::getInstance(self::TEXT_DOMAIN);
    }

    /**
     * Enqueues Theme backend assets
     * Adds styles, scripts and localizing ajax
     */
    public function registerBackendAssets() {
        wp_enqueue_style( self::TEXT_DOMAIN . '-admin-style', get_template_directory_uri() . '/assets/css/admin-dist.css', array(), 'l1' );

        $current_screen = get_current_screen();
//
//        if ( (  $_GET['taxonomy'] == Services::TAXONOMY_CATEGORY && ( $current_screen->base == 'edit-tags' || $current_screen->base == 'term' ) ) ) {
//            wp_enqueue_style( self::TEXT_DOMAIN . '-admin-style', get_template_directory_uri() . '/assets/css/admin.css', array(), date('Ymd') . '123' );
//            wp_enqueue_script( self::TEXT_DOMAIN . '-admin-scripts', get_template_directory_uri() . '/assets/js/admin-scripts.js', array(), date('Ymd') . '123', true );
//        }
    }

	/**
     * Register navigation
     * Hook to after_setup_theme
     */
	public function registerNavigation() {
        register_nav_menus( array(
            'main' => esc_html__( 'Main menu', self::TEXT_DOMAIN ),
        ));
    }

    /**
     * Setup login screen
     * Adds default logo and backlink
     */
    public function setupLoginScreen() {
        add_action( 'login_enqueue_scripts', function() {
            echo '<style>
                #login h1 a, .login h1 a {
                    width: 100%;
                    height: 108px;
                    background-image: url('. get_stylesheet_directory_uri() . '/assets/images/logo-login.png);
                    background-size: contain;
                    background-position: center center;
                }
            </style>';
        });


        add_filter( 'login_headerurl', function() {
            return home_url();
        });
    }

    /**
     * Enqueues Theme assets
     * Adds styles, scripts and localizing ajax
     */
    public function registerAssets() {
        wp_enqueue_style( self::TEXT_DOMAIN . '-style', get_stylesheet_uri(), array(), date('Ymd') . 's2' );

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( self::TEXT_DOMAIN . '-plugins', get_template_directory_uri() . '/assets/js/vendor.js', array(), date('Ymd') . 's2', true );
        wp_enqueue_script( self::TEXT_DOMAIN . '-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), date('Ymd') . 's2', true );
        wp_localize_script( self::TEXT_DOMAIN . '-scripts', 'wpAjax', array(
            'url' => admin_url('admin-ajax.php'),
            //'nonce' => wp_create_nonce(self::NONCE),
        ));
    }

    /**
     * Disables Emoji
     */
    public function disableEmoji() {
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    }

    /**
     * Add filter to body class
     * Removes dfault classes and adds custom ones
     *
     * @param $classes default classes added by Wordpress
     * @return string $classes stripped classes
     */
    public function modifyBodyClass($classes) {
        global $post;

        if ( is_front_page() ) {
            $classes = array('page-home');
        }
        elseif ( is_404() ) {
            $classes = array('page-404');
        }
        elseif ( is_category() || is_tag() ) {
            $term = get_queried_object();
            $classes = array(
				'blog',
                'single-term',
                'term-' . $term->taxonomy,
                'term-' . $term->term_id
            );
        }

        elseif ( is_singular() ) {
            $classes = array(
                'single-' . $post->post_type,
                $post->post_type . '-' . $post->post_name
            );

//            if ( $post->post_type == 'post' ) {
//                if ( \guten\Theme::$titan->getOption(\guten\Posts::META_PROTECTED_FORM, $post->ID) ) {
//                    $classes[] = 'popup-active';
//                }
//            }
        }

        return array_unique($classes);
    }

    /**
     * Add filter to menu items classes
     * Modifies generated classes
     *
     * @param $classes default item classes
     * @param $item specific menu item
     * @return array modified item classes
     */
    public function modifySpecificNavClasses( $classes, $item ) {
        if ( ( !is_post_type_archive( 'post' ) && !is_singular( 'post' ) ) && $item->title == 'Blog' ) {
            $classes = array_diff( $classes, array( 'current_page_parent' ) );
        }

        return $classes;
    }

    /**
     * Add filter to navigation
     * Removes dfault classes and adds custom ones
     *
     * @param $content default classes added by Wordpress
     * @return string $content stripped classes
     */
    public function modifyNavClasses($content) {
        $pattern = '# class=(\'|")([-\w ]+)(\'|")#';
        preg_match_all($pattern, $content, $class_attrs);
        $num_class_attrs = (isset($class_attrs)) ? count($class_attrs[0]) : 0;

        $replace = array (
            'current' => 'active',
            'menu-item-has-children' => 'has-children'
        );

        for ($i = 0; $i < $num_class_attrs; $i++) {
            $classes = array();

            foreach ($replace as $old => $new) {
                if ( strpos($class_attrs[2][$i], $old) !== false ) {
                    $classes[] = $new;
                }
            }

            if (count($classes) > 0) {
                $content = preg_replace("#{$class_attrs[0][$i]}#", ' class="'. implode(' ', $classes) .'"', $content);
            }
            else {
                $content = preg_replace("#{$class_attrs[0][$i]}#", '', $content);
            }

            $content = preg_replace('/id="menu-item-\d+" /', '', $content);
        }

        return $content;
    }

    /**
     * Adds filter to the content
     * Disables auto wrapping images into p tag
     *
     * @param $content default Wordpress output
     * @return string $content stripped content
     */
    public function disableImgAutoP($content) {
        return preg_replace('/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $content);
    }

    /**
     * Get thumbnail background url
     *
     * @param int|void $post_id
     * @return string
     */
    public static function getThumbnailBg( $size = 'medium', $post_id = false ) {
        if ( !$post_id ) {
            global $post;
            $post_id = $post->ID;
        }

        $img = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $size );

        if ( !$img ) {
            $img = array(self::asset('logo-post.jpg'));
        }

        return 'style="background-image: url(\''. $img[0] .'\');"';
    }

    /**
     * Modify gallery image url
     * Changes default full size image to be large
     */
    public function galleryMediaLink( $content, $post_id, $size, $permalink ) {
        if (! $permalink) {
            $image = wp_get_attachment_image_src( $post_id, 'large' );
            $new_content = preg_replace('/href=\'(.*?)\'/', 'href=\'' . $image[0] . '\'', $content );
            return $new_content;
        } else {
            return $content;
        }
    }

    /**
     * Returns asset url of given filename
     *
     * @parem string $asset Name of the file to return its URL
     */
    public static function asset( $asset = '' ) {
        if ( strlen($asset) > 3 ) {
            $asset = get_template_directory_uri() . '/assets/images/' . $asset;
        }

        return $asset;
    }

    /**
     * Taxonomy helper
     * Saves custom term metadata
     */
    public function saveTermMeta( $term_id, $meta_names ) {
        if ( $_POST[self::HELPER_INPUT] == self::HELPER_INPUT_VALUE ) {
            foreach ( $meta_names as $meta_name ) {
                $meta_value  = get_term_meta( $term_id, $meta_name, true );
                $new_meta_value = isset( $_POST[$meta_name] ) ? $_POST[$meta_name] : ''; //sanitize_text_field

                if ( $meta_value && '' === $new_meta_value ) {
                    delete_term_meta( $term_id, $meta_name );
                }
                elseif ( $meta_value !== $new_meta_value ) {
                    update_term_meta( $term_id, $meta_name, $new_meta_value, $meta_value);
                }
            }
        }
    }

    /**
     * Removes CF7 default styles
     */
    public function removeCF7Styles() {
        wp_deregister_style('contact-form-7');
    }

    /**
     * Registers custom image sizes
     *
     */
    public function setupImageUploads() {
        add_image_size( 'customfull', 1600, 1600 );
        add_filter( 'wp_generate_attachment_metadata', array($this, 'modifyFullImageUpload') );
    }

    /**
     * Replaces Full image size with custom one
     *
     * @param $image_data
     * @return mixed
     */
    public function modifyFullImageUpload($image_data) {
        // if there is no large image : return
        if (!isset($image_data['sizes']['customfull'])) return $image_data;

        // paths to the uploaded image and the large image
        $upload_dir = wp_upload_dir();
        $uploaded_image_location = $upload_dir['basedir'] . '/' .$image_data['file'];

        $current_subdir = substr($image_data['file'],0,strrpos($image_data['file'],"/"));
        $large_image_location = $upload_dir['basedir'] . '/'.$current_subdir.'/'.$image_data['sizes']['customfull']['file'];

        // delete the uploaded image
        unlink($uploaded_image_location);

        // rename the large image
        rename($large_image_location,$uploaded_image_location);

        // update image metadata and return them
        $image_data['width'] = $image_data['sizes']['customfull']['width'];
        $image_data['height'] = $image_data['sizes']['customfull']['height'];
        unset($image_data['sizes']['customfull']);

        return $image_data;
    }

    /**
     * Pagination for WP_Query
     *
     * @param string $pages
     * @param int $range
     * @return string
     */
    public function pagination( $pages = '', $range = 5 ) {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $showitems = ($range * 2) + 1;

        if ($pages == '') {
            global $wp_query;

            $pages = $wp_query->max_num_pages;

            if(!$pages) {
                $pages = 1;
            }
        }

        if ( $pages != 1 ) {
            $html = '<ul class="widget pagination">';

            if ( $paged != 1 ) {
                $html .= '<li class="controls"><a href="'. get_pagenum_link(1) .'">&lsaquo;</a></li>';
            }

            for ($i=1; $i <= $pages; $i++) {
                if ( $pages != 1 && ( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ) ) {
                    if ($paged == $i):
                        $html .= '<li class="active"><a href="#">'. $i .'</a></li>';
                    else:
                        $html .= '<li><a href="'. get_pagenum_link($i) .'">'.$i.'</a></li>';
                    endif;
                }
            }

            if ( $paged != $pages ) {
                $html .= '<li class="controls"><a href="'. get_pagenum_link($pages) .'">&rsaquo;</a></li>';
            }

            $html .= "</ul>";
        }

        return $html;
    }

    /**
     * Modifies WP Uploader
     * adds support for additional mime types
     */
    public function uploadMimes( $mimes ) {
        $mimes['svg'] 	= 'image/svg+xml';
        $mimes['svgz'] 	= 'image/svg+xml';
		$mimes['jp2'] 	= 'image/jp2';
        return $mimes;
    }

    /**
     * Gets Titan Framework Image
     *
     * @return string
     */
    public function getImageURL( $metavalue, $post_id ) {
        $imageID = self::$titan->getOption( $metavalue, $post_id);

        if ( is_numeric( $imageID ) ) {
            $imageAttachment = wp_get_attachment_image_src( $imageID );
            $imageURL = $imageAttachment[0];
        }

        return $imageURL;
    }

    /**
     * Custom Excerpt Length
     * @param $length
     * @return int
     */
    public function customExcerptLength( $length ) {
        return 20;
    }

    /**
     * Change the excerpt more string
     * @return string
     */
    public function customExcerptMore( $more ) {
        return ' ...';
    }
}

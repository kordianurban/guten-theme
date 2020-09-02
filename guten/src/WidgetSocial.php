<?php
namespace guten;

/**
 * Class WidgetSocial
 * custom widget to display button
 * usable in WP Widgets area
 *
 * @author Kordian Urban <kordianurban@gmail.com>
 */
class WidgetSocial extends \WP_Widget {

    /**
     * Default widget arguments
     * @var array
     */
    public $args = array(
        'before_title'  => '',
        'after_title'   => '',
        'before_widget' => '',
        'after_widget'  => ''
    );

    /**
     * List of available social media links
     * @var array
     */
    public $socials = array(
        'facebook', 'linkedin', 'twitter', 'm'
    );

    /**
     * Initializes Widget
     */
    function __construct() {
        parent::__construct(
            'guten-widget-social',
            __('Social media', 'guten'),
            array('description' => __( 'Social media links.', 'guten' ))
        );

        add_action( 'widgets_init', function() {
            register_widget( $this );
        });
    }

    /**
     * Displays widget
     *
     * @param $args
     * @param $instance
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget']; ?>

        <ul class="social-widget">
            <?php foreach ( $this->socials as $social ):
                if ( !empty($instance[$social]) ): ?>
                    <li><a href="<?php echo esc_url_raw($instance[$social]); ?>"><?php echo file_get_contents(\guten\Theme::asset('icon-'. $social .'.svg')); ?></a></li>
                <?php endif;
            endforeach; ?>
        </ul>

        <?php echo $args['after_widget'];
    }

    /**
     * Displays widget form
     *
     * @param $instance
     */
    public function form( $instance ) {
        foreach ( $this->socials as $social ) {
            ${$social} = ( !empty( $instance[$social] ) ? $instance[$social] : '' );

            ?>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( $social ) ); ?>"><?php echo esc_html__( ucfirst($social) . ':', 'guten' ); ?></label>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $social ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $social ) ); ?>" type="text" value="<?php echo esc_attr( ${$social} ); ?>">
                </p>
            <?php
        }
    }

    /**
     * Updates widget
     *
     * @param $new_instance
     * @param $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();

        foreach ( $this->socials as $social ) {
            $instance[$social] = ( !empty($new_instance[$social]) ? $new_instance[$social] : '' );
        }

        return $instance;
    }

}
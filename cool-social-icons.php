<?php
/*
Plugin Name: Cool Social Icons Widget
Plugin URI: http://wordpress.org/plugins/cool-social-icons/
Description: This plugin allows you to insert cool social icons in widget area with dark and light color scheme according to your site. for setting http://youtu.be/iAMIsQdUWQc
Author: Kamal Saroya Mr-Koder
Author URI: http://mr-koder.blogspot.com/

Version: 1.0

License: GNU General Public License v2.0 (or later)
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

class cool_social_Icons_Widget extends WP_Widget {

	/**
	 * Default widget values.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Default widget values.
	 *
	 * @var array
	 */
	protected $sizes;

	/**
	 * Default widget profile glyphs.
	 *
	 * @var array
	 */
	protected $glyphs;

	/**
	 * Default widget profile values.
	 *
	 * @var array
	 */
	protected $profiles;

	/**
	 * Constructor method.
	 *
	 * Set some global values and create widget.
	 */
	function __construct() {
		$this->profiles = apply_filters( 'cool_social_default_profiles', array(
			'facebook' => array(
				'label'   => __( 'Facebook URI', 'csi' ),
				'pattern' => '<li class="social-facebook"><a href="%s" target="_blank" %s>' . $this->glyphs['facebook'] . '</a></li>',
			),
			'twitter' => array(
				'label'   => __( 'Twitter URI', 'csi' ),
				'pattern' => '<li class="social-twitter"><a href="%s" target="_blank" %s>' . $this->glyphs['twitter'] . '</a></li>',
			),
			'youtube' => array(
				'label'   => __( 'YouTube URI', 'csi' ),
				'pattern' => '<li class="social-youtube"><a href="%s" target="_blank" %s>' . $this->glyphs['youtube'] . '</a></li>',
			),
			'gplus' => array(
				'label'   => __( 'Google+ URI', 'csi' ),
				'pattern' => '<li class="social-gplus"><a href="%s" target="_blank" %s>' . $this->glyphs['gplus'] . '</a></li>',
			),
			'flickr' => array(
				'label'   => __( 'Flickr URI', 'csi' ),
				'pattern' => '<li class="social-flickr"><a href="%s" target="_blank" %s>' . $this->glyphs['flickr'] . '</a></li>',
			),
			//'email' => array(
			//	'label'   => __( 'Email URI', 'csi' ),
			//	'pattern' => '<li class="social-email"><a href="%s" target="_blank" %s>' . $this->glyphs['email'] . '</a></li>',
			//),
			'instagram' => array(
				'label'   => __( 'Instagram URI', 'csi' ),
				'pattern' => '<li class="social-instagram"><a href="%s" target="_blank" %s>' . $this->glyphs['instagram'] . '</a></li>',
			),
			'linkedin' => array(
				'label'   => __( 'Linkedin URI', 'csi' ),
				'pattern' => '<li class="social-linkedin"><a href="%s" target="_blank" %s>' . $this->glyphs['linkedin'] . '</a></li>',
			),
			'pinterest' => array(
				'label'   => __( 'Pinterest URI', 'csi' ),
				'pattern' => '<li class="social-pinterest"><a href="%s" target="_blank" %s>' . $this->glyphs['pinterest'] . '</a></li>',
			),
			'rss' => array(
				'label'   => __( 'RSS URI', 'csi' ),
				'pattern' => '<li class="social-rss"><a href="%s" target="_blank" %s>' . $this->glyphs['rss'] . '</a></li>',
			),
			'myspace' => array(
				'label'   => __( 'myspace URI', 'csi' ),
				'pattern' => '<li class="social-myspace"><a href="%s" target="_blank" %s>' . $this->glyphs['myspace'] . '</a></li>',
			),
			'tumblr' => array(
				'label'   => __( 'Tumblr URI', 'csi' ),
				'pattern' => '<li class="social-tumblr"><a href="%s" target="_blank" %s>' . $this->glyphs['tumblr'] . '</a></li>',
			),
		) );

		$widget_ops = array(
			'classname'   => 'cool-social-icons',
			'description' => __( 'Displays select social icons with cool social icons by Mr-Koder', 'csi' ),
		);

		$control_ops = array(
			'id_base' => 'cool-social-icons',
		);

		$this->WP_Widget( 'cool-social-icons', __( 'Cool Social Icons', 'csi' ), $widget_ops, $control_ops );

		/** Enqueue icon font */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ) );

		/** Load CSS in <head> */
	

	}
		
	/**
	 * Widget Form.
	 *
	 * Outputs the widget form that allows users to control the output of the widget.
	 *
	 */
	function form( $instance ) {
		
		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$all_instances = $this->get_settings();
		$instance = wp_parse_args( $all_instances[$this->number], $this->defaults );
		?>

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>
		<hr style="background: #ccc; border: 0; height: 1px;;" />
		<div align="center" id="footer-thankyou"> Cool Social Icons <a href="http://mr-koder.blogspot.com" target="_blank">Mr-Koder</a> Project</div>
		
		<?php  $scheme=esc_attr( $instance['scheme'] ); ?>
		<p><label for="<?php echo $this->get_field_id( 'scheme' ); ?>"><?php _e( 'Color Scheme:', 'csi' ); ?></label> 
        <select id="<?php echo $this->get_field_id( 'scheme' ); ?>" name="<?php echo $this->get_field_name( 'scheme' ); ?>">
        <? if($scheme=="dark"): ?>
        <option value="dark" selected="selected">Dark</option>
        <option value="light">Light</option>
        <? else: ?>
        <option value="light" selected="selected">Light</option>
        <option value="dark">Dark</option>
        <? endif; ?>
       </select>
 
        </p>

		<hr style="background: #ccc; border: 0; height: 1px; margin: 20px 0;" />

		<?php
		foreach ( (array) $this->profiles as $profile => $data ) {

			printf( '<p><label for="%s">%s:</label></p>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $data['label'] ) );
			printf( '<p><input type="text" id="%s" name="%s" value="%s" class="widefat" />', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $this->get_field_name( $profile ) ), esc_url( $instance[$profile] ) );
			printf( '</p>' );

		}

	}

	/**
	 * Form validation and sanitization.
	 *
	 * Runs when you save the widget form. Allows you to validate or sanitize widget options before they are saved.
	 *
	 */
	function update( $newinstance, $oldinstance ) {

		foreach ( $newinstance as $key => $value ) {

			/** Border radius and Icon size must not be empty, must be a digit */
			if ( ( 'border_radius' == $key || 'size' == $key ) && ( '' == $value || ! ctype_digit( $value ) ) ) {
				$newinstance[$key] = 0;
			}

			/** Validate hex code colors */
			elseif ( strpos( $key, '_color' ) && 0 == preg_match( '/^#(([a-fA-F0-9]{3}$)|([a-fA-F0-9]{6}$))/', $value ) ) {
				$newinstance[$key] = $oldinstance[$key];
			}

			/** Sanitize Profile URIs */
			elseif ( array_key_exists( $key, (array) $this->profiles ) ) {
				$newinstance[$key] = esc_url( $newinstance[$key] );
			}

		}

		return $newinstance;

	}

	/**
	 * Widget Output.
	 *
	 * Outputs the actual widget on the front-end based on the widget options the user selected.
	 *
	 */
	function widget( $args, $instance ) {

		extract( $args );

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );
	
		echo $before_widget;

			if ( ! empty( $instance['title'] ) )
				echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

			$output = '';

			$new_window = $instance['new_window'] ? 'target="_blank"' : '';

			$profiles = (array) $this->profiles;

			foreach ( $profiles as $profile => $data ) {

				if ( empty( $instance[ $profile ] ) )
					continue;

				if ( is_email( $instance[ $profile ] ) )
					$output .= sprintf( $data['pattern'], 'mailto:' . esc_attr( $instance[$profile] ), $new_window );
				else
					$output .= sprintf( $data['pattern'], esc_url( $instance[$profile] ), $new_window );

			}

		


		if ( $output )
				printf( '<ul id="cool-social" class="%s">%s</ul>', $instance['alignment'], $output );

		echo $after_widget;

	}

	function enqueue_css() {
$instance = wp_parse_args( (array) $instance, $this->defaults );
		$all_instances = $this->get_settings();
		$instance = wp_parse_args( $all_instances[$this->number], $this->defaults );
		$show = esc_attr( $instance['scheme'] );
if($show=="dark"):
$cssfile	= apply_filters( 'cool_social_default_css', plugin_dir_url( __FILE__ ) . 'css/style-dark.css?'.$show );
else:
$cssfile	= apply_filters( 'cool_social_default_css', plugin_dir_url( __FILE__ ) . 'css/style.css?'.$show );
endif;
		wp_enqueue_style( 'cool-social-icons-font', esc_url( $cssfile ), array(), '1.0.5', 'all' );
	}

}

add_action( 'widgets_init', 'csi_load_widget' );
/**
 * Widget Registration.
 *
 * Register Simple Social Icons widget.
 *
 */
function csi_load_widget() {

	register_widget( 'cool_social_Icons_Widget' );

}
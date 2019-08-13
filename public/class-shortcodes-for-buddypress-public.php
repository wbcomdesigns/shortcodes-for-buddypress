<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wbcomdesigns.com/plugins
 * @since      1.0.0
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/public
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Shortcodes_For_Buddypress_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Shortcodes_For_Buddypress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Shortcodes_For_Buddypress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/shortcodes-for-buddypress-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Shortcodes_For_Buddypress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Shortcodes_For_Buddypress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/shortcodes-for-buddypress-public.js', array( 'jquery' ), $this->version, false );

	}
	
	public function buddypress_shortcodes_bp_is_current_component( $current_component ) {
		global $post;
		if( isset($post->post_content) && ( has_shortcode( $post->post_content, 'activity-listing' ) ) ) {
			$current_component = 'activity';
		}
		return $current_component;
	}
	
	public function buddypress_shortcodes_body_classes( $classes ) {
		global $post;

		if( isset($post->post_content) && ( has_shortcode( $post->post_content, 'activity-listing' ) || has_shortcode( $post->post_content, 'members-listing' ) || has_shortcode( $post->post_content, 'groups-listing' ) ) ) {
			$classes[] = 'bpsh-buddypress';
			$classes[] = 'buddypress';			
		}
		
        return $classes;
		
	}
	
	/**
	 * Include EDD sell services template file.
	 *
	 * @since    1.0.0
	 */
	public function buddypress_shortcodes_template( $file_name ) {
		
		$template_name ='shortcodes-for-buddypress/' . $file_name;
		
		if ( file_exists( STYLESHEETPATH . '/' . $template_name ) ) {
			
			include STYLESHEETPATH . '/' . $template_name;
			
		} elseif ( file_exists( TEMPLATEPATH . '/' . $template_name ) ) {
			
			include TEMPLATEPATH . '/' . $template_name;
			
		} else {
			
			include SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR . 'templates/' . $file_name;
		}
	}
	
	
	/**
	 * Call BuddyPress Activity Listing shortcode
	 *
	 * @since    1.0.0
	 */
	public function buddypress_shortcodes_activity_listing( $atts, $content = null ) {
		global $activity_atts;
		$bpsh_query = build_query($atts);
		if (!empty($bpsh_query)) {
            $bpsh_query = '&' . $bpsh_query;
        }		
		$default_atts = array(
						'title' 			=> '', //title of the section
						'display_comments' 	=> 'threaded',
						'include' 			=> false, // pass an activity_id or string of IDs comma-separated
						'exclude' 			=> false, // pass an activity_id or string of IDs comma-separated
						'in' 				=> false, // comma-separated list or array of activity IDs among which to search
						'sort' 				=> 'DESC', // sort DESC or ASC
						'page' 				=> 1, // which page to load
						'per_page' 			=> 5, //how many per page
						'max' 				=> false, // max number to return
						'count_total' 		=> true,
						'scope' 			=> false,
						// Filtering
						'user_id' 			=> false, // user_id to filter on
						'object' 			=> false, // object to filter on e.g. groups, profile, status, friends
						'action' 			=> false, // action to filter on e.g. activity_update, new_forum_post, profile_updated
						'primary_id' 		=> false, // object ID to filter on e.g. a group_id or forum_id or blog_id etc.
						'secondary_id' 		=> false, // secondary object ID to filter on e.g. a post_id
						// Searching
						'search_terms' 		=> false, // specify terms to search on
						'use_compat' 		=> bp_use_theme_compat_with_current_theme(),
						'allow_posting' 	=> true, //experimental, some of the themes may not support it.
						'container_class' 	=> 'activity', //default container,
						'hide_on_activity' 	=> 1, //hide on user and group activity pages
						'bpsh_query'		=> $bpsh_query
				);
		
		$activity_atts = shortcode_atts( $default_atts, $atts );		
		extract($activity_atts);
		
		if ( $atts['hide_on_activity'] && ( function_exists('bp_is_activity_component') && bp_is_activity_component() ||
                function_exists('bp_is_group_home') && bp_is_group_home() )) {
            return '';
        }			
			
		ob_start();
		
		if (function_exists('bp_is_active')) {
			
			if ( $title != '' ) { ?> 
                <h3 class="section-title"><span><?php echo esc_html($title); ?></span></h3>
                <?php
            }
			$this->buddypress_shortcodes_template( 'activity/bp-shortcodes-activity.php' );
        }
		
		return ob_get_clean(); 
	}
	
	/**
	 * Call BuddyPress Members Listing shortcode
	 *
	 * @since    1.0.0
	 */
	public function buddypress_shortcodes_members_listing( $atts, $content = null ) {
		
		
		$atts = shortcode_atts( $default_atts, $atts );
		extract($atts);
		ob_start();
		
		return ob_get_clean(); 
	}
	
	
	/**
	 * Call BuddyPress Group Listing shortcode
	 *
	 * @since    1.0.0
	 */
	public function buddypress_shortcodes_group_listing( $atts, $content = null ) {
		
		
		$atts = shortcode_atts( $default_atts, $atts );
		extract($atts);
		
		ob_start();
		
		return ob_get_clean(); 
	}

}

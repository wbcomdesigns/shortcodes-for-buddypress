<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Bp_Shortcodes
 * @subpackage Bp_Shortcodes/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bp_Shortcodes
 * @subpackage Bp_Shortcodes/admin
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Bp_Shortcodes_Admin {

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Bp_Shortcodes_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Bp_Shortcodes_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/bp-shortcodes-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Bp_Shortcodes_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Bp_Shortcodes_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/bp-shortcodes-admin.js', array('jquery'), $this->version, false);
    }

    public function bpsh_add_option_page() {
        add_submenu_page('options-general.php', __('BP Shortcodes', $this->plugin_name), __('BP Shortcodes', $this->plugin_name), 'manage_options', 'bpsh-shortcodes', array($this, 'bpsh_add_page_callback'));
    }

    public function bpsh_add_page_callback() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/templates/bp-shortcodes-template.php';
    }

    public function bpsh_generate_activity_listing($atts, $content = null) {

        //allow to use all those args awesome!
        $atts = shortcode_atts(array(
            'title' => 'Latest Activity', //title of the section
            'pagination' => 1, //show or not
            'load_more' => 0,
            'display_comments' => 'threaded',
            'include' => false, // pass an activity_id or string of IDs comma-separated
            'exclude' => false, // pass an activity_id or string of IDs comma-separated
            'in' => false, // comma-separated list or array of activity IDs among which to search
            'sort' => 'DESC', // sort DESC or ASC
            'page' => 1, // which page to load
            'per_page' => 5, //how many per page
            'max' => false, // max number to return
            'count_total' => true,
            // Scope - pre-built activity filters for a user (friends/groups/favorites/mentions)
            'scope' => false,
            // Filtering
            'user_id' => false, // user_id to filter on
            'object' => false, // object to filter on e.g. groups, profile, status, friends
            'action' => false, // action to filter on e.g. activity_update, new_forum_post, profile_updated
            'primary_id' => false, // object ID to filter on e.g. a group_id or forum_id or blog_id etc.
            'secondary_id' => false, // secondary object ID to filter on e.g. a post_id
            // Searching
            'search_terms' => false, // specify terms to search on
            'use_compat' => bp_use_theme_compat_with_current_theme(),
            'allow_posting' => false, //experimental, some of the themes may not support it.
            'container_class' => 'activity', //default container,
            'hide_on_activity' => 1, //hide on user and group activity pages
                ), $atts);

        //hide on user activity, activity directory and group activity
        if ($atts['hide_on_activity'] && ( function_exists('bp_is_activity_component') && bp_is_activity_component() ||
                function_exists('bp_is_group_home') && bp_is_group_home() )) {
            return '';
        }

        //start buffering
        ob_start();
        ?>

        <?php if ($atts['use_compat']) : ?>
            <div id="buddypress">
            <?php endif; ?>

            <?php if ($atts['title']) : ?>
                <h3 class="activity-shortcode-title"><?php echo $atts['title']; ?></h3>
            <?php endif; ?>

            <?php do_action('bp_before_activity_loop'); ?>

            <?php if ($atts['allow_posting'] && is_user_logged_in()) : ?>
                <?php bp_locate_template(array('activity/post-form.php'), true); ?>
            <?php endif; ?>

            <?php if (bp_has_activities($atts)) : ?>

                <div class="<?php echo esc_attr($atts['container_class']); ?> <?php if (!$atts['display_comments']) : ?> hide-activity-comments<?php endif; ?> shortcode-activity-stream">

                    <?php if (empty($_POST['page'])) : ?>
                        <ul id="activity-stream" class="activity-list item-list">
                        <?php endif; ?>

                        <?php while (bp_activities()) : bp_the_activity(); ?>
                            <?php bp_get_template_part('activity/entry'); ?>
                        <?php endwhile; ?>

                        <?php if ($atts['load_more'] && bp_activity_has_more_items()) : ?>
                            <li class="load-more">
                                <a href="<?php bp_activity_load_more_link() ?>"><?php _e('Load More', 'buddypress'); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if (empty($_POST['page'])) : ?>
                        </ul>
                    <?php endif; ?>

                    <?php if ($atts['pagination'] && !$atts['load_more']) : ?>
                        <div class="pagination">
                            <div class="pag-count"><?php bp_activity_pagination_count(); ?></div>
                            <div class="pagination-links"><?php bp_activity_pagination_links(); ?></div>
                        </div>
                    <?php endif; ?>

                </div>

            <?php else : ?>
                <div id="message" class="info">
                    <p><?php _e('Sorry, there was no activity found. Please try a different filter.', 'buddypress'); ?></p>
                </div>
            <?php endif; ?>

            <?php do_action('bp_after_activity_loop'); ?>

            <form action="" name="activity-loop-form" id="activity-loop-form" method="post">
                <?php wp_nonce_field('activity_filter', '_wpnonce_activity_filter'); ?>
            </form>

            <?php if ($atts['use_compat']) : ?>
            </div>
        <?php endif; ?>

        <?php
        $output = ob_get_clean();

        return $output;
    }

}

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
        wp_localize_script($this->plugin_name, 'bpsh_ajax_obj', array('ajaxurl' => admin_url('admin-ajax.php')));
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
            'user_id' => 47, // user_id to filter on
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
        ?>

        <?php if ($atts['use_compat']) : ?>
            <div id="buddypress">
                <?php
            endif;
            require_once plugin_dir_path(dirname(__FILE__)) . 'includes/templates/activity/bp-shortcodes-activity-loop.php';
            if ($atts['use_compat']) :
                ?>
            </div>
            <?php
        endif;
    }

    public function bpsh_generate_members_listing($atts, $content = null) {
        $atts = shortcode_atts(array(
            'type' => 'active', // active, popular,online
            'page' => 1,
            'per_page' => 20,
            'max' => false,
            'page_arg' => 'upage', // See https://buddypress.trac.wordpress.org/ticket/3679.
            'include' => false, // Pass a user_id or a list (comma-separated or array) of user_ids to only show these users.
            'exclude' => false, // Pass a user_id or a list (comma-separated or array) of user_ids to exclude these users.
            'user_id' => 1, // Pass a user_id to only show friends of this user.
            'member_type' => false, // Can be a comma-separated list.
            'member_type__in' => '',
            'member_type__not_in' => '',
            'search_terms' => false,
            'use_compat' => bp_use_theme_compat_with_current_theme(),
            'meta_key' => false, // Only return users with this usermeta.
            'meta_value' => false, // Only return users where the usermeta value matches. Requires meta_key.
            'populate_extras' => true      // Fetch usermeta? Friend count, last active etc.
                ), $atts);

        if (function_exists('bp_is_active')) {
            ?>  
            <?php if ($atts['title']) { ?> 
                <h3 class="section-title"><span><?php echo $atts['title']; ?></span></h3>
                <?php
            }
            require_once plugin_dir_path(dirname(__FILE__)) . 'includes/templates/members/bp-shortcodes-members.php';
        }
        ?>
        <div class="clearfix"></div>
        <?php
    }

    public function bpsh_generate_group_listing($atts, $content = null) {
        $sliderrandomid = rand();
        $atts = shortcode_atts(array(
            'type' => 'alphabetical', //popular, alphabetical, invites, single-group
            'order' => 'DESC',
            'orderby' => 'last_activity',
            'page' => 1,
            'per_page' => 20,
            'max' => false,
            'show_hidden' => false,
            'page_arg' => 'grpage',
            'user_id' => false,
            'slug' => false,
            'search_terms' => false,
            'group_type' => false,
            'group_type__in' => '',
            'group_type__not_in' => '',
            'meta_query' => false,
            'use_compat' => bp_use_theme_compat_with_current_theme(),
            'include' => false,
            'exclude' => false,
            'parent_id' => null,
            'update_meta_cache' => true,
            'update_admin_cache' => bp_is_groups_directory() || bp_is_user_groups(),
                ), $atts);
        if ($atts['use_compat']) :
            ?>
            <div id="buddypress">
                <?php
            endif;
            ?>
            <?php if (function_exists('bp_is_active')) { ?>  
                <?php if ($atts['title']) { ?> 
                    <h3 class="section-title"><span><?php echo $atts['title'] ?></span></h3>
                    <?php
                }
                require_once plugin_dir_path(dirname(__FILE__)) . 'includes/templates/groups/bp-shortcodes-groups-loop.php';
            }

            if ($atts['use_compat']) :
                ?>
            </div>
            <?php
        endif;
        ?>
        <div class="clearfix"></div>
        <?php
    }

    function bpsh_bp_dtheme_ajax_querystring($query_string, $object) {

        /* Now pass the querystring to override default values. */
        $query_string .= '&type=active&action=active&include=' . $list_of_members . '&page=1';

        return $query_string;
    }

    function bpsh_members_filter() {
        add_filter('bp_dtheme_ajax_querystring', 'bpsh_bp_dtheme_ajax_querystring', 11, 2);
    }

}

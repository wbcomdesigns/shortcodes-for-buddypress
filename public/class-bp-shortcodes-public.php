<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Bp_Shortcodes
 * @subpackage Bp_Shortcodes/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bp_Shortcodes
 * @subpackage Bp_Shortcodes/public
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Bp_Shortcodes_Public {

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
    public function __construct($plugin_name, $version) {

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
         * defined in Bp_Shortcodes_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Bp_Shortcodes_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/bp-shortcodes-public.css', array(), $this->version, 'all');
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
         * defined in Bp_Shortcodes_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Bp_Shortcodes_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/bp-shortcodes-public.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name, 'bpsh_ajax_obj', array('ajaxurl' => admin_url('admin-ajax.php')));
    }

    /**
     * Load the template loop for the current object.
     *
     * @return string Prints template loop for the specified object
     * @since 1.0.0
     */
    public function bpsh_legacy_theme_object_template_loader() {

        // Bail if not a POST action.
        if ('POST' !== strtoupper($_SERVER['REQUEST_METHOD']))
            return;

        // Bail if no object passed.
        if (empty($_POST['object']))
            return;

        // Sanitize the object.
        $object = sanitize_title($_POST['object']);

        // Bail if object is not an active component to prevent arbitrary file inclusion.
        if (!bp_is_active($object))
            return;

        /**
         * AJAX requests happen too early to be seen by bp_update_is_directory()
         * so we do it manually here to ensure templates load with the correct
         * context. Without this check, templates will load the 'single' version
         * of themselves rather than the directory version.
         */
        if (!bp_current_action())
            bp_update_is_directory(true, bp_current_component());

//        if (!$object === 'members') {
//            setcookie('bp-members-filter', ' ');
//            setcookie('bp-members-scope', ' ');
//        }
        add_filter('bp_ajax_querystring', function($qs) {
            return $qs .= get_option('bpsh_queryargs');
        });

        $template_part = $object . '/' . $object . '-loop';

        // The template part can be overridden by the calling JS function.
        if (!empty($_POST['template'])) {
            $template_part = sanitize_option('upload_path', $_POST['template']);
        }
//        // Locate the object template.
        bp_get_template_part($template_part);

        exit();
    }
}

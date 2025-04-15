<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wbcomdesigns.com/plugins
 * @since      1.0.0
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/admin
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Shortcodes_For_Buddypress_Admin {

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
	 * The settings of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_settings_tabs    Settings array of this plugin.
	 */
	private $plugin_settings_tabs;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * This function enqueues the plugin-specific admin stylesheet only
	 * on the appropriate admin pages to avoid unnecessary loading elsewhere.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook The current admin page hook suffix.
	 */
	public function enqueue_styles( $hook ) {

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
		$shortcode_style = filter_input( INPUT_GET, 'page' ) ? filter_input( INPUT_GET, 'page' ) : '';
		if ( 'wb-plugins_page_shortcodes-for-buddypress' === $hook || 'wbcomplugins' === $shortcode_style || 'wbcom-plugins-page' === $shortcode_style || 'wbcom-support-page' === $shortcode_style ) {
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				$extension = is_rtl() ? '.rtl.css' : '.css';
				$path      = is_rtl() ? '/rtl' : '';
			} else {
				$extension = is_rtl() ? '.rtl.css' : '.min.css';
				$path      = is_rtl() ? '/rtl' : '/min';
			}

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css' . $path . '/shortcodes-for-buddypress-admin' . $extension, array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the script for the admin area.
	 *
	 * This function enqueues the plugin-specific admin script only
	 * on the appropriate admin pages to avoid unnecessary loading elsewhere.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook The current admin page hook suffix.
	 */
	public function enqueue_scripts( $hook ) {

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
		if ( 'settings_page_bpsh-shortcodes' === $hook ) {
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				$extension = '.js';
				$path      = '';
			} else {
				$extension = '.min.js';
				$path      = '/min';
			}

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js' . $path . '/shortcodes-for-buddypress-admin' . $extension, array( 'jquery' ), $this->version, false );
		}

	}

	/**
	 * Hide all admin notices on specific Wbcom settings pages.
	 *
	 * This function removes all admin notices (both `admin_notices` and `all_admin_notices`)
	 * when viewing specified Wbcom plugin settings or support pages to provide a cleaner admin UI.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function wbcom_hide_all_admin_notices_from_setting_page() {
		$wbcom_pages_array  = array( 'wbcomplugins', 'wbcom-plugins-page', 'wbcom-support-page', 'shortcodes-for-buddypress' );
		$wbcom_setting_page = filter_input( INPUT_GET, 'page' ) ? filter_input( INPUT_GET, 'page' ) : '';

		if ( in_array( $wbcom_setting_page, $wbcom_pages_array, true ) ) {
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
		}
	}

	/**
	 * Register a submenu to handle group types
	 *
	 * @since    1.0.0
	 */
	public function buddypress_shortcodes_add_submenu_page() {
		if ( empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) ) {
			add_menu_page( esc_html__( 'WB Plugins', 'shortcodes-for-buddypress' ), esc_html__( 'WB Plugins', 'shortcodes-for-buddypress' ), 'manage_options', 'wbcomplugins', array( $this, 'buddypress_shortcodes_admin_settings_page' ), 'dashicons-lightbulb', 59 );
			add_submenu_page( 'wbcomplugins', esc_html__( 'General', 'shortcodes-for-buddypress' ), esc_html__( 'General', 'shortcodes-for-buddypress' ), 'manage_options', 'wbcomplugins' );
		}
		add_submenu_page( 'wbcomplugins', esc_html__( 'Shortcodes', 'shortcodes-for-buddypress' ), esc_html__( 'Shortcodes', 'shortcodes-for-buddypress' ), 'manage_options', $this->plugin_name, array( $this, 'buddypress_shortcodes_admin_settings_page' ) );
	}

	/**
	 * Actions performed to create a submenu page content
	 *
	 * @since 2.0.0
	 */
	public function buddypress_shortcodes_admin_settings_page() {
		$tab = ( filter_input( INPUT_GET, 'tab' ) !== null ) ? filter_input( INPUT_GET, 'tab' ) : 'buddypress-shortcode-welcome';
		?>
		<div class="wrap">
			<div class="wbcom-bb-plugins-offer-wrapper">
				<div id="wb_admin_logo">
				</div>
			</div>
			<div class="wbcom-wrap wbcom-plugin-wrapper">
				<div class="bupr-header">
				<div class="wbcom_admin_header-wrapper">
					<div id="wb_admin_plugin_name">
					<?php esc_html_e( 'BuddyPress Shortcodes', 'shortcodes-for-buddypress' ); ?>
						<span>
						<?php
						/* translators: %s: */
						printf( esc_html__( 'Version %s', 'shortcodes-for-buddypress' ), esc_attr( SHORTCODES_FOR_BUDDYPRESS_VERSION ) );
						?>
						</span>
					</div>
				<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
				</div>
				</div>
				<div class="wbcom-admin-settings-page">
			<?php
			$this->buddypress_shortcodes_plugin_settings_tabs();
			settings_fields( $tab );
			do_settings_sections( $tab );
			?>
				</div>
			</div>
		</div>

			<?php
	}

	/**
	 * Render the settings tabs for the BuddyPress Shortcodes plugin.
	 *
	 * Displays tab navigation based on the plugin settings.
	 *
	 * @since 1.0.0
	 */
	public function buddypress_shortcodes_plugin_settings_tabs() {
		$current_tab = ( filter_input( INPUT_GET, 'tab' ) !== null )
			? sanitize_text_field( filter_input( INPUT_GET, 'tab' ) )
			: 'buddypress-shortcode-welcome';

		echo '<div class="wbcom-tabs-section">';
			echo '<div class="nav-tab-wrapper">';

				// Responsive Menu Toggle
				echo '<div class="wb-responsive-menu">';
					echo '<span>' . esc_html__( 'Menu', 'shortcodes-for-buddypress' ) . '</span>';
					echo '<input class="wb-toggle-btn" type="checkbox" id="wb-toggle-btn">';
					echo '<label class="wb-toggle-icon" for="wb-toggle-btn">';
						echo '<span class="wb-icon-bars"></span>';
					echo '</label>';
				echo '</div>'; // .wb-responsive-menu

				// Tab Navigation List
				echo '<ul>';
					foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
						$active = ( $current_tab === $tab_key ) ? 'nav-tab-active' : '';
						echo '<li class="' . esc_attr( $tab_key ) . '">';
							echo '<a class="nav-tab ' . esc_attr( $active ) . '" id="' . esc_attr( $tab_key ) . '-tab" href="?page=' . esc_attr( $this->plugin_name ) . '&tab=' . esc_attr( $tab_key ) . '">';
								echo esc_html( $tab_caption );
							echo '</a>';
						echo '</li>';
					}
				echo '</ul>';

			echo '</div>'; // .nav-tab-wrapper
		echo '</div>'; // .wbcom-tabs-section
	}


	/**
	 * Register all settings tabs and their content callbacks.
	 *
	 * @since 2.0.0
	 */
	public function buddypress_shortcodes_plugin_settings() {

		$tabs = [
			'buddypress-shortcode-welcome'           => [ 'Welcome', 'buddypress_shortcodes_welcome_content' ],
			'buddypress-shortcode-general'           => [ 'General', 'buddypress_shortcodes_general_settings_content' ],
			'buddypress-shortcode-activities'        => [ 'Activities', 'buddypress_shortcodes_activities_settings_content' ],
			'buddypress-shortcode-member'            => [ 'Members', 'buddypress_shortcodes_member_settings_content' ],
			'buddypress-shortcode-groups'            => [ 'Groups', 'buddypress_shortcodes_groups_settings_content' ],
			'buddypress-shortcode-user-notification' => [ 'User Notification', 'buddypress_shortcodes_user_notification_settings_content' ],
		];

		foreach ( $tabs as $tab_slug => $tab_data ) {
			$label    = esc_html__( $tab_data[0], 'shortcodes-for-buddypress' );
			$callback = [ $this, $tab_data[1] ];

			$this->plugin_settings_tabs[ $tab_slug ] = $label;
			add_settings_section( $tab_slug, ' ', $callback, $tab_slug );
		}
	}

	/**
	 * Welcome Tab Content
	 *
	 * @since 1.0.0
	 */
	public function buddypress_shortcodes_welcome_content() {
		if ( file_exists( dirname( __FILE__ ) . '/settings/buddypress-shortcode-welcome-page.php' ) ) {
			require_once dirname( __FILE__ ) . '/settings/buddypress-shortcode-welcome-page.php';
		}
	}

		/**
		 * General Tab Content
		 *
		 * @since 1.0.0
		 */
	public function buddypress_shortcodes_general_settings_content() {
		if ( file_exists( dirname( __FILE__ ) . '/settings/buddypress-shortcode-general-settings.php' ) ) {
			require_once dirname( __FILE__ ) . '/settings/buddypress-shortcode-general-settings.php';
		}
	}

	/**
	 * Activity tab content
	 *
	 * @return void
	 */
	public function buddypress_shortcodes_activities_settings_content() {
		if ( file_exists( dirname( __FILE__ ) . '/settings/buddypress-shortcode-activity-listing.php' ) ) {
			require_once dirname( __FILE__ ) . '/settings/buddypress-shortcode-activity-listing.php';
		}
	}

	/**
	 * Member tab content
	 *
	 * @return void
	 */
	public function buddypress_shortcodes_member_settings_content() {
		if ( file_exists( dirname( __FILE__ ) . '/settings/buddypress-shortcode-member-listing.php' ) ) {
			require_once dirname( __FILE__ ) . '/settings/buddypress-shortcode-member-listing.php';
		}
	}

	/**
	 * Group tab content
	 *
	 * @return void
	 */
	public function buddypress_shortcodes_groups_settings_content() {
		if ( file_exists( dirname( __FILE__ ) . '/settings/buddypress-shortcode-groups-listing.php' ) ) {
			require_once dirname( __FILE__ ) . '/settings/buddypress-shortcode-groups-listing.php';
		}
	}

	/**
	 * User notification tab content
	 *
	 * @return void
	 */
	public function buddypress_shortcodes_user_notification_settings_content() {
		if ( file_exists( dirname( __FILE__ ) . '/settings/buddypress-shortcode-user-notification-listing.php' ) ) {
			require_once dirname( __FILE__ ) . '/settings/buddypress-shortcode-user-notification-listing.php';
		}
	}

}

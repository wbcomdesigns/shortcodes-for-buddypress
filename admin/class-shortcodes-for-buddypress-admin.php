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
		$page = filter_input( INPUT_GET, 'page' );
		$allowed_pages = array(
			'wbcomplugins',
			'wbcom-plugins-page',
			'wbcom-support-page',
			'shortcodes-for-buddypress'
		);

		// Only load on our admin pages
		if ( 'wb-plugins_page_shortcodes-for-buddypress' === $hook || in_array( $page, $allowed_pages ) ) {
			bp_shortcode_enqueue(
				$this->plugin_name,
				'admin/css',
				'shortcodes-for-buddypress-admin',
				'css',
				array(),
				$this->version
			);
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
		// Only load on specific settings page
		if ( 'settings_page_bpsh-shortcodes' === $hook ) {
			bp_shortcode_enqueue(
				$this->plugin_name,
				'admin/js',
				'shortcodes-for-buddypress-admin',
				'js',
				array( 'jquery' ),
				$this->version
			);
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
			'buddypress-shortcode-welcome'    => [ esc_html__( 'Welcome', 'shortcodes-for-buddypress' ), 'buddypress_shortcodes_welcome_content' ],
			'buddypress-shortcode-general'    => [ esc_html__( 'General', 'shortcodes-for-buddypress' ), 'buddypress_shortcodes_general_settings_content' ],
			'buddypress-shortcode-activities' => [ esc_html__( 'Activities', 'shortcodes-for-buddypress' ), 'buddypress_shortcodes_activities_settings_content' ],
			'buddypress-shortcode-member'     => [ esc_html__( 'Members', 'shortcodes-for-buddypress' ), 'buddypress_shortcodes_member_settings_content' ],
			'buddypress-shortcode-groups'     => [ esc_html__( 'Groups', 'shortcodes-for-buddypress' ), 'buddypress_shortcodes_groups_settings_content' ],
		];

		foreach ( $tabs as $tab_slug => $tab_data ) {
			$label    = $tab_data[0];
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
	/**
	 * performance tab content
	 *
	 * @return void
	 */
	public function buddypress_shortcodes_render_performance_settings_description(){
		if ( file_exists( dirname( __FILE__ ) . '/settings/buddypress-shortcode-user-performance-setting.php' ) ) {
			require_once dirname( __FILE__ ) . '/settings/buddypress-shortcode-user-performance-setting.php';
		}
	}

	/**
	 * Save plugin admin options
	*/
	public function buddypress_shortcodes_save_options() {
		if ( isset( $_POST[ 'option_page' ] ) && 'bpsh_performance_settings'=== $_POST[ 'option_page' ]) {
			$option_value = wp_unslash( $_POST[ 'bpsh_performance_settings'] );	// phpcs:ignore

			update_option( 'bpsh_performance_settings', $option_value );
		}
		
	}

	/**
	 * Register the settings
	*/
	public function buddypress_shortcodes_register_settings(){
		register_setting( 'bpsh_settings_group', 'bpsh_performance_settings' );	// phpcs:ignore
	}



}

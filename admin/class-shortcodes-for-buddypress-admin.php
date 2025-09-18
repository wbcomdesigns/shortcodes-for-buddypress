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
 * Admin functionality.
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/admin
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Shortcodes_For_Buddypress_Admin {

	/**
	 * Plugin ID.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string $plugin_name
	 */
	private $plugin_name;

	/**
	 * Plugin version.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string $version
	 */
	private $version;

	/**
	 * Plugin settings tabs.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    array $plugin_settings_tabs
	 */
	private $plugin_settings_tabs;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name Plugin name.
	 * @param string $version     Plugin version.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Enqueue admin stylesheets.
	 *
	 * @since 1.0.0
	 * @param string $hook Admin page hook.
	 * @return void
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
	 * Enqueue admin scripts.
	 *
	 * @since 1.0.0
	 * @param string $hook Admin page hook.
	 * @return void
	 */
	public function enqueue_scripts( $hook ) {
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
	 * Hide admin notices on settings pages.
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
	 * Add admin submenu page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function buddypress_shortcodes_add_submenu_page() {
		if ( empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) ) {
			add_menu_page( esc_html__( 'WB Plugins', 'shortcodes-for-buddypress' ), esc_html__( 'WB Plugins', 'shortcodes-for-buddypress' ), 'manage_options', 'wbcomplugins', array( $this, 'buddypress_shortcodes_admin_settings_page' ), 'dashicons-lightbulb', 59 );
			add_submenu_page( 'wbcomplugins', esc_html__( 'General', 'shortcodes-for-buddypress' ), esc_html__( 'General', 'shortcodes-for-buddypress' ), 'manage_options', 'wbcomplugins' );
		}
		add_submenu_page( 'wbcomplugins', esc_html__( 'Shortcodes', 'shortcodes-for-buddypress' ), esc_html__( 'Shortcodes', 'shortcodes-for-buddypress' ), 'manage_options', $this->plugin_name, array( $this, 'buddypress_shortcodes_admin_settings_page' ) );
	}

	/**
	 * Render admin settings page.
	 *
	 * @since 1.0.0
	 * @return void
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
	 * Display settings tabs.
	 *
	 * @since 1.0.0
	 * @return void
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
	 * Register settings tabs.
	 *
	 * @since 1.0.0
	 * @return void
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
	 * Welcome tab content.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function buddypress_shortcodes_welcome_content() {
		if ( file_exists( dirname( __FILE__ ) . '/settings/buddypress-shortcode-welcome-page.php' ) ) {
			require_once dirname( __FILE__ ) . '/settings/buddypress-shortcode-welcome-page.php';
		}
	}

	/**
	 * General tab content.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function buddypress_shortcodes_general_settings_content() {
		if ( file_exists( dirname( __FILE__ ) . '/settings/buddypress-shortcode-general-settings.php' ) ) {
			require_once dirname( __FILE__ ) . '/settings/buddypress-shortcode-general-settings.php';
		}
	}

	/**
	 * Activity tab content.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function buddypress_shortcodes_activities_settings_content() {
		if ( file_exists( dirname( __FILE__ ) . '/settings/buddypress-shortcode-activity-listing.php' ) ) {
			require_once dirname( __FILE__ ) . '/settings/buddypress-shortcode-activity-listing.php';
		}
	}

	/**
	 * Member tab content.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function buddypress_shortcodes_member_settings_content() {
		if ( file_exists( dirname( __FILE__ ) . '/settings/buddypress-shortcode-member-listing.php' ) ) {
			require_once dirname( __FILE__ ) . '/settings/buddypress-shortcode-member-listing.php';
		}
	}

	/**
	 * Group tab content.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function buddypress_shortcodes_groups_settings_content() {
		if ( file_exists( dirname( __FILE__ ) . '/settings/buddypress-shortcode-groups-listing.php' ) ) {
			require_once dirname( __FILE__ ) . '/settings/buddypress-shortcode-groups-listing.php';
		}
	}


	/**
	 * Save plugin options.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function buddypress_shortcodes_save_options() {
		if ( isset( $_POST['option_page'] ) && 'bpsh_performance_settings' === $_POST['option_page'] ) {
			$option_value = wp_unslash( $_POST['bpsh_performance_settings'] ); // phpcs:ignore

			update_option( 'bpsh_performance_settings', $option_value );
		}
	}

	/**
	 * Register plugin settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function buddypress_shortcodes_register_settings() {
		register_setting( 'bpsh_settings_group', 'bpsh_performance_settings' );
	}



}

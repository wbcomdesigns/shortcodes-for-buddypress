<?php
/**
 * Card-panel admin: menu, enqueue, page rendering.
 *
 * Replaces the legacy Wbcom wrapper chrome
 * (admin/wbcom/wbcom-admin-settings.php + the nav-tab-wrapper render in
 * admin/class-shortcodes-for-buddypress-admin.php). Follows the
 * wp-plugin-development skill Part 6 card-panel pattern and the
 * references/wbcom-wrapper-migration.md playbook (Parts 5, 6, 16).
 *
 * IMPORTANT: this plugin persists ZERO settings — it never calls
 * register_setting(). Its tabs are informational documentation panels
 * describing the 3 shortcodes + 3 Elementor widgets. So this controller
 * has NO register_settings()/sanitize_settings(); the shell renders
 * every tab as a plain partial (no <form>, no options.php).
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/includes/admin
 * @since      3.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Shortcodes_For_Buddypress_Admin_Panel
 *
 * @since 3.0.0
 */
class Shortcodes_For_Buddypress_Admin_Panel {

	/**
	 * Menu slug — kept identical to the legacy slug so bookmarks and
	 * the documented `?page=shortcodes-for-buddypress` URL still work.
	 */
	const MENU_SLUG = 'shortcodes-for-buddypress';

	/**
	 * All sidebar tabs rendered inside the one admin page.
	 *
	 * Grouped into main (Overview dashboard) + reference (the ported
	 * informational doc panels). No "settings" group — nothing here
	 * saves to the database.
	 *
	 * @return array<string, array{label:string, icon:string, group:string}>
	 */
	public static function get_tabs() {
		$tabs = array(
			'overview'   => array(
				'label' => __( 'Overview', 'shortcodes-for-buddypress' ),
				'icon'  => 'dashicons-chart-bar',
				'group' => 'main',
			),
			'shortcodes' => array(
				'label' => __( 'Shortcodes', 'shortcodes-for-buddypress' ),
				'icon'  => 'dashicons-editor-code',
				'group' => 'reference',
			),
			'activities' => array(
				'label' => __( 'Activities', 'shortcodes-for-buddypress' ),
				'icon'  => 'dashicons-buddicons-activity',
				'group' => 'reference',
			),
			'members'    => array(
				'label' => __( 'Members', 'shortcodes-for-buddypress' ),
				'icon'  => 'dashicons-groups',
				'group' => 'reference',
			),
			'groups'     => array(
				'label' => __( 'Groups', 'shortcodes-for-buddypress' ),
				'icon'  => 'dashicons-buddicons-groups',
				'group' => 'reference',
			),
			'discover'   => array(
				'label' => __( 'Discover', 'shortcodes-for-buddypress' ),
				'icon'  => 'dashicons-lightbulb',
				'group' => 'more',
			),
		);
		return apply_filters( 'bpsp_admin_tabs', $tabs );
	}

	/**
	 * Bootstrap hooks.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		// Priority 999 runs after every other plugin has registered its
		// admin_menu entries. Used to reclaim the hub's landing render
		// when a legacy wbcom-wrapper plugin was the first to register
		// the wbcomplugins top-level menu. See playbook Part 16.
		add_action( 'admin_menu', array( $this, 'takeover_hub_landing' ), 999 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'in_admin_header', array( $this, 'suppress_foreign_notices' ), 1 );
	}

	/**
	 * Attach as a single submenu under the shared WB Plugins hub.
	 *
	 * @return void
	 */
	public function add_menu() {
		$cap = 'manage_options';

		// First Wbcom plugin to load creates the shared WB Plugins hub.
		// Peer plugins are auto-discovered via
		// $GLOBALS['submenu']['wbcomplugins'] inside render_hub.
		if ( empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) ) {
			add_menu_page(
				esc_html__( 'WB Plugins', 'shortcodes-for-buddypress' ),
				esc_html__( 'WB Plugins', 'shortcodes-for-buddypress' ),
				$cap,
				'wbcomplugins',
				array( $this, 'render_hub' ),
				'dashicons-lightbulb',
				59
			);
		}

		add_submenu_page(
			'wbcomplugins',
			esc_html__( 'Shortcodes For BuddyPress', 'shortcodes-for-buddypress' ),
			esc_html__( 'BP Shortcodes', 'shortcodes-for-buddypress' ),
			$cap,
			self::MENU_SLUG,
			array( $this, 'render_page' )
		);
	}

	/**
	 * Force the shared hub's landing page to render our clean card-panel
	 * dashboard, overriding whatever a legacy wbcom-wrapper plugin may
	 * have registered. See playbook Part 16.
	 *
	 * @return void
	 */
	public function takeover_hub_landing() {
		global $admin_page_hooks;
		if ( empty( $admin_page_hooks['wbcomplugins'] ) ) {
			return;
		}
		remove_all_actions( 'toplevel_page_wbcomplugins' );
		add_action( 'toplevel_page_wbcomplugins', array( $this, 'render_hub' ) );
	}

	/**
	 * Enqueue admin assets only on our screen + the shared hub landing.
	 *
	 * @param string $hook_suffix Current admin page hook.
	 * @return void
	 */
	public function enqueue_assets( $hook_suffix ) {
		unset( $hook_suffix ); // We inspect the screen object instead.
		$screen = get_current_screen();
		if ( ! $screen || ! $this->is_our_screen( $screen ) ) {
			return;
		}

		$version = defined( 'SHORTCODES_FOR_BUDDYPRESS_VERSION' ) ? SHORTCODES_FOR_BUDDYPRESS_VERSION : '3.0.0';

		/*
		 * Resolve through bp_shortcode_asset() so the Grunt build output is
		 * actually used: RTL first (when the locale needs it), then the
		 * minified build, then the unminified source. The source is the final
		 * fallback, so an unbuilt checkout still loads rather than 404s.
		 */
		wp_enqueue_style(
			'bpsp-admin',
			bp_shortcode_asset( 'assets/css', 'admin', 'css' ),
			array(),
			$version
		);

		wp_enqueue_script(
			'bpsp-admin',
			bp_shortcode_asset( 'assets/js', 'admin', 'js' ),
			array( 'jquery' ),
			$version,
			true
		);

		wp_localize_script(
			'bpsp-admin',
			'bpspAdmin',
			array(
				'i18n' => array(
					'confirmDanger'   => __( 'Are you sure?', 'shortcodes-for-buddypress' ),
					'confirmContinue' => __( 'Continue', 'shortcodes-for-buddypress' ),
					'confirmCancel'   => __( 'Cancel', 'shortcodes-for-buddypress' ),
				),
			)
		);
	}

	/**
	 * Suppress 3rd-party admin notices on our screen.
	 *
	 * @return void
	 */
	public function suppress_foreign_notices() {
		$screen = get_current_screen();
		if ( ! $screen || ! $this->is_our_screen( $screen ) ) {
			return;
		}
		remove_all_actions( 'admin_notices' );
		remove_all_actions( 'all_admin_notices' );
	}

	/**
	 * True if the current screen is the plugin's admin page OR the
	 * shared hub landing (our callback may own the hub render too).
	 *
	 * @param WP_Screen $screen Current screen.
	 * @return bool
	 */
	private function is_our_screen( $screen ) {
		if ( empty( $screen->id ) ) {
			return false;
		}
		return (bool) preg_match( '/_page_' . preg_quote( self::MENU_SLUG, '/' ) . '$/', $screen->id )
			|| 'toplevel_page_wbcomplugins' === $screen->id;
	}

	/**
	 * Render the shared WB Plugins hub landing page.
	 *
	 * @return void
	 */
	public function render_hub() {
		$view = plugin_dir_path( __DIR__ ) . 'admin/views/hub.php';
		if ( file_exists( $view ) ) {
			include $view;
		}
	}

	/**
	 * Render the single admin page. Routes to the active tab partial.
	 *
	 * @return void
	 */
	public function render_page() {
		$bpsp_tabs = self::get_tabs();
		$tab_slugs = array_keys( $bpsp_tabs );
		// Read-only navigation: no state change, so no nonce needed.
		$active = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : $tab_slugs[0]; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $bpsp_tabs[ $active ] ) ) {
			$active = $tab_slugs[0];
		}

		$page_url = admin_url( 'admin.php?page=' . self::MENU_SLUG );

		$view_map  = array(
			'overview'   => 'overview',
			'shortcodes' => 'reference-shortcodes',
			'activities' => 'reference-activities',
			'members'    => 'reference-members',
			'groups'     => 'reference-groups',
			'discover'   => 'discover',
		);
		$view_slug = isset( $view_map[ $active ] ) ? $view_map[ $active ] : 'overview';
		$view_path = plugin_dir_path( __DIR__ ) . 'admin/views/' . $view_slug . '.php';
		$layout    = plugin_dir_path( __DIR__ ) . 'admin/views/layout.php';

		include $layout;
	}
}

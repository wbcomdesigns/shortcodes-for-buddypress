<?php
/**
 * Admin page shell: page header, sidebar nav, body slot.
 *
 * Receives from Shortcodes_For_Buddypress_Admin_Panel::render_page():
 *
 * @var array  $bpsp_tabs Tab registry keyed by slug.
 * @var string $active    Active tab slug.
 * @var string $page_url  Base URL (admin.php?page=shortcodes-for-buddypress).
 * @var string $view      View slug (e.g. 'overview', 'reference-shortcodes').
 * @var string $view_path Absolute path to the active tab partial.
 *
 * This plugin persists no settings, so the shell renders every tab as a
 * plain informational partial — there is no <form>/options.php branch.
 *
 * @package Shortcodes_For_Buddypress
 * @since   3.0.0
 */

defined( 'ABSPATH' ) || exit;

$bpsp_version = defined( 'SHORTCODES_FOR_BUDDYPRESS_VERSION' ) ? SHORTCODES_FOR_BUDDYPRESS_VERSION : '';
?>
<div class="wrap bpsp-admin">

	<header class="bpsp-page-header">
		<div class="bpsp-page-header__title">
			<span class="dashicons dashicons-editor-code" aria-hidden="true"></span>
			<div>
				<h1><?php esc_html_e( 'Shortcodes For BuddyPress', 'shortcodes-for-buddypress' ); ?></h1>
				<p class="bpsp-page-header__subtitle"><?php esc_html_e( 'Embed BuddyPress activities, members, and groups anywhere using shortcodes or Elementor widgets.', 'shortcodes-for-buddypress' ); ?></p>
			</div>
		</div>
		<div class="bpsp-page-header__actions">
			<?php if ( $bpsp_version ) : ?>
				<span class="bpsp-version-pill">v<?php echo esc_html( $bpsp_version ); ?></span>
			<?php endif; ?>
		</div>
	</header>

	<?php
	/*
	 * Without this marker, core's common.js re-parents every .notice to
	 * sit right after the first <h1> it finds, which slots admin banners
	 * between our title and its subtitle instead of below the header.
	 */
	?>
	<hr class="wp-header-end">

	<?php settings_errors(); ?>

	<div class="bpsp-settings-layout">

		<aside class="bpsp-settings-sidebar">
			<div class="bpsp-settings-sidebar-brand">
				<span class="bpsp-settings-brand-icon" aria-hidden="true">
					<span class="dashicons dashicons-editor-code"></span>
				</span>
				<div class="bpsp-settings-brand-text">
					<p class="bpsp-settings-brand-name"><?php esc_html_e( 'BP Shortcodes', 'shortcodes-for-buddypress' ); ?></p>
					<p class="bpsp-settings-brand-sub"><?php esc_html_e( 'Plugin', 'shortcodes-for-buddypress' ); ?></p>
				</div>
			</div>
			<nav class="bpsp-settings-sidebar-nav" aria-label="<?php esc_attr_e( 'Shortcodes for BuddyPress navigation', 'shortcodes-for-buddypress' ); ?>">
				<?php
				$bpsp_printed_groups = array();
				$bpsp_group_labels   = array(
					'reference' => esc_html__( 'Reference', 'shortcodes-for-buddypress' ),
				);
				foreach ( $bpsp_tabs as $bpsp_slug => $bpsp_tab ) {
					$bpsp_group = isset( $bpsp_tab['group'] ) ? $bpsp_tab['group'] : 'main';
					if ( 'main' !== $bpsp_group && ! in_array( $bpsp_group, $bpsp_printed_groups, true ) ) {
						echo '<div class="bpsp-snav-divider" role="separator"></div>';
						if ( isset( $bpsp_group_labels[ $bpsp_group ] ) ) {
							echo '<p class="bpsp-snav-section-label">' . esc_html( $bpsp_group_labels[ $bpsp_group ] ) . '</p>';
						}
						$bpsp_printed_groups[] = $bpsp_group;
					}
					$bpsp_classes  = 'bpsp-snav-link';
					$bpsp_classes .= $active === $bpsp_slug ? ' bpsp-snav-link--active' : '';
					echo '<a href="' . esc_url( $page_url . '&tab=' . $bpsp_slug ) . '" class="' . esc_attr( $bpsp_classes ) . '">';
					echo '<span class="dashicons ' . esc_attr( $bpsp_tab['icon'] ) . '" aria-hidden="true"></span>';
					echo esc_html( $bpsp_tab['label'] );
					echo '</a>';
				}
				?>

				<div class="bpsp-snav-divider" role="separator"></div>
				<p class="bpsp-snav-section-label"><?php esc_html_e( 'Resources', 'shortcodes-for-buddypress' ); ?></p>
				<a href="https://docs.wbcomdesigns.com/doc_category/shortcodes-for-buddypress/" class="bpsp-snav-link" target="_blank" rel="noopener noreferrer">
					<span class="dashicons dashicons-book" aria-hidden="true"></span>
					<?php esc_html_e( 'Documentation', 'shortcodes-for-buddypress' ); ?>
					<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'shortcodes-for-buddypress' ); ?></span>
				</a>
				<a href="https://wbcomdesigns.com/support/" class="bpsp-snav-link" target="_blank" rel="noopener noreferrer">
					<span class="dashicons dashicons-sos" aria-hidden="true"></span>
					<?php esc_html_e( 'Support', 'shortcodes-for-buddypress' ); ?>
					<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'shortcodes-for-buddypress' ); ?></span>
				</a>
			</nav>
		</aside>

		<div class="bpsp-settings-main">
			<?php
			if ( file_exists( $view_path ) ) {
				include $view_path;
			}
			?>
		</div>

	</div>
</div>

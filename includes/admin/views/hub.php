<?php
/**
 * WB Plugins hub — landing dashboard at ?page=wbcomplugins.
 *
 * Lists every Wbcom plugin that has registered a submenu under the
 * shared wbcomplugins parent. Peer plugins appear automatically once
 * their admin page is in the WordPress menu table.
 *
 * Legacy wbcom-wrapper plugins register four boilerplate helper pages
 * (Our Plugins, Our Themes, Support, License) under this hub. Those are
 * not real plugins and must not appear as cards — we filter them out
 * via wbcom_hub_wrapper_helper_slugs. See playbook Part 16.
 *
 * @package Shortcodes_For_Buddypress
 * @since   3.0.0
 */

defined( 'ABSPATH' ) || exit;

$bpsp_submenu_entries = isset( $GLOBALS['submenu']['wbcomplugins'] ) && is_array( $GLOBALS['submenu']['wbcomplugins'] )
	? $GLOBALS['submenu']['wbcomplugins']
	: array();

// Slugs of the legacy wbcom-wrapper boilerplate helper pages. Filterable
// so Pro modules or future wrapper slugs can be added.
$bpsp_wrapper_helper_slugs = apply_filters(
	'wbcom_hub_wrapper_helper_slugs',
	array(
		'wbcom-plugins-page',
		'wbcom-themes-page',
		'wbcom-support-page',
		'wbcom-license-page',
	)
);

$bpsp_plugins = array();
foreach ( $bpsp_submenu_entries as $bpsp_entry ) {
	$bpsp_slug = isset( $bpsp_entry[2] ) ? (string) $bpsp_entry[2] : '';
	if ( '' === $bpsp_slug || 'wbcomplugins' === $bpsp_slug ) {
		continue;
	}
	if ( in_array( $bpsp_slug, $bpsp_wrapper_helper_slugs, true ) ) {
		continue;
	}
	$bpsp_plugins[] = array(
		'slug'       => $bpsp_slug,
		'menu_title' => isset( $bpsp_entry[0] ) ? wp_strip_all_tags( (string) $bpsp_entry[0] ) : $bpsp_slug,
		'page_title' => isset( $bpsp_entry[3] ) ? wp_strip_all_tags( (string) $bpsp_entry[3] ) : '',
		'url'        => admin_url( 'admin.php?page=' . rawurlencode( $bpsp_slug ) ),
	);
}

$bpsp_plugin_count = count( $bpsp_plugins );
?>
<div class="wrap bpsp-admin">
	<header class="bpsp-page-header">
		<div class="bpsp-page-header__title">
			<span class="dashicons dashicons-lightbulb" aria-hidden="true"></span>
			<div>
				<h1><?php esc_html_e( 'WB Plugins', 'shortcodes-for-buddypress' ); ?></h1>
				<p class="bpsp-page-header__subtitle">
					<?php
					echo esc_html(
						sprintf(
							/* translators: %d: active Wbcom plugin count */
							_n(
								'%d Wbcom plugin active on this site.',
								'%d Wbcom plugins active on this site.',
								$bpsp_plugin_count,
								'shortcodes-for-buddypress'
							),
							$bpsp_plugin_count
						)
					);
					?>
				</p>
			</div>
		</div>
	</header>

	<?php if ( 0 === $bpsp_plugin_count ) : ?>
		<div class="bpsp-empty-state">
			<span class="bpsp-empty-state__icon" aria-hidden="true">
				<span class="dashicons dashicons-lightbulb"></span>
			</span>
			<p class="bpsp-empty-state__title"><?php esc_html_e( 'No Wbcom plugins attached to this hub yet', 'shortcodes-for-buddypress' ); ?></p>
			<p class="bpsp-empty-state__desc">
				<?php esc_html_e( 'Activate one or more Wbcom plugins and they will appear here automatically.', 'shortcodes-for-buddypress' ); ?>
			</p>
		</div>
	<?php else : ?>
		<div class="bpsp-hub-grid">
			<?php foreach ( $bpsp_plugins as $bpsp_p ) : ?>
				<a href="<?php echo esc_url( $bpsp_p['url'] ); ?>" class="bpsp-hub-card">
					<span class="bpsp-hub-card__icon" aria-hidden="true">
						<span class="dashicons dashicons-admin-plugins"></span>
					</span>
					<span class="bpsp-hub-card__title"><?php echo esc_html( $bpsp_p['menu_title'] ); ?></span>
					<?php if ( ! empty( $bpsp_p['page_title'] ) && $bpsp_p['page_title'] !== $bpsp_p['menu_title'] ) : ?>
						<span class="bpsp-hub-card__subtitle"><?php echo esc_html( $bpsp_p['page_title'] ); ?></span>
					<?php endif; ?>
					<span class="bpsp-hub-card__cta">
						<?php esc_html_e( 'Open settings', 'shortcodes-for-buddypress' ); ?>
						<span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<div class="bpsp-card">
		<div class="bpsp-card__head">
			<p class="bpsp-card__title"><?php esc_html_e( 'About WB Plugins', 'shortcodes-for-buddypress' ); ?></p>
		</div>
		<div class="bpsp-card__body">
			<p style="margin: 0 0 8px;">
				<?php esc_html_e( 'This hub is the single entry point for every Wbcom Designs plugin installed on your site. Each plugin lives on its own page under this menu and keeps its own settings and data.', 'shortcodes-for-buddypress' ); ?>
			</p>
			<p style="margin: 0;">
				<a href="https://wbcomdesigns.com/" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Visit wbcomdesigns.com for more plugins and themes', 'shortcodes-for-buddypress' ); ?>
				</a>
			</p>
		</div>
	</div>
</div>

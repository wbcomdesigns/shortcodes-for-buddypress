<?php
/**
 * Discover partial: ecosystem cross-promotion (read-only display view).
 *
 * Rendered inside shell.php. Pure presentation - product cards linking out
 * to other free Wbcom Designs tools. No forms, settings, options, or AJAX.
 *
 * @package Shortcodes_For_Buddypress
 * @since   3.0.0
 */

defined( 'ABSPATH' ) || exit;

$bpsp_ecosystem_url = ( defined( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_URL' ) ? SHORTCODES_FOR_BUDDYPRESS_PLUGIN_URL : plugins_url( '/', dirname( __DIR__, 2 ) ) ) . 'assets/images/ecosystem/';
$bpsp_ecosystem_dir = dirname( __DIR__, 3 ) . '/assets/images/ecosystem/';

/*
 * Each product: brand mark (shipped in assets/images/ecosystem/), name, a
 * short admin-specific blurb (worded differently from readme.txt), and the
 * wbcomdesigns.com download URL.
 */
$bpsp_ecosystem = array(
	array(
		'name' => __( 'BuddyX', 'shortcodes-for-buddypress' ),
		'logo' => 'buddyx.png',
		'icon' => 'admin-appearance',
		'desc' => __( 'A free, fast community theme for BuddyPress, BuddyBoss and PeepSo with a modern layout and dark mode.', 'shortcodes-for-buddypress' ),
		'url'  => 'https://wbcomdesigns.com/downloads/buddyx-theme/',
	),
	array(
		'name' => __( 'BuddyNext', 'shortcodes-for-buddypress' ),
		'logo' => 'buddynext.svg',
		'icon' => 'groups',
		'desc' => __( 'The full community stack: activity feeds, member spaces, profiles, and private messaging on WordPress.', 'shortcodes-for-buddypress' ),
		'url'  => 'https://wbcomdesigns.com/downloads/buddynext/',
	),
	array(
		'name' => __( 'Jetonomy', 'shortcodes-for-buddypress' ),
		'logo' => 'jetonomy.svg',
		'icon' => 'format-chat',
		'desc' => __( 'Self-moderating forums and Q&A boards that stay fast well beyond 100,000 topics.', 'shortcodes-for-buddypress' ),
		'url'  => 'https://wbcomdesigns.com/downloads/jetonomy/',
	),
	array(
		'name' => __( 'Mediaverse', 'shortcodes-for-buddypress' ),
		'logo' => 'mediaverse.svg',
		'icon' => 'format-gallery',
		'desc' => __( 'A photo and video hub with albums, reactions, following, and private chat.', 'shortcodes-for-buddypress' ),
		'url'  => 'https://wbcomdesigns.com/downloads/mediaverse/',
	),
	array(
		'name' => __( 'Eventonomy', 'shortcodes-for-buddypress' ),
		'logo' => 'eventonomy.svg',
		'icon' => 'calendar-alt',
		'desc' => __( 'Run community events with RSVPs, calendars, and front-end submissions.', 'shortcodes-for-buddypress' ),
		'url'  => 'https://wbcomdesigns.com/downloads/eventonomy/',
	),
	array(
		'name' => __( 'WB Gamification', 'shortcodes-for-buddypress' ),
		'logo' => 'wb-gamification.svg',
		'icon' => 'awards',
		'desc' => __( 'Reward members with points, badges, and leaderboards to keep engagement high.', 'shortcodes-for-buddypress' ),
		'url'  => 'https://wbcomdesigns.com/downloads/wordpress-gamification-plugin/',
	),
	array(
		'name' => __( 'Listora', 'shortcodes-for-buddypress' ),
		'logo' => 'listora.svg',
		'icon' => 'list-view',
		'desc' => __( 'Searchable directories with ten listing types, ratings, maps, and front-end submissions.', 'shortcodes-for-buddypress' ),
		'url'  => 'https://wbcomdesigns.com/downloads/listora/',
	),
	array(
		'name' => __( 'WP Career Board', 'shortcodes-for-buddypress' ),
		'logo' => 'wp-career-board.svg',
		'icon' => 'businessman',
		'desc' => __( 'Add a job board with front-end listings, applications, and employer profiles.', 'shortcodes-for-buddypress' ),
		'url'  => 'https://wbcomdesigns.com/downloads/wp-career-board/',
	),
	array(
		'name' => __( 'Learnomy', 'shortcodes-for-buddypress' ),
		'logo' => 'learnomy.svg',
		'icon' => 'welcome-learn-more',
		'desc' => __( 'Create, sell, and auto-grade online courses, then hand out certificates automatically.', 'shortcodes-for-buddypress' ),
		'url'  => 'https://wbcomdesigns.com/downloads/learnomy/',
	),
);
?>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'More Free Tools from Wbcom Designs', 'shortcodes-for-buddypress' ); ?></p>
		<p class="bpsp-card__desc"><?php esc_html_e( 'Shortcodes For BuddyPress embeds your community anywhere. These free tools from Wbcom Designs build out the community itself: the theme and network, forums, media, events, gamification, directories, jobs, and courses.', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<div class="bpsp-discover-grid">
			<?php foreach ( $bpsp_ecosystem as $bpsp_product ) : ?>
				<div class="bpsp-discover-card">
					<span class="bpsp-discover-card__logo" aria-hidden="true">
						<?php if ( file_exists( $bpsp_ecosystem_dir . $bpsp_product['logo'] ) ) : ?>
							<img src="<?php echo esc_url( $bpsp_ecosystem_url . $bpsp_product['logo'] ); ?>" alt="<?php echo esc_attr( $bpsp_product['name'] ); ?>" width="52" height="52" loading="lazy" />
						<?php else : ?>
							<span class="dashicons dashicons-<?php echo esc_attr( isset( $bpsp_product['icon'] ) ? $bpsp_product['icon'] : 'admin-plugins' ); ?>"></span>
						<?php endif; ?>
					</span>
					<h3 class="bpsp-discover-card__title"><?php echo esc_html( $bpsp_product['name'] ); ?></h3>
					<p class="bpsp-discover-card__desc"><?php echo esc_html( $bpsp_product['desc'] ); ?></p>
					<a class="bpsp-btn bpsp-btn-secondary bpsp-discover-card__cta" href="<?php echo esc_url( $bpsp_product['url'] ); ?>" target="_blank" rel="noopener">
						<?php esc_html_e( 'Get it free', 'shortcodes-for-buddypress' ); ?>
						<span class="dashicons dashicons-external" aria-hidden="true"></span>
						<span class="screen-reader-text">
							<?php
							/* translators: %s: product name. */
							echo esc_html( sprintf( __( '%s (opens in a new tab)', 'shortcodes-for-buddypress' ), $bpsp_product['name'] ) );
							?>
						</span>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php
/**
 * Overview dashboard partial: rendered inside layout.php.
 *
 * Summarizes the 3 shortcodes + 3 Elementor widgets this plugin
 * provides and reports which BuddyPress components are active so the
 * site owner knows which shortcodes will work. This plugin has no
 * tables and no settings, so there are no usage stats to query.
 *
 * @package Shortcodes_For_Buddypress
 * @since   3.0.0
 */

defined( 'ABSPATH' ) || exit;

$bpsp_page_url = admin_url( 'admin.php?page=' . Shortcodes_For_Buddypress_Admin_Panel::MENU_SLUG );

$bpsp_bp_active       = function_exists( 'bp_is_active' );
$bpsp_activity_active = $bpsp_bp_active && bp_is_active( 'activity' );
$bpsp_members_active  = $bpsp_bp_active && bp_is_active( 'members' );
$bpsp_groups_active   = $bpsp_bp_active && bp_is_active( 'groups' );
$bpsp_elementor_on    = did_action( 'elementor/loaded' ) || defined( 'ELEMENTOR_VERSION' );

// Count how many of the three shortcodes are actually usable right now.
$bpsp_ready = (int) $bpsp_activity_active + (int) $bpsp_members_active + (int) $bpsp_groups_active;

$bpsp_shortcodes = array(
	array(
		'tag'    => '[activity-listing]',
		'label'  => __( 'Activity Stream', 'shortcodes-for-buddypress' ),
		'desc'   => __( 'Embed a BuddyPress activity feed with filtering, pagination, and load-more.', 'shortcodes-for-buddypress' ),
		'tab'    => 'activities',
		'ready'  => $bpsp_activity_active,
		'widget' => __( 'BuddyPress Activity', 'shortcodes-for-buddypress' ),
	),
	array(
		'tag'    => '[members-listing]',
		'label'  => __( 'Members Directory', 'shortcodes-for-buddypress' ),
		'desc'   => __( 'Display a members directory with grid/list layouts and advanced filters.', 'shortcodes-for-buddypress' ),
		'tab'    => 'members',
		'ready'  => $bpsp_members_active,
		'widget' => __( 'BuddyPress Members', 'shortcodes-for-buddypress' ),
	),
	array(
		'tag'    => '[groups-listing]',
		'label'  => __( 'Groups Listing', 'shortcodes-for-buddypress' ),
		'desc'   => __( 'Show groups with privacy controls, member counts, and activity sorting.', 'shortcodes-for-buddypress' ),
		'tab'    => 'groups',
		'ready'  => $bpsp_groups_active,
		'widget' => __( 'BuddyPress Groups', 'shortcodes-for-buddypress' ),
	),
);
?>

<?php if ( ! $bpsp_bp_active ) : ?>
	<div class="bpsp-notice bpsp-notice--warn">
		<span class="dashicons dashicons-warning" aria-hidden="true"></span>
		<span><?php esc_html_e( 'BuddyPress (or BuddyBoss) is not active. The shortcodes and widgets need BuddyPress to display activities, members, or groups.', 'shortcodes-for-buddypress' ); ?></span>
	</div>
<?php endif; ?>

<div class="bpsp-stats-grid">
	<div class="bpsp-stat">
		<p class="bpsp-stat__label"><?php esc_html_e( 'Shortcodes', 'shortcodes-for-buddypress' ); ?></p>
		<p class="bpsp-stat__value">3</p>
		<p class="bpsp-stat__trend"><?php esc_html_e( 'Activity, Members, Groups', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-stat">
		<p class="bpsp-stat__label"><?php esc_html_e( 'Elementor Widgets', 'shortcodes-for-buddypress' ); ?></p>
		<p class="bpsp-stat__value">3</p>
		<p class="bpsp-stat__trend">
			<?php
			echo $bpsp_elementor_on
				? esc_html__( 'Elementor active - widgets available', 'shortcodes-for-buddypress' )
				: esc_html__( 'Available when Elementor is active', 'shortcodes-for-buddypress' );
			?>
		</p>
	</div>
	<div class="bpsp-stat">
		<p class="bpsp-stat__label"><?php esc_html_e( 'Ready To Use', 'shortcodes-for-buddypress' ); ?></p>
		<p class="bpsp-stat__value"><?php echo esc_html( number_format_i18n( $bpsp_ready ) ); ?> / 3</p>
		<p class="bpsp-stat__trend"><?php esc_html_e( 'Shortcodes whose component is active', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-stat">
		<p class="bpsp-stat__label"><?php esc_html_e( 'Template Pack', 'shortcodes-for-buddypress' ); ?></p>
		<p class="bpsp-stat__value">1</p>
		<p class="bpsp-stat__trend"><?php esc_html_e( 'Nouveau, with BuddyBoss variants', 'shortcodes-for-buddypress' ); ?></p>
	</div>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Available Shortcodes & Widgets', 'shortcodes-for-buddypress' ); ?></p>
		<p class="bpsp-card__desc"><?php esc_html_e( 'Each shortcode has a matching Elementor widget. Open a reference tab for every parameter.', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<div class="bpsp-doc-grid">
			<?php foreach ( $bpsp_shortcodes as $bpsp_sc ) : ?>
				<div class="bpsp-doc-tile">
					<h5><?php echo esc_html( $bpsp_sc['label'] ); ?></h5>
					<code class="bpsp-code-block"><?php echo esc_html( $bpsp_sc['tag'] ); ?></code>
					<p><?php echo esc_html( $bpsp_sc['desc'] ); ?></p>
					<p>
						<?php if ( $bpsp_sc['ready'] ) : ?>
							<span class="bpsp-status-yes"><?php esc_html_e( 'Component active', 'shortcodes-for-buddypress' ); ?></span>
						<?php else : ?>
							<span class="bpsp-status-off"><?php esc_html_e( 'Component inactive', 'shortcodes-for-buddypress' ); ?></span>
						<?php endif; ?>
					</p>
					<p>
						<?php
						echo esc_html(
							sprintf(
								/* translators: %s: Elementor widget name. */
								__( 'Elementor widget: %s', 'shortcodes-for-buddypress' ),
								$bpsp_sc['widget']
							)
						);
						?>
					</p>
					<div class="bpsp-doc-actions">
						<a href="<?php echo esc_url( $bpsp_page_url . '&tab=' . $bpsp_sc['tab'] ); ?>" class="bpsp-btn bpsp-btn-secondary">
							<?php esc_html_e( 'View Parameters', 'shortcodes-for-buddypress' ); ?>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Component Status', 'shortcodes-for-buddypress' ); ?></p>
		<p class="bpsp-card__desc"><?php esc_html_e( 'A shortcode only renders when its BuddyPress component is active.', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<table class="form-table">
		<tr>
			<th scope="row"><?php esc_html_e( 'BuddyPress', 'shortcodes-for-buddypress' ); ?></th>
			<td>
				<?php if ( $bpsp_bp_active ) : ?>
					<span class="bpsp-status-yes"><?php esc_html_e( 'Active', 'shortcodes-for-buddypress' ); ?></span>
				<?php else : ?>
					<span class="bpsp-status-no"><?php esc_html_e( 'Not active', 'shortcodes-for-buddypress' ); ?></span>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Activity Component', 'shortcodes-for-buddypress' ); ?></th>
			<td>
				<?php if ( $bpsp_activity_active ) : ?>
					<span class="bpsp-status-yes"><?php esc_html_e( 'Active', 'shortcodes-for-buddypress' ); ?></span>
				<?php else : ?>
					<span class="bpsp-status-off"><?php esc_html_e( 'Inactive - [activity-listing] will not render', 'shortcodes-for-buddypress' ); ?></span>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Members Component', 'shortcodes-for-buddypress' ); ?></th>
			<td>
				<?php if ( $bpsp_members_active ) : ?>
					<span class="bpsp-status-yes"><?php esc_html_e( 'Active', 'shortcodes-for-buddypress' ); ?></span>
				<?php else : ?>
					<span class="bpsp-status-off"><?php esc_html_e( 'Inactive - [members-listing] will not render', 'shortcodes-for-buddypress' ); ?></span>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Groups Component', 'shortcodes-for-buddypress' ); ?></th>
			<td>
				<?php if ( $bpsp_groups_active ) : ?>
					<span class="bpsp-status-yes"><?php esc_html_e( 'Active', 'shortcodes-for-buddypress' ); ?></span>
				<?php else : ?>
					<span class="bpsp-status-off"><?php esc_html_e( 'Inactive - [groups-listing] will not render', 'shortcodes-for-buddypress' ); ?></span>
				<?php endif; ?>
			</td>
		</tr>
	</table>
</div>

<div class="bpsp-card">
	<div class="bpsp-card__head">
		<p class="bpsp-card__title"><?php esc_html_e( 'Quick Start', 'shortcodes-for-buddypress' ); ?></p>
	</div>
	<div class="bpsp-card__body">
		<ol class="bpsp-doc-list">
			<li><?php esc_html_e( 'Pick a shortcode - activity, members, or groups.', 'shortcodes-for-buddypress' ); ?></li>
			<li><?php esc_html_e( 'Paste it into any post, page, or widget area.', 'shortcodes-for-buddypress' ); ?></li>
			<li><?php esc_html_e( 'Add parameters to control layout, filtering, and pagination. See the reference tabs for the full list.', 'shortcodes-for-buddypress' ); ?></li>
		</ol>
	</div>
</div>

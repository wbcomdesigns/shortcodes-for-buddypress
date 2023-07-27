<?php
/**
 * BuddyPress Members Directory
 *
 * @version 3.0.0
 */
global $members_atts;

$current_members_component = static function () {
	return 'members';
};

add_filter( 'bp_current_component', $current_members_component );

$members_ajax_querystring = static function ( $ajax_querystring, $object ) {
	global $members_atts;
	$qs = '';
	return $qs .= $members_atts['bpsh_query'];
};

add_filter( 'bp_ajax_querystring', $members_ajax_querystring, 99, 2 );

$classes = array();
$member_loop_classes = static function () use ( $classes ) {

	$classes[] = 'item-list';
	$classes[] = 'members-list';
	$classes[] = 'bp-list';

	$bp_nouveau_appearance = get_option( 'bp_nouveau_appearance' );
	$members_layout        = ( isset( $bp_nouveau_appearance['members_layout'] ) && $bp_nouveau_appearance['members_layout'] != '' ) ? $bp_nouveau_appearance['members_layout'] : '3';

	if ( function_exists( 'bp_nouveau_customizer_grid_choices' ) ) {
		$grid_classes = bp_nouveau_customizer_grid_choices( 'classes' );
		if ( isset( $grid_classes[ $members_layout ] ) ) {
			$classes = array_merge(
				$classes,
				array(
					'grid',
					$grid_classes[ $members_layout ],
				)
			);
		}
	} else {
		$classes = array_merge(
			$classes,
			array(
				'grid',
				'three',
			)
		);
	}

	return $classes;
};
add_filter( 'bp_nouveau_get_loop_classes', $member_loop_classes );

?>

<div id="buddypress" class="buddypress-wrap bp-dir-hori-nav <?php echo esc_attr( $members_atts['container_class'] ); ?>">
	<?php bp_nouveau_before_members_directory_content(); ?>

	<div class="screen-content">
		<input type="hidden" data-bp-filter="members" value="<?php echo $members_atts['bpsh_query']?>" />
		<div id="members-dir-list" class="members dir-list" data-bp-list="members" data-ajax="true">
			<?php bp_get_template_part( 'members/members-loop' ); ?>
		</div>

		<?php bp_nouveau_after_members_directory_content(); ?>
	</div>
</div>
<?php
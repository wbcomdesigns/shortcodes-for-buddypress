<?php
/**
 * BP Nouveau - Groups Directory
 *
 * @since 3.0.0
 * @version 3.0.0
 */
global $groups_atts;
$current_group_component        = static function () {
	return 'groups';
};
add_filter( 'bp_current_component', $current_group_component );

$members_ajax_querystring = static function ( $ajax_querystring, $object ) {
	global $groups_atts;
	$qs = '';
	return $qs .= $groups_atts['bpsh_query'];
};

add_filter( 'bp_ajax_querystring', $members_ajax_querystring, 99, 2 );

$classes = array();
$group_loop_classes = static function () use ( $classes ) {
	$classes[] = 'item-list';
	$classes[] = 'groups-list';
	$classes[] = 'bp-list';
	$bp_nouveau_appearance = get_option( 'bp_nouveau_appearance' );
	$groups_layout         = ( isset( $bp_nouveau_appearance['groups_layout'] ) && $bp_nouveau_appearance['groups_layout'] != '' ) ? $bp_nouveau_appearance['groups_layout'] : '3';

	if ( function_exists( 'bp_nouveau_customizer_grid_choices' ) ) {
		$grid_classes = bp_nouveau_customizer_grid_choices( 'classes' );
		if ( isset( $grid_classes[ $groups_layout ] ) ) {
			$classes = array_merge(
				$classes,
				array(
					'grid',
					$grid_classes[ $groups_layout ],
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
add_filter( 'bp_nouveau_get_loop_classes', $group_loop_classes );
?>

<div id="buddypress" class="bp-dir-hori-nav <?php echo esc_attr( bp_nouveau_get_container_classes() ). ' '. esc_attr( $groups_atts['container_class'] ); ?>">
	<?php bp_nouveau_before_groups_directory_content(); ?>
	<?php bp_nouveau_template_notices(); ?>

	<div class="screen-content">
		<input type="hidden" data-bp-filter="groups" value="<?php echo $groups_atts['bpsh_query']?>" />
		<div id="groups-dir-list" class="groups dir-list" data-bp-list="groups" data-ajax="true">
			<?php bp_get_template_part( 'groups/groups-loop' ); ?>
		</div>

		<?php bp_nouveau_after_groups_directory_content(); ?>
	</div>
</div>
<?php
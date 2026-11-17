<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName -- Legacy file name.
/**
 * Group shortcode handler.
 *
 * @package Shortcodes_For_Buddypress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Groups shortcode class.
 *
 * @package    Shortcodes_For_Buddypress
 * @subpackage Shortcodes_For_Buddypress/shortcode
 * @since      1.7.0
 */
class GroupShortCode extends BPShortCode {

	/**
	 * Group sort types BuddyPress accepts.
	 *
	 * @var string[]
	 */
	protected $allowed_types = array( 'active', 'newest', 'popular', 'random', 'alphabetical', 'most-forum-topics', 'most-forum-posts' );

	/**
	 * Set default attributes.
	 */
	protected function set_defaults() {
		$this->defaults = array(
			'title'              => '',
			'type'               => 'alphabetical',
			'order'              => 'DESC',
			'orderby'            => 'last_activity',
			'page'               => 1,
			'per_page'           => 20,
			'max'                => false,
			'show_hidden'        => false,
			'status'             => '',
			'page_arg'           => 'grpage',
			'user_id'            => false,
			'slug'               => false,
			'search_terms'       => false,
			'group_type'         => false,
			'group_type__in'     => '',
			'group_type__not_in' => '',
			'meta_query'         => false,
			'use_compat'         => function_exists( 'bp_use_theme_compat_with_current_theme' )
				? bp_use_theme_compat_with_current_theme()
				: '',
			'include'            => false,
			'exclude'            => false,
			'parent_id'          => 0,
			'update_meta_cache'  => true,
			'container_class'    => 'group',
			'grid'               => 'yes',
			'loop_layout'        => 'three',
		);
	}

	/**
	 * Output shortcode HTML.
	 *
	 * @param array  $atts    Attributes.
	 * @param string $content Content.
	 * @return string
	 */
	protected function output( $atts, $content = '' ) {

		// Get query args and template variables.
		$query         = $this->get_query_args( $atts );
		$template_vars = $this->get_template_vars( $atts, $query );

		// Generate HTML output.
		return $this->generate_html( $atts, $template_vars );
	}

	/**
	 * Get query arguments.
	 *
	 * @param array $atts Attributes.
	 * @return array
	 */
	private function get_query_args( $atts ) {
		$query_args = array(
			'include'            => $atts['include'],
			'exclude'            => $atts['exclude'],
			'type'               => $atts['type'],
			'page'               => $atts['page'],
			'per_page'           => $atts['per_page'],
			'max'                => $atts['max'],
			'show_hidden'        => $atts['show_hidden'],
			'status'             => $atts['status'],
			'user_id'            => $atts['user_id'],
			'slug'               => $atts['slug'],
			'search_terms'       => $atts['search_terms'],
			'order'              => $atts['order'],
			'orderby'            => $atts['orderby'],
			'group_type'         => $atts['group_type'],
			'group_type__in'     => $atts['group_type__in'],
			'group_type__not_in' => $atts['group_type__not_in'],
			'meta_query'         => $atts['meta_query'],
			'parent_id'          => $atts['parent_id'],
			'update_meta_cache'  => $atts['update_meta_cache'],
		);

		/*
		 * `type` wins over `orderby`/`order` inside bp_has_groups(), and this
		 * shortcode always sent its default type=alphabetical. That silently
		 * discarded both ordering attributes: [groups-listing orderby="name"
		 * order="DESC"] returned exactly the same groups in the same order as
		 * order="ASC". When the caller sets either ordering attribute, drop
		 * the default type so their choice actually applies. An explicit
		 * type= still takes priority, matching BuddyPress.
		 */
		$ordering_customised = ( 'DESC' !== $atts['order'] || 'last_activity' !== $atts['orderby'] );
		if ( $ordering_customised && 'alphabetical' === $atts['type'] ) {
			unset( $query_args['type'] );
		}

		// Remove empty values to avoid issues with BuddyPress query.
		$query_args = array_filter(
			$query_args,
			function ( $value ) {
				return false !== $value && '' !== $value && null !== $value;
			}
		);

		return apply_filters( 'group_shortcode_bash_query_args', $query_args );
	}

	/**
	 * Get template variables.
	 *
	 * @param array $atts  Attributes.
	 * @param array $query Query arguments.
	 * @return array
	 */
	private function get_template_vars( $atts, $query ) {
		// Build query string.
		$query_string = $this->build_query_string( $query );

		// Determine grid settings.
		$grid   = 'yes' === $atts['grid'] ? 'grid' : '';
		$column = ( $grid && $atts['loop_layout'] ) ? $atts['loop_layout'] : '';

		$args = array(
			'query'       => $query_string,
			'grid'        => $grid,
			'column'      => $column,
			'classes'     => $this->get_container_classes( $grid, $column ),
			'groups_atts' => $query,
		);

		return apply_filters( 'group_shortcode_template_args', $args );
	}

	/**
	 * Build query string.
	 *
	 * @param array $query_args Query arguments.
	 * @return string
	 */
	private function build_query_string( $query_args ) {
		$query_parts = array();

		foreach ( $query_args as $key => $value ) {
			if ( false !== $value && '' !== $value ) {
				$query_parts[] = $key . '=' . $value;
			}
		}

		return implode( '&', $query_parts );
	}

	/**
	 * Generate HTML.
	 *
	 * @param array $atts          Attributes.
	 * @param array $template_vars Template variables.
	 * @return string
	 */
	private function generate_html( $atts, $template_vars ) {
		do_action( 'before_group_shortcode_render', $atts );

		ob_start();

		if ( ! function_exists( 'bp_is_active' ) || ! bp_is_active( 'groups' ) ) {
			$this->show_disabled_message();
		} else {
			$this->show_groups( $atts, $template_vars );
		}

		$output = ob_get_clean();

		do_action( 'after_group_shortcode_render', $template_vars );

		return apply_filters( 'group_shortcode_output', $output );
	}

	/**
	 * Show disabled message.
	 */
	private function show_disabled_message() {
		$this->render_disabled_notice(
			__( 'To view groups, please enable the group component.', 'shortcodes-for-buddypress' )
		);
	}

	/**
	 * Show groups.
	 *
	 * @param array $atts          Attributes.
	 * @param array $template_vars Template variables.
	 */
	private function show_groups( $atts, $template_vars ) {
		?>
		<div class="groups-listing <?php echo esc_attr( $atts['container_class'] ); ?>">
			<?php if ( ! empty( $atts['title'] ) ) : ?>
				<h4><?php echo esc_html( $atts['title'] ); ?></h4>
			<?php endif; ?>

			<?php do_action( 'group_shortcode_inside_container', $atts, $template_vars ); ?>

			<?php $this->load_template( $template_vars ); ?>
		</div>
		<?php
	}

	/**
	 * Load template.
	 *
	 * @param array $template_vars Template variables.
	 */
	private function load_template( $template_vars ) {
		$template = ( function_exists( 'buddypress' ) && buddypress()->buddyboss )
			? 'groups/bb-shortcodes-groups.php'
			: 'groups/bp-shortcodes-groups.php';

		bp_shortcode_get_template( $template, $template_vars );
	}

	/**
	 * Get container classes.
	 *
	 * @param string $grid   Grid class.
	 * @param string $column Column class.
	 * @return string
	 */
	private function get_container_classes( $grid, $column ) {
		return $this->list_classes( array( 'item-list', 'groups-list', 'groups-dir-list', 'bp-list', 'bpsp-groups-list', $grid, $column ) );
	}
}

GroupShortCode::get_instance( 'groups-listing' );

<?php
/**
 * This file is used for rendering and saving plugin performance settings.
 *
 * @link       www.wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    shortcodes-for-buddypress
 * @subpackage shortcodes-for-buddypress/admin/settings/performance-settings
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
    // Display community size information
    if (function_exists('bp_core_get_active_member_count')) {
        $member_count = bp_core_get_active_member_count();
        $size_class = 'small';
        
        if ($member_count > 10000) {
            $size_class = 'very-large';
        } elseif ($member_count > 5000) {
            $size_class = 'large';
        } elseif ($member_count > 1000) {
            $size_class = 'medium';
        }
        
        
    }

    $settings = get_option('bpsh_performance_settings', array());
    $cache_duration = isset($settings['cache_duration']) ? $settings['cache_duration'] : 5;
    
		$max_items = isset($settings['max_items']) ? $settings['max_items'] : 100;
		
		?>
<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-admin-title-section">
			<h3 class="wbcom-welcome-title"><?php esc_html_e( 'Performance Settings', 'bp-business-profile' ); ?></h3>			
		</div><!-- .wbcom-welcome-head -->
		<div class="wbcom-business-profile-wrapper">
			<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">	
				<form method="post" action="options.php">
					<?php
					settings_fields( 'bpsh_settings_group' );
					do_settings_sections( 'bpsh_settings_group' );	
                     echo '<p>' . esc_html__('Configure performance settings for BuddyPress shortcodes. These settings help optimize the plugin for your community size.', 'shortcodes-for-buddypress') . '</p>';				
					echo '<p>' . sprintf(
            esc_html__('Your community has %d active members and is classified as %s.', 'shortcodes-for-buddypress'),
            $member_count,
            '<strong>' . esc_html($size_class) . '</strong>'
        ) . '</p>';
                    ?>
					<div class="form-table">
												
						<div class="wbcom-settings-section-wrap">
							<div class="wbcom-settings-section-options-heading">
								<label for="singular_label">
									<?php esc_html_e( 'Maximum Items', 'bp-business-profile' ); ?>
								</label>
								<p class="description"><?php esc_html_e('Maximum number of items to display in shortcodes for large communities. Lower values improve performance.', 'shortcodes-for-buddypress'); ?></p>
							</div>
							<div class="wbcom-settings-section-options">
								<input type="number" name="bpsh_performance_settings[max_items]" value="<?php echo esc_attr($max_items); ?>" min="10" max="500" step="10" />
							</div>
						</div>
						
						<div class="wbcom-settings-section-wrap">
							<div class="wbcom-settings-section-options-heading">
								<label><?php esc_html_e( 'Cache Duration', 'bp-business-profile' ); ?></label>
								<p class="description"><?php esc_html_e( 'How long to cache query results. Shorter times mean more frequent updates but higher server load.', 'bp-business-profile' ); ?></p>
							</div>
							<div class="wbcom-settings-section-options">					
								<select name="bpsh_performance_settings[cache_duration]">
                                    <option value="1" <?php selected($cache_duration, 1); ?>><?php esc_html_e('1 minute (for very large communities)', 'shortcodes-for-buddypress'); ?></option>
                                    <option value="2" <?php selected($cache_duration, 2); ?>><?php esc_html_e('2 minutes (for large communities)', 'shortcodes-for-buddypress'); ?></option>
                                    <option value="5" <?php selected($cache_duration, 5); ?>><?php esc_html_e('5 minutes (default)', 'shortcodes-for-buddypress'); ?></option>
                                    <option value="10" <?php selected($cache_duration, 10); ?>><?php esc_html_e('10 minutes (for small communities)', 'shortcodes-for-buddypress'); ?></option>
                                    <option value="15" <?php selected($cache_duration, 15); ?>><?php esc_html_e('15 minutes (for very small communities)', 'shortcodes-for-buddypress'); ?></option>
                                </select>
							</div>
						</div>

						<?php do_action( 'bp_business_profile_add_general_setting_options' ); ?>
					</div>
					<?php submit_button(); ?>
				</form>
			</div>
		</div>
	</div>
</div>

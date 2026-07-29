(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 
	$(document).ready( function() {
		
		// Main BuddyPress Shortcode object
		var BPSH = {
			/**
			 * Initialize the plugin
			 */
			init: function() {
				this.setupEventListeners();
				this.setupLoadMore();
			},
			
			/**
			 * Set up event listeners using event delegation
			 */
			setupEventListeners: function() {
				// Use document for event delegation to handle dynamically loaded content
				$(document)
					.on('click', '#aw-whats-new-reset, #aw-whats-new-submit', this.handleActivityFormActions);
				// Activity load-more is wired in setupLoadMore(); the old
				// '.bpsh-load-more' binding referenced an undefined handler and a
				// selector that no template renders, so it only threw on load.
			},
			
			/**
			 * Handle activity form reset/submit
			 */
			handleActivityFormActions: function() {
				bp.Nouveau.setStorage('bp-activity', 'filter', '');
				setTimeout(function() {
					bp.Nouveau.setStorage('bp-activity', 'filter', $('#activity_filters_objects').val());
				}, 300);
			},
			
			/**
			 * Set up load more functionality
			 */
			setupLoadMore: function() {
				// Unbind previous handlers to prevent duplication
				$('#buddypress [data-bp-list="activity"]').off('click', 'li.load-newest, li.load-more');
				
				// Use event delegation for better performance
				$('#buddypress [data-bp-list="activity"]').on('click', 'li.load-newest, li.load-more', this.handleActivityLoadMore);
			},
			
			/**
			 * Handle load more clicks for activity
			 */
			handleActivityLoadMore: function(e) {
				e.preventDefault();
				var self = $(this);
				var page = self.data('page');
				var limit = self.data('limit');
				var loadMoreLink = self.children().first();
				
				// Show loading state
				loadMoreLink.addClass('loading');
				
				// Send AJAX request
				$.ajax({
					type: "post",
					url: buddypress_shortcode.ajax_url,
					data: {
						'action': 'bpsp_activities_load',
						'page': page,
						'limit': limit,
						'nonce': buddypress_shortcode.ajax_nonce,
					},
					success: function(res) {
						if (true === res.success) {
							// Insert new content
							$(e.currentTarget).before(res.data);
							
							// Update page counter for next load
							var newPage = page + 1;
							self.data('page', newPage);
						}
					},
					complete: function() {
						// Remove loading state
						loadMoreLink.removeClass('loading');
					}
				});
			}
		};
    
		// Initialize on document ready
		$(document).ready(function() {
			BPSH.init();
		});


	});

})( jQuery );

/**
 * Shortcodes & Elementor Widgets For BuddyPress: Admin JS.
 *
 * Toast + confirm helpers for the card-panel admin. Skill Part 6
 * rules 10 + 12: no browser alert()/confirm() anywhere. Exposes
 * window.bpspToast() and window.bpspConfirm() so this file and any
 * future extension can share one feedback surface.
 *
 * This plugin persists no settings and its admin tabs are
 * informational doc panels, so there are no save forms or AJAX
 * actions to wire here — the helpers are kept for consistency with
 * the rest of the Wbcom card-panel bundle and to back any
 * data-bpsp-confirm links.
 *
 * @since 3.0.0
 */
( function ( $ ) {
	'use strict';

	var i18n = ( window.bpspAdmin && window.bpspAdmin.i18n ) || {};

	/* ─── Toast ─────────────────────────────────────────────── */

	function getToastHost() {
		var host = document.querySelector( '.bpsp-toast-host' );
		if ( ! host ) {
			host = document.createElement( 'div' );
			host.className = 'bpsp-toast-host';
			document.body.appendChild( host );
		}
		return host;
	}

	function toast( message, tone ) {
		tone = tone || 'info';
		var host = getToastHost();
		var el   = document.createElement( 'div' );
		el.className   = 'bpsp-toast bpsp-toast--' + tone;
		el.setAttribute( 'role', 'status' );
		el.textContent = String( message );
		host.appendChild( el );

		requestAnimationFrame( function () {
			el.classList.add( 'bpsp-toast--visible' );
		} );

		window.setTimeout( function () {
			el.classList.remove( 'bpsp-toast--visible' );
			window.setTimeout( function () {
				if ( el.parentNode ) {
					el.parentNode.removeChild( el );
				}
			}, 250 );
		}, 3600 );
	}

	window.bpspToast = toast;

	/* ─── Confirm modal (returns a Promise) ──────────────────── */

	function confirmModal( opts ) {
		opts = opts || {};
		return new Promise( function ( resolve ) {
			var backdrop = document.createElement( 'div' );
			backdrop.className = 'bpsp-confirm-backdrop';

			var card = document.createElement( 'div' );
			card.className = 'bpsp-confirm';
			card.setAttribute( 'role', 'dialog' );
			card.setAttribute( 'aria-modal', 'true' );

			var title = document.createElement( 'h2' );
			title.className = 'bpsp-confirm__title';
			title.textContent = opts.title || '';
			if ( opts.title ) { card.appendChild( title ); }

			var desc = document.createElement( 'p' );
			desc.className = 'bpsp-confirm__desc';
			desc.textContent = opts.message || i18n.confirmDanger || '';
			if ( opts.message || i18n.confirmDanger ) { card.appendChild( desc ); }

			var actions = document.createElement( 'div' );
			actions.className = 'bpsp-confirm__actions';

			var cancelBtn = document.createElement( 'button' );
			cancelBtn.type = 'button';
			cancelBtn.className = 'bpsp-btn bpsp-btn-secondary';
			cancelBtn.textContent = opts.cancelLabel || i18n.confirmCancel || 'Cancel';

			var confirmBtn = document.createElement( 'button' );
			confirmBtn.type = 'button';
			confirmBtn.className = 'bpsp-btn ' + ( 'danger' === opts.tone ? 'bpsp-btn-danger' : 'bpsp-btn-primary' );
			confirmBtn.textContent = opts.confirmLabel || i18n.confirmContinue || 'Continue';

			actions.appendChild( cancelBtn );
			actions.appendChild( confirmBtn );
			card.appendChild( actions );
			backdrop.appendChild( card );
			document.body.appendChild( backdrop );

			function cleanup( result ) {
				document.removeEventListener( 'keydown', onKey );
				if ( backdrop.parentNode ) {
					backdrop.parentNode.removeChild( backdrop );
				}
				resolve( result );
			}

			function onKey( e ) {
				if ( 'Escape' === e.key ) { cleanup( false ); }
				if ( 'Enter' === e.key ) { cleanup( true ); }
			}

			cancelBtn.addEventListener( 'click', function () { cleanup( false ); } );
			confirmBtn.addEventListener( 'click', function () { cleanup( true ); } );
			backdrop.addEventListener( 'click', function ( e ) {
				if ( e.target === backdrop ) { cleanup( false ); }
			} );
			document.addEventListener( 'keydown', onKey );
			confirmBtn.focus();
		} );
	}

	window.bpspConfirm = confirmModal;

	/* ─── Generic confirm intercept for [data-bpsp-confirm] links ── */

	$( function () {
		$( document ).on( 'click', '[data-bpsp-confirm]', function ( e ) {
			var $el = $( this );
			// Buttons that own their own handler manage their own flow.
			if ( $el.attr( 'data-action' ) ) { return; }
			if ( $el.data( 'bpsp-confirm-ok' ) ) { return; }
			e.preventDefault();
			var message = $el.data( 'bpsp-confirm' ) || i18n.confirmDanger;
			var tone    = $el.data( 'bpsp-confirm-tone' ) || 'danger';
			confirmModal( { message: message, tone: tone } ).then( function ( ok ) {
				if ( ! ok ) { return; }
				$el.data( 'bpsp-confirm-ok', true );
				if ( $el.is( 'a' ) ) {
					window.location.href = $el.attr( 'href' );
				}
			} );
		} );
	} );

} )( jQuery );

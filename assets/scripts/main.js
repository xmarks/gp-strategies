/**
 * File main.js
 *
 * Main Theme scripts.
 *
 * @package Gp_Strategies
 */

console.log( 'theme main script loaded...' );

/**
 * Search Widget Toggle
 *
 * - Initially only the submit button is visible
 * - Click button to reveal the search input
 * - Click button again to submit the form
 * - Click outside to close the search
 */
( function () {
	const searchWidgets = document.querySelectorAll( '.elementor-widget-search' );

	if ( ! searchWidgets.length ) {
		return;
	}

	searchWidgets.forEach( ( widget ) => {
		const form = widget.querySelector( '.e-search-form' );
		const submitButton = widget.querySelector( '.e-search-submit' );
		const input = widget.querySelector( '.e-search-input' );

		if ( ! form || ! submitButton || ! input ) {
			return;
		}

		// Handle submit button click.
		submitButton.addEventListener( 'click', function ( event ) {
			if ( ! widget.classList.contains( 'is-open' ) ) {
				// Search is closed - open it and focus input.
				event.preventDefault();
				widget.classList.add( 'is-open' );
				input.focus();
			}
			// If already open, let the form submit naturally.
		} );

		// Handle click outside to close.
		document.addEventListener( 'click', function ( event ) {
			if ( ! widget.contains( event.target ) && widget.classList.contains( 'is-open' ) ) {
				widget.classList.remove( 'is-open' );
			}
		} );

		// Close on Escape key.
		input.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' ) {
				widget.classList.remove( 'is-open' );
				submitButton.focus();
			}
		} );
	} );
}() );

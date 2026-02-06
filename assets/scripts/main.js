/**
 * File main.js
 *
 * Main Theme scripts.
 *
 * @package Gp_Strategies
 */

/**
 * Search Widget Toggle
 *
 * - Initially only the submit button is visible
 * - Click button to reveal the search input
 * - Click button again to submit the form
 * - Click outside to close the search
 */
(function () {
    const searchWidgets = document.querySelectorAll( '.elementor-widget-search' );

    if (!searchWidgets.length) {
        return;
    }

    searchWidgets.forEach( ( widget ) => {
        const form = widget.querySelector( '.e-search-form' );
        const submitButton = widget.querySelector( '.e-search-submit' );
        const input = widget.querySelector( '.e-search-input' );

        if (!form || !submitButton || !input) {
            return;
        }

        // Handle submit button click.
        submitButton.addEventListener( 'click', function ( event ) {
            if (!widget.classList.contains( 'is-open' )) {
                // Search is closed - open it and focus input.
                event.preventDefault();
                widget.classList.add( 'is-open' );
                input.focus();
            }
            // If already open, let the form submit naturally.
        } );

        // Handle click outside to close.
        document.addEventListener( 'click', function ( event ) {
            if (!widget.contains( event.target ) && widget.classList.contains( 'is-open' )) {
                widget.classList.remove( 'is-open' );
            }
        } );

        // Close on Escape key.
        input.addEventListener( 'keydown', function ( event ) {
            if (event.key === 'Escape') {
                widget.classList.remove( 'is-open' );
                submitButton.focus();
            }
        } );
    } );
}());


/**
 * Play Button - Hover Text Swap
 *
 * Swaps .elementor-button-text content with the data-hover-text
 * attribute value on hover/focus, reverts on leave.
 */
(function () {
    const playButtons = document.querySelectorAll( '.gp-btn--play[data-hover-text]' );

    if ( ! playButtons.length ) {
        return;
    }

    playButtons.forEach( ( widget ) => {
        const hoverText = widget.getAttribute( 'data-hover-text' );
        const textEl    = widget.querySelector( '.elementor-button-text' );

        if ( ! textEl || ! hoverText ) {
            return;
        }

        const originalText = textEl.textContent;
        const anchor       = widget.querySelector( '.elementor-button' );

        function swapIn() {
            textEl.textContent = hoverText;
        }

        function swapOut() {
            textEl.textContent = originalText;
        }

        if ( anchor ) {
            anchor.addEventListener( 'mouseenter', swapIn );
            anchor.addEventListener( 'mouseleave', swapOut );
            anchor.addEventListener( 'focus', swapIn );
            anchor.addEventListener( 'blur', swapOut );
        }
    } );
}());

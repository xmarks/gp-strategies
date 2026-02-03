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


(function () {
    function scopeToElement( scope ) {
        // Works if Elementor passes a jQuery object or a plain Element
        return scope && scope.nodeType === 1 ? scope : (scope && scope[0] ? scope[0] : null);
    }

    function makeVertical( scope ) {
        const root = scopeToElement( scope );
        if (!root) return;

        // Only target the carousel you tagged
        if (!root.classList.contains( 'vertical-carousel' )) return;

        const swiperEl = root.querySelector( '.e-n-carousel.swiper' );
        if (!swiperEl) return;

        const tryInit = () => {
            const swiper = swiperEl.swiper;
            if (!swiper) return false;

            // Direction -> vertical
            if (typeof swiper.changeDirection === 'function') {
                swiper.changeDirection( 'vertical', false );
            } else {
                swiper.params.direction = 'vertical';
            }

            // Optional: normalize spacing via Swiper instead of margin-right
            if (swiper.params && (swiper.params.spaceBetween == null)) {
                swiper.params.spaceBetween = 10;
            }

            swiper.update();
            return true;
        };

        if (tryInit()) return;

        // Poll until Elementor attaches swiperEl.swiper
        let n = 0;
        const t = setInterval( () => {
            n++;
            if (tryInit() || n > 60) clearInterval( t ); // ~3s
        }, 50 );
    }

    document.addEventListener( 'elementor/frontend/init', function () {
        if (!window.elementorFrontend || !elementorFrontend.hooks) return;

        elementorFrontend.hooks.addAction(
            'frontend/element_ready/nested-carousel.default',
            makeVertical
        );
    } );
})();

/**
 * GP Vertical Slider - Frontend Initialization
 *
 * @package Gp_Strategies
 */

(function () {
	'use strict';

	/**
	 * Initialize all GP vertical slider widgets
	 */
	function initGPVerticalSlider() {
		var sliders = document.querySelectorAll('.gp-vertical-slider.splide:not(.is-initialized)');

		sliders.forEach(function (slider) {
			var optionsAttr = slider.getAttribute('data-splide-options');

			// Default options
			var options = {
				direction: 'ttb',
				height: '500px',
				wheel: true,
				type: 'loop',
				speed: 400,
				gap: '10px',
				arrows: true,
				pagination: true
			};

			// Merge custom options
			if (optionsAttr) {
				try {
					var customOptions = JSON.parse(optionsAttr);
					options = Object.assign({}, options, customOptions);
				} catch (e) {
					console.warn('GP Vertical Slider: Invalid options JSON', e);
				}
			}

			// Initialize Splide
			var splide = new Splide(slider, options);
			splide.mount();

			// Mark as initialized
			slider.classList.add('is-initialized');

			// Store reference for potential destruction
			slider.splideInstance = splide;
		});
	}

	// Initialize on DOM ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initGPVerticalSlider);
	} else {
		initGPVerticalSlider();
	}

	// Expose for external use (e.g., Elementor editor)
	window.initGPVerticalSlider = initGPVerticalSlider;
})();

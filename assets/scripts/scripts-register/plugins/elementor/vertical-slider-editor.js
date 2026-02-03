/**
 * GP Vertical Slider - Elementor Editor Integration
 *
 * @package Gp_Strategies
 */

(function ($) {
	'use strict';

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/gp-vertical-slider.default',
			function ($scope) {
				var $slider = $scope.find('.gp-vertical-slider.splide');

				if ($slider.length === 0) {
					return;
				}

				var sliderEl = $slider[0];

				// Destroy existing instance if present
				if (sliderEl.splideInstance) {
					sliderEl.splideInstance.destroy();
					sliderEl.classList.remove('is-initialized');
				}

				var optionsAttr = sliderEl.getAttribute('data-splide-options');

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
						console.warn('GP Vertical Slider Editor: Invalid options JSON', e);
					}
				}

				// Initialize Splide
				var splide = new Splide(sliderEl, options);
				splide.mount();

				// Mark as initialized and store reference
				sliderEl.classList.add('is-initialized');
				sliderEl.splideInstance = splide;
			}
		);
	});
})(jQuery);

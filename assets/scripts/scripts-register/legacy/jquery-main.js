(function ($) {

	//Toggle Language Selection Menu	

	function linkifyItems() {
		var accessible_items = $(".accessible-click");

		accessible_items.each(function () {
			let _this = $(this);
			var link = _this.find("a");
			if (link) {
				var url = link.attr("href");
				_this.on("click", function () {
					location.href = url;
					link.preventDefault;
				});
				_this.addClass("linkify");
				link.on("focus", function () {
					_this.addClass("isfocused");
				});
				link.on("blur", function () {
					_this.removeClass("isfocused");
				});
			}
		});
	}

	function table_of_content_heading() {
		if ($('.content-section__content').length) {
			$('.content-section__content')
				.find(':header').each(function () {
					var header = $(this);
					var headerText = header.text();
					var headerId = headerText.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
					header.empty().append('<span id="' + headerId + '">' + headerText + '</span>');
				});
		}
	}

	function expand_content_items() {
		if ($('.content-terms__list--more').length) {
			$('.content-terms__expand-link').on("click", function (e) {
				let $opener = $(this);
				let $item = $(this).closest('.content-terms');
				let text_show = $opener.data('text-all');
				let $drop = $item.find('.content-terms__list--more');
				let text_hide = $opener.data('text-less');
				$drop.slideToggle(function () {
					$item.toggleClass('active');
				});
				if ($item.hasClass('active')) {
					$opener.text(text_show);
				} else {
					$opener.text(text_hide);
				}
				e.preventDefault();
			})
		}
	}

	function hbsptFormStyle() {

		$('.hbspt-form').on('focus', 'input[type=text], input[type=tel], input[type=email], .hs-input', function () {
			$(this).parents('.hs-form-field').addClass('focus');
		});

		$('.hbspt-form').on('focusout', 'input[type=text], input[type=tel], input[type=email], .hs-input', function () {
			let input_val = $(this).val().length;
			if (input_val == 0) {
				$(this).parents('.hs-form-field').removeClass('focus');
			}
		});

		$('.hbspt-form').on('change', 'select', function () {
			$(this).parents('.hs-form-field').addClass('focus');
		});

		$('.hbspt-form').on('change', 'input[type=checkbox]', function () {
			$(this).parents('.hs-form-booleancheckbox-display').toggleClass('checked');
		});


	}

	function updateURLParameter() {
		console.log($('.table-of-contents__list li:first-of-type a').length);
		if ($('.table-of-contents__list a.active').length > 1) {
			$('.table-of-contents__list li:first-of-type a').removeClass('active');
		}
		$('.update-post-type-js').on('click', function (event) {
			event.preventDefault();
			/* Act on the event */
			let param = $(this).data('param');
			let value = $(this).data('value');
			let base_url = $(this).attr('href');
			var url = window.location.href;
			var newParam = encodeURIComponent(param) + '=' + encodeURIComponent(value);

			var parts = url.split('?');
			if (parts.length >= 2) {
				var prefix = encodeURIComponent(param) + '=';
				var suffix = '&' + newParam;
				var queryParams = parts[1].split(/[&;]/g);

				// Find and replace existing parameter value
				for (var i = 0; i < queryParams.length; i++) {
					if (queryParams[i].startsWith(prefix)) {
						queryParams[i] = newParam;
						break;
					}
				}

				// If the parameter wasn't found, add it to the end of the query string
				if (i >= queryParams.length) {
					queryParams.push(newParam);
				}

				// Combine the updated query string and the rest of the URL
				url = base_url + '?' + queryParams.join('&') + parts.slice(2).join('?');
			} else {
				// If there are no existing parameters, add the new parameter
				url += '?' + newParam;
			}

			// Update the URL without refreshing the page
			history.pushState(null, '', url);

			setTimeout(location.reload(), 50);

		});
	}

	// change DOM position for element function
	function moveBlocks() {
		// move blocks
		$('[data-move-item]').each(function () {
			var moveItem = $(this);
			var itemParent = $(this).closest('[data-move-parent]');
			var destiny = moveItem.data('destiny');
			var targetMobile = itemParent.find('[data-mobile-destiny="' + destiny + '"]');
			var targetdesktop = itemParent.find('[data-desktop-destiny="' + destiny + '"]');
			if ($('.compareFixMobile').is(':visible')) {
				$(moveItem).appendTo(targetMobile);
			} else {
				$(moveItem).appendTo(targetdesktop);
			}
		});

	}

	// countUp Function
	function initCountup() {
		if (window.matchMedia("(max-width: 1200px)").matches) {
			$('.num-val').each(function () {
				let $this = $(this);
				let countTo = $this.attr('data-number');
				$this.text(countTo);
			});
		} else {
			$('.count-block').each(function () {
				let $this = $(this);
				if (isElementInViewport($this) && !$(this).hasClass('counted')) {
					$('.num-val').each(function (i) {
						let $this = $(this);
						let countTo = $this.attr('data-number');
						if ($this.text() !== countTo) {
							setTimeout(
								function () {
									$({
										countNum: $this.text().replace(/,/g, ''),
									}).animate({
										countNum: countTo,
									}, {
										duration: 1500,
										easing: 'linear',
										start() {
											$this.parent().prev().removeClass('active');
											$this.parent().addClass('active');
										},
										step() {
											let numVal = Math.floor(this.countNum);
											let displayText = numVal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
											$this.text(displayText);
										},
										complete() {
											let numVal = this.countNum;
											let displayText = numVal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
											$this.text(displayText);
										},
									});
								}, 1500 * i,
							);
						}
					});
					$(this).addClass('counted');
				}
			});
		}
	}

	window.addEventListener('load', initCountup);
	window.addEventListener('scroll', debounce(initCountup, 100, false), false);

	function searchBarForm() {
		const container = $(".search-input-js");

		$('.search-filter-js').on('click', function (event) {
			event.preventDefault();
			/* Act on the event */
			let target = $(this).data('target');
			let elemHeight = $(this).outerHeight() + 6;
			let positionLeft = $(this).position().left;
			let positionTop = $(this).position().top + elemHeight;

			// First hide shown items
			container.find('.search-filter-js.active').removeClass('active');
			container.find('.filter-wrapper-js.show').removeClass('show');
			// Show items
			$(this).addClass('active');
			$('#target_' + target).addClass('show');
			$('#target_' + target).css({
				'left': positionLeft,
				'top': positionTop
			});

		});

		$('.close-filter-modal').on('click', function (event) {
			event.preventDefault();
			container.find('.search-filter-js.active').removeClass('active');
			container.find('.filter-wrapper-js').removeClass('show');
		});


		$(document).mouseup(function (e) {
			// if the target of the click isn't the container nor a descendant of the container
			if (!container.is(e.target) && container.has(e.target).length === 0) {
				container.find('.search-filter-js.active').removeClass('active');
				container.find('.filter-wrapper-js').removeClass('show');
			}
		});

	}

	function testimonial_carousel_init() {

		$('.testimonial-carousel-js').each(function () {
			var slider = $(this);
			slider.owlCarousel({
				loop: true,
				rewind: true,
				stagePadding: 100,
				center: true,
				dots: false,
				merge: true,
				rtl: slider.data('direction'),
				autoplay: slider.data('auto-play'),
				autoplayHoverPause: true,
				changeItemOnClick: false,
				autoplayTimeout: slider.data('auto-play-time'),
				smartSpeed: 7500,
				responsive: {
					0: {
						items: 1,
						stagePadding: 20
					},
					768: {
						items: 1,
					},
					1170: {
						items: slider.data('slider-items'),
					}
				}
			});
		});

	}

	function hero_word_animation(){
		var words = document.getElementsByClassName('hero-word-animation');
		var wordArray = [];
		var currentWord = 0;

		/* Word Flip */


			var lang = document.documentElement.lang || 'en';
			var word = document.querySelector('.animation-wrapper');
			if (!word) return; // Don't do this function if element is not on this page
			var arr = $('.animation-wrapper').data("words");
			var i = 0;
			var animationDuration = 200;
			var animationDelay = 1750;
			word.style.animationDuration = animationDuration + 'ms';
		
			setWord();
			loop();
		
			function setWord() {
				word.innerHTML = arr[i];
			}
		
			function loop() {
				word.classList.remove('flip-in');
				word.classList.remove('flip-out');
				setTimeout(flipOut, animationDelay);
			}
		
			function flipOut() {
				word.classList.add('flip-out');
				setTimeout(flipIn, animationDuration)
			}
		
			function flipIn() {
				// Checks Array
				if (++i >= arr.length) {
					i = 0;
				}
		
				setWord();
				word.classList.add('flip-in');
				setTimeout(loop, animationDuration);
			}
	


	}

	function hero_slider_init(){
		$('.owl-carousel-hero').each(function () {
			var hero_slider = $(this);
			hero_slider.owlCarousel({
				loop:true,
				items:1,
				nav:true,
				autoplay:true,
    			autoplayTimeout:4000,
				animateOut: 'fadeOut',
				animateIn: 'fadeIn',
				onInitialized: autoplayVideo, // Event when the carousel has initialized
        		onTranslated: autoplayVideo,
				onTranslate: pauseVideo,
			})
		});
		function pauseVideo(){
			$('.owl-carousel-hero video').each(function() {
				$(this).get(0).pause();
			});
		}
		function autoplayVideo(event) {
			// Pause all videos first
			$('.owl-carousel-hero video').each(function() {
				$(this).get(0).pause();
			});
			
			// Play the video of the current active slide
			var currentVideo = $('.owl-item.active').find('video');
			console.log('onInitialized', currentVideo);
			if(currentVideo.length) {
				currentVideo.get(0).play();
			}
		}
		
	}

	function testimonials_card_slider(){
		$('.testimonials-card-slider').each(function () {
			var testimonial_slider = $(this);
			setTimeout(function() {
				testimonial_slider.owlCarousel({
					loop:true,
					items:1,
					nav:false,
					autoplay:true,
					autoplayTimeout:6000,
					stagePadding: 0,
					margin: 20,
				})
			}, 100);
		});
	}

	$(document).ready(function () {
		// hero_word_animation();
		hero_slider_init();
		initArticleSticky();
		expand_content_items();
		updateURLParameter();
		testimonial_carousel_init();
		testimonials_card_slider();

		var fancybox_items = 'a[href*="youtube.com"], a[href*="youtu.be"], a[href*="vimeo.com"], a[href*="wistia.com"], a[href*=".mp4"], a[href*=".ogg"], a[href*=".webm"]';

		$('.content-resource-link').on('click', fancybox_items, function (event) {
			event.preventDefault();
			/* Act on the event */
			let href = $(this).attr('href');
			Fancybox.show([{
				src: href,
				type: "video",
				ratio: 16 / 9,
				width: 720,
			}, ]);
		});


		// Get the current URL
		let currentUrl = window.location.href;

		console.log('currentUrl', currentUrl);
		if($('.table-of-contents__list').length){

			// Select all anchor tags and iterate
			$('.table-of-contents__list a').each(function() {
				
				if (this.href === currentUrl) {
					console.log('thishref', this.href);

					// If the href of the link matches the current URL, add the 'active' class
					console.log($(this).parents('.table-of-contents__sublist').length);
					$(this).addClass('active');
					if($(this).parents('.table-of-contents__sublist').length){
						$(this).parents('.table-of-contents__sublist').css('display', 'block');
					}else{
						$(this).next('.table-of-contents__sublist').css('display', 'block');

					}
				}
			});
		}


		$('.wp-block-emagine-grid__inner, .wp-block-columns').each(function (index, el) {
			if ($(this).find('.table-of-contents').length > 0) {
				$(this).addClass('sticky-sidebar');
			}
		});

		// case study tabs
		$('.tab-opener').click(function (event) {
			event.preventDefault();
			if (!$(this).hasClass('active')) {
				var aim = $(this).parents('.tab-control').find('.tab-opener').removeClass('active').index(this);
				$(this).addClass('active');
				$(this).parents('.tabset').find('.tab-item').removeClass('active').eq(aim).addClass('active');
			}
		});

		// play video fancybox
		$('.video-item__play, .video-play').on('click', function (event) {
			event.preventDefault();
			let href = $(this).data('link');
			Fancybox.show([{
				src: href,
				type: "video",
				ratio: 16 / 9,
				width: 720,
			}, ]);
		});

		// change block DOM position for mobile
		if (!$('.compareFixMobile').length) {
			$('<div class="compareFixMobile"></div>').appendTo('body');
		}
		moveBlocks();
		$(window).resize(moveBlocks);

		// open mobile menu
		$(".nav-opener").click(function (e) {
			e.preventDefault();
			$('body').toggleClass('nav-active');
		});

		// toggle mobile submenu
		$('.sub-menu__opener').on('click', function (event) {
			event.preventDefault();
			var item = $(this).closest('.menu-item');
			item.toggleClass('submenu-active');
		});

		// toggle language drop
		$(".lang-picker__toggle").click(function (e) {
			e.preventDefault();
			$(this).closest('.lang-picker').toggleClass('active');
		});
		$(document).click(function (event) {
			if ($(event.target).closest('.lang-picker').length) return;
			$('.lang-picker').removeClass('active');
			event.stopPropagation();
		});

		// //  init slick slider
		// if ($('.index-promo__images').length != 0) {
		// 	$('.index-promo__images').slick({
		// 		arrows: false,
		// 		dots: false,
		// 		slidesToScroll: 1,
		// 		slidesToShow: 1,
		// 		infinite: true,
		// 		autoplay: true,
		// 		autoplaySpeed: 2000,
		// 		speed: 500,
		// 		fade: true,
		// 		cssEase: 'linear',
		// 		pauseOnFocus: false,
		// 		pauseOnHover: false
		// 	});
		// }


		hbsptFormStyle();

		searchBarForm();

		table_of_content_heading();

		$('a.button').on('click', '', function (event) {
			var hash = $(this).prop("hash");
			if ($(hash).length > 0) {
				event.preventDefault();
				document.querySelector(hash).scrollIntoView({
					behavior: 'smooth'
				});
			}
		});


	});
	// end $(document).ready

	document.addEventListener("DOMContentLoaded", function () {
		if ("querySelector" in document) {
			linkifyItems();
		}
	});

	// sidebar scrollto
	function initArticleSticky() {
		var sections = [];
		$('.table-of-contents__list a[href^="#"]').each(function () {
			if ($(this).attr('href') !== '#') {
				sections.push($(this).attr('href'));
			}
			$(this).on('click', function (e) {
				var el = $($(this).attr('href'));
				if ($(el).length) {
					$('html, body').stop().animate({
						scrollTop: $(el).offset().top - 100
					});
				}
			})
		})

		$(window).on('load resize scroll', function () {
			var activeId = 0;
			for (var i = sections.length; i >= 0; i--) {
				var $section = $(sections[i]);

				if ($section.length) {
					if ($(window).scrollTop() + $('.site-head').innerHeight() + 35 > $section.offset().top) {
						activeId = sections[i];
						break;
					}
				}
			}

			if (!$('.table-of-contents__list a[href="' + activeId + '"]').closest('li').hasClass('active')) {
				$('.table-of-contents__list li').removeClass('active');
				$('.table-of-contents__list a[href="' + activeId + '"]').closest('li').addClass('active');
			}
		});

	}

	// google maps
	if ($('.acf-map').length) {
		function initMap($el) {
			var $markers = $el.find('.marker');
			var mapArgs = {
				zoom: $el.data('zoom') || 16,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map($el[0], mapArgs);
			map.markers = [];
			$markers.each(function () {
				initMarker($(this), map);
			});
			centerMap(map);
			return map;
		}

		function initMarker($marker, map) {
			var lat = $marker.data('lat');
			var lng = $marker.data('lng');
			var latLng = {
				lat: parseFloat(lat),
				lng: parseFloat(lng)
			};
			var marker = new google.maps.Marker({
				position: latLng,
				map: map
			});
			map.markers.push(marker);
			if ($marker.html()) {
				var infowindow = new google.maps.InfoWindow({
					content: $marker.html()
				});
				google.maps.event.addListener(marker, 'click', function () {
					infowindow.open(map, marker);
				});
			}
		}

		function centerMap(map) {
			var bounds = new google.maps.LatLngBounds();
			map.markers.forEach(function (marker) {
				bounds.extend({
					lat: marker.position.lat(),
					lng: marker.position.lng()
				});
			});
			if (map.markers.length == 1) {
				map.setCenter(bounds.getCenter());
			} else {
				map.fitBounds(bounds);
			}
		}
		$(document).ready(function () {
			$('.acf-map').each(function () {
				var map = initMap($(this));
			});
		});
	}



}(jQuery));

function isElementInViewport(el) {
	// Special bonus for those using jQuery.
	if (typeof jQuery === 'function' && el instanceof jQuery) {
		el = el[0];
	}
	const rect = el.getBoundingClientRect();
	return (rect.top >= 0 && rect.left >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
		rect.right <= (window.innerWidth || document.documentElement.clientWidth));
}

function debounce(func, wait = 100, immediate = true) {
	let timeout;
	return function () {
		const context = this;
		const args = arguments;
		const later = function () {
			timeout = null;
			if (!immediate) {
				func.apply(context, args);
			}
		};
		const callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) {
			func.apply(context, args);
		}
	};
}


// calculate browser scrollbar width
function _calculateScrollbarWidth() {
	document.documentElement.style.setProperty('--scrollbar-width', (window.innerWidth - document.documentElement.clientWidth) + "px");
}
window.addEventListener('resize', _calculateScrollbarWidth, false);
document.addEventListener('DOMContentLoaded', _calculateScrollbarWidth, false);
window.addEventListener('load', _calculateScrollbarWidth);

AOS.init({
	once: true,
});


// accessibility navigation script
(function ($) {

	var menuContainer = $('.js-header-menu-item');
	var menuToggle = menuContainer.find('.menu-button');
	var siteHeaderMenu = menuContainer.find('.head-nav');
	var siteNavigation = menuContainer.find('#site-navigation');

	// If you are using WordPress, and do not need to localise your script, or if you are not using WordPress, then uncomment the next line
	var screenReaderText = {
		"expand": "Expand child menu",
		"collapse": "Collapse child menu"
	};

	var dropdownToggle = $('<button />', {
			'class': 'dropdown-toggle',
			'aria-expanded': false
		})
		.append($('<span />', {
			'class': 'screen-readers',
			text: screenReaderText.expand
		}));


	// Toggles the menu button
	(function () {

		if (!menuToggle.length) {
			return;
		}

		menuToggle.add(siteNavigation).attr('aria-expanded', 'false');

		menuToggle.on('click', function () {
			$(this).add(siteHeaderMenu).toggleClass('toggled-on');

			// jscs:disable
			$(this).add(siteNavigation)
				.attr('aria-expanded', $(this)
					.add(siteNavigation).attr('aria-expanded') === 'false' ? 'true' : 'false');
			// jscs:enable

		});
	})();

	// Adds the dropdown toggle button
	$('.menu-item-has-children > .menu-item__link').after(dropdownToggle);

	// Adds aria attribute
	siteHeaderMenu.find('.menu-item-has-children').attr('aria-haspopup', 'true');

	// Toggles the sub-menu when dropdown toggle button clicked
	siteHeaderMenu.find('.dropdown-toggle').click(function (e) {

		screenReaderSpan = $(this).find('.screen-readers');

		e.preventDefault();
		$(this).toggleClass('toggled-on');
		$(this).nextAll('.sub-menu').toggleClass('toggled-on');

		// jscs:disable
		$(this).attr('aria-expanded', $(this).attr('aria-expanded') === 'false' ?
			'true' : 'false');
		// jscs:enable
		screenReaderSpan.text(screenReaderSpan.text() ===
			screenReaderText.expand ? screenReaderText.collapse :
			screenReaderText.expand);
	});

	// Adds a class to sub-menus for styling
	$('.sub-menu .menu-item-has-children').parent('.sub-menu').addClass('has-sub-menu');


	// Keyboard navigation
	$('.menu-item a, button.dropdown-toggle').on('keydown', function (e) {

		if ([37, 38, 39, 40].indexOf(e.keyCode) == -1) {
			return;
		}

		switch (e.keyCode) {

			case 37: // left key
				e.preventDefault();
				e.stopPropagation();

				if ($(this).hasClass('dropdown-toggle')) {
					$(this).prev('a').focus();
				} else {

					if ($(this).parent().prev().children('button.dropdown-toggle').length) {
						$(this).parent().prev().children('button.dropdown-toggle').focus();
					} else {
						$(this).parent().prev().children('a').focus();
					}
				}

				if ($(this).is('ul ul ul.sub-menu.toggled-on li:first-child a')) {
					$(this).parents('ul.sub-menu.toggled-on li').children('button.dropdown-toggle').focus();
				}

				break;

			case 39: // right key
				e.preventDefault();
				e.stopPropagation();

				if ($(this).next('button.dropdown-toggle').length) {
					$(this).next('button.dropdown-toggle').focus();
				} else {
					$(this).parent().next().children('a').focus();
				}

				if ($(this).is('ul.sub-menu .dropdown-toggle.toggled-on')) {
					$(this).parent().find('ul.sub-menu li:first-child a').focus();
				}

				break;


			case 40: // down key
				e.preventDefault();
				e.stopPropagation();

				if ($(this).next().length) {
					$(this).next().find('li:first-child a').first().focus();
				} else {
					$(this).parent().next().children('a').focus();
				}

				if (($(this).is('ul.sub-menu a')) && ($(this).next('button.dropdown-toggle').length)) {
					$(this).parent().next().children('a').focus();
				}

				if (($(this).is('ul.sub-menu .dropdown-toggle')) && ($(this).parent().next().children('.dropdown-toggle').length)) {
					$(this).parent().next().children('.dropdown-toggle').focus();
				}

				break;


			case 38: // up key
				e.preventDefault();
				e.stopPropagation();

				if ($(this).parent().prev().length) {
					$(this).parent().prev().children('a').focus();
				} else {
					$(this).parents('ul').first().prev('.dropdown-toggle.toggled-on').focus();
				}

				if (($(this).is('ul.sub-menu .dropdown-toggle')) && ($(this).parent().prev().children('.dropdown-toggle').length)) {
					$(this).parent().prev().children('.dropdown-toggle').focus();
				}

				break;

		}
	});

	$('.search-bar__form').on('keydown', '.search-bar__form-keyword__input', function (event) {
		/* Act on the event */
		if (event.keyCode == 13) {
			event.preventDefault();
			$('.search-bar__form-keyword__submit').click();
		}

	});

	//Toggle Language Selection Menu

	jQuery(function () {
		jQuery('.lang-picker__toggle').on('click', function () {
			jQuery('.lang-picker__list .lang-picker__list-item a').toggleClass('OneLinkShow');
		});
	});


})(jQuery);
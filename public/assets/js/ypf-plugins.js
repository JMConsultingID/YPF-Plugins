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
jQuery(document).ready(function($) {
  // Initial tab setup
  $('.ypf-tabs-buttons li:first-child').addClass('active');
  $('.ypf-tab-panel:first-child').addClass('active');

  // Tab click event
  $('.ypf-tabs-buttons li').click(function() {
    var index = $(this).index();
    $('.ypf-tabs-buttons li').removeClass('active');
    $(this).addClass('active');
    $('.ypf-tab-panel').removeClass('active').eq(index).addClass('active');
  });

  var pricingCardSwipers = [];
    var init = false;

    function initSwiper(slider) {
        var nextEl = $(slider).siblings('.swiper-navigation').find('.navBtnRight')[0];
        var prevEl = $(slider).siblings('.swiper-navigation').find('.navBtnLeft')[0];

        return new Swiper(slider, {
            slidesPerView: "auto",
            spaceBetween: 5,
            grabCursor: true,
            keyboard: true,
            autoHeight: false,
            navigation: {
                nextEl: nextEl,
                prevEl: prevEl,
            },
        });
    }

    function swiperCard() {
        var sliders = $('[id^="pricingTableSlider-"]'); // Select all elements with ID starting with "pricingTableSlider-"

        if (window.innerWidth <= 991 && !init) {
            init = true;
            sliders.each(function(index, slider) {
                pricingCardSwipers.push(initSwiper(slider));
            });
        } else if (init && window.innerWidth > 991) {
            $.each(pricingCardSwipers, function(index, swiper) {
                if (swiper !== null && swiper !== undefined) {
                    swiper.destroy();
                }
            });
            pricingCardSwipers = [];
            init = false;
        }
    }

    swiperCard();
    $(window).on("resize", swiperCard);
});

})( jQuery );

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

	// Pricing table - mobile only slider
	var init = false;
	var pricingCardSwiper;

	function swiperCard() {
	  if (window.innerWidth <= 991) {
	    if (!init) {
	      init = true;
	      var activeTabPanel = document.querySelector('.ypf-tab-panel.active');
	      if (activeTabPanel) {
	        pricingCardSwiper = new Swiper(activeTabPanel.querySelector("#pricingTableSlider"), {
	          slidesPerView: "auto",
	          spaceBetween: 5,
	          grabCursor: true,
	          keyboard: true,
	          autoHeight: false,
	          navigation: {
	            nextEl: activeTabPanel.querySelector("#navBtnRight"),
	            prevEl: activeTabPanel.querySelector("#navBtnLeft"),
	          },
	        });
	      }
	    }
	  } else if (init && pricingCardSwiper) {
	    pricingCardSwiper.destroy();
	    init = false;
	  }
	}

	swiperCard();
	window.addEventListener("resize", function() {
	  swiperCard();

	  // Reinitialize Swiper when the active tab changes
	  if (window.innerWidth <= 991) {
	    var tabs = document.querySelectorAll('.ypf-tab-panel');
	    tabs.forEach(function(tab) {
	      tab.addEventListener('click', function() {
	        if (this.classList.contains('active')) {
	          swiperCard();
	        }
	      });
	    });
	  }
	});

});

})( jQuery );

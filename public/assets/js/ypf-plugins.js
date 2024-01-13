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

var pricingCardSwiper;
var pricingCardSwiperSingle;
var init = false;
var currentSlideIndex = 0;

// Function to initialize Swiper for #pricingTableSlider
function initializeSwiper() {
    // Destroy the previous instance if it exists
    if (pricingCardSwiper) {
        currentSlideIndex = pricingCardSwiper.activeIndex;
        pricingCardSwiper.destroy();
        init = false;
    }

    var activeTabPanel = document.querySelector('.tab-content.active');
    if (activeTabPanel && window.innerWidth <= 991) {
        pricingCardSwiper = new Swiper(activeTabPanel.querySelector("#pricingTableSlider"), {
            slidesPerView: "auto",
            spaceBetween: 0,
            grabCursor: false,
            keyboard: false,
            autoHeight: false,
            effect: 'slide', // Set the transition effect to 'fade'
            noSwiping: true,
            allowTouchMove: false,
            speed: 700, // Transition duration in milliseconds (1000ms = 1s)
            navigation: {
              nextEl: activeTabPanel.querySelector("#navBtnRight"),
              prevEl: activeTabPanel.querySelector("#navBtnLeft"),
            },
        });
        init = true;
        pricingCardSwiper.slideTo(currentSlideIndex, 0, false);
    }
}

// Function to initialize Swiper for #pricingTableSliderSingle
function initializeSwiperSingle() {
    if (pricingCardSwiperSingle) {
        pricingCardSwiperSingle.destroy();
        init = false;
    }
    if (window.innerWidth <= 991 && !pricingCardSwiperSingle) {
        pricingCardSwiperSingle = new Swiper("#pricingTableSliderSingle", {
            slidesPerView: "auto",
            spaceBetween: 0,
            grabCursor: false,
            keyboard: false,
            autoHeight: false,
            effect: 'slide',
            noSwiping: true,
            allowTouchMove: false,
            speed: 700, // Transition duration in milliseconds
            navigation: {
              nextEl: "#navBtnRightSingle", // Update these selectors to the correct ones for your single slider
              prevEl: "#navBtnLeftSingle",
            },
        });
        init = true;
    } else if (window.innerWidth > 991 && pricingCardSwiperSingle) {
        pricingCardSwiperSingle.destroy();
        pricingCardSwiperSingle = null;
    }
}

// Initialize Swipers on first load and on window resize
initializeSwiper();
initializeSwiperSingle();
window.addEventListener("resize", function() {
    initializeSwiper();
    initializeSwiperSingle();
});

// Event listener for tab button clicks
document.querySelectorAll('.tab-nav-list li').forEach(function(tabButton, index) {
  tabButton.addEventListener('click', function() {
    // Update active tab
    document.querySelector('.tab-nav-list li.active').classList.remove('active');
    this.classList.add('active');

    // Update active tab panel
    document.querySelector('.tab-content-list .tab-content.active').classList.remove('active');
    document.querySelectorAll('.tab-content-list .tab-content')[index].classList.add('active');

    
    // Reset the Swiper to the first slide when a different tab is clicked
    currentSlideIndex = 0;

    // Reinitialize Swiper
    initializeSwiper();
  });
});

tippy('.data-template', {
    content(reference) {
        const id = reference.getAttribute('data-template');
        const template = document.getElementById(id);
        return template ? template.innerHTML : 'Tooltip content not found'; // Added a null check
    },
    allowHTML: true,
});


});

})( jQuery );

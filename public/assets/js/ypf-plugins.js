jQuery(document).ready(function($) {
var pricingCardSwiper;
var pricingCardSwiperSingle;
var init = false;
var initSwiperSingle = false;
var currentSlideIndex = 0;

window.addEventListener('load', function() {
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
    if (window.innerWidth <= 991) {
        if (!initSwiperSingle) {
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
                  nextEl: "#navBtnRight", // Update these selectors to the correct ones for your single slider
                  prevEl: "#navBtnLeft",
                },
            });
            initSwiperSingle = true;
        } else {
            pricingCardSwiperSingle.destroy();
            initSwiperSingle = false;
        }
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
        var activeTab = document.querySelector('.tab-nav-list li.active');
        if (activeTab) {
            activeTab.classList.remove('active');
        }
        this.classList.add('active');

        // Update active tab panel
        var activeTabContent = document.querySelector('.tab-content-list .tab-content.active');
        if (activeTabContent) {
            activeTabContent.classList.remove('active');
        }
        var newActiveTabContent = document.querySelectorAll('.tab-content-list .tab-content')[index];
        newActiveTabContent.classList.add('active');

        // Check if the new active tab content contains #pricingTableSlider
        var pricingTableSlider = newActiveTabContent.querySelector('#pricingTableSlider');
        if (pricingTableSlider) {
            // Reset the Swiper to the first slide when a different tab is clicked
            currentSlideIndex = 0;

            // Reinitialize Swiper
            initializeSwiper();
        }
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
});

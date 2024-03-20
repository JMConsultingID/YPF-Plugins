jQuery(document).ready(function($) {
    var pricingCardSwiper;
    var pricingCardSwiperSingle;
    var init = false;
    var initSwiperSingle = false;
    var currentSlideIndex = 0;

    // Function to initialize Swiper for #pricingTableSlider
    function initializeSwiper() {
        if (pricingCardSwiper) {
            currentSlideIndex = pricingCardSwiper.activeIndex;
            pricingCardSwiper.destroy();
            init = false;
        }

        var activeTabPanels = document.querySelectorAll('.type-of-price .eael-tab-content-item.active, .type-of-price-2phase .eael-tab-content-item.active');

        if (activeTabPanels && window.innerWidth <= 991) {
            activeTabPanels.forEach(function(activeTabPanel) {
            var pricingTableSlider = activeTabPanel.querySelector("#pricingTableSlider");
                if (pricingTableSlider) {
                    var pricingCardSwiper = new Swiper(pricingTableSlider, {
                        slidesPerView: "auto",
                        spaceBetween: 0,
                        grabCursor: false,
                        keyboard: false,
                        autoHeight: false,
                        effect: 'slide',
                        noSwiping: true,
                        allowTouchMove: false,
                        speed: 700,
                        navigation: {
                            nextEl: activeTabPanel.querySelector("#navBtnRight"),
                            prevEl: activeTabPanel.querySelector("#navBtnLeft"),
                        },
                    });             
                    init = true;
                    pricingCardSwiper.slideTo(currentSlideIndex, 0, false);
                }
            });
        }
    }

    // Function to initialize Swiper for #pricingTableSliderSingle
    function initializeSwiperSingle() {
        if (window.innerWidth <= 991 && !initSwiperSingle) {
            pricingCardSwiperSingle = new Swiper("#pricingTableSliderSingle", {
                slidesPerView: "auto",
                spaceBetween: 0,
                grabCursor: false,
                keyboard: false,
                autoHeight: false,
                effect: 'slide',
                noSwiping: true,
                allowTouchMove: false,
                speed: 700,
                navigation: {
                    nextEl: "#navBtnRight",
                    prevEl: "#navBtnLeft",
                },
            });
            initSwiperSingle = true;
        } else if (window.innerWidth > 991 && pricingCardSwiperSingle) {
            pricingCardSwiperSingle.destroy();
            initSwiperSingle = false;
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
    document.querySelectorAll('.type-of-price .eael-tabs-nav ul li').forEach(function(tabButton, index) {
        tabButton.addEventListener('click', function() {
            var activeTab = document.querySelector('.type-of-price .eael-tabs-nav ul li.eael-tab-item-trigger.active');
            if (activeTab) {
                activeTab.classList.remove('active');
            }
            this.classList.add('active');

            var activeTabContent = document.querySelector('.type-of-price .eael-tabs-content .eael-tab-content-item.active');
            if (activeTabContent) {
                activeTabContent.classList.remove('active');
            }
            var newActiveTabContent = document.querySelectorAll('.type-of-price .eael-tabs-content .eael-tab-content-item')[index];
            newActiveTabContent.classList.add('active');

            var pricingTableSlider = newActiveTabContent.querySelector('#pricingTableSlider');
            if (pricingTableSlider) {
                currentSlideIndex = 0;
                initializeSwiper();
            }
        });
    });

    // Initialize Tippy tooltips
    tippy('.data-template', {
        content(reference) {
            const id = reference.getAttribute('data-template');
            const template = document.getElementById(id);
            return template ? template.innerHTML : 'Tooltip content not found';
        },
        allowHTML: true,
        interactive: true,
        arrow: true,
        delay: [100, 100], // Optional delay settings
        theme: 'light',
    });
});
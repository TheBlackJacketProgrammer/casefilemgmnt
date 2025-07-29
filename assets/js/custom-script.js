jQuery(document).ready(($) => {
    console.log('initialised');

    ///////////////////////////////////////////////
    // Desktop Menu Dropdown Handling
    ///////////////////////////////////////////////
    // Add dropdown arrows to menu items with children
    // $('.site-nav .menu-item-has-children > a').each(function() {
    //     $(this).append('<span class="dropdown-arrow"></span>');
    // });

    // Handle dropdown arrow clicks
    $('.site-nav .dropdown-arrow').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const $parent = $(this).parent();
        const $submenu = $parent.siblings('.sub-menu');
        
        // Toggle submenu visibility
        $submenu.toggleClass('active');
        $parent.toggleClass('open');
    });

    // // Handle menu item clicks (excluding arrow clicks)
    // $('.site-nav .menu-item-has-children > a').on('click', function(e) {
    //     // If the click was on the arrow, don't prevent default
    //     if ($(e.target).hasClass('dropdown-arrow')) {
    //         return;
    //     }
    //     // Otherwise, let the link work normally
    // });

    ///////////////////////////////////////////////
    // Open external links in new tab
    ///////////////////////////////////////////////
    jQuery(document).ready(function() {
        jQuery('a[href^="http"]:not([href*="'+location.hostname+'"])').attr('target', '_blank');
    });



    ///////////////////////////////////////////////
    // Mobile Menu Icon
    ///////////////////////////////////////////////

    const html = $('html');
    const mobileMenuIcon = $('.mobile-menu-icon');

    mobileMenuIcon.on('click', () => {
        html.toggleClass('mobile-menu-open');
        
        // If closing the menu (cross icon clicked)
        if (!html.hasClass('mobile-menu-open')) {
            // Close all submenus
            $('.mobile-menu .sub-menu').slideUp();
            // Remove open class from all menu items
            $('.mobile-menu .menu-item-has-children > a').removeClass('open');
        }
    });

    // Submenu toggle - ONLY for mobile menu
    $('.mobile-menu .menu-item-has-children > a').on('click', function(e) {
        // e.preventDefault();
        // $(this).siblings('.sub-menu').slideToggle();
        // $(this).toggleClass('open');
        // Only prevent default if clicking the arrow area
        if (e.offsetX > (this.offsetWidth - 30)) {
            e.preventDefault();
            $(this).siblings('.sub-menu').slideToggle();
            $(this).toggleClass('open');
        }
    });




    ///////////////////////////////////////////////
    // Accordion functionality
    ///////////////////////////////////////////////
    
    const $accordionContent = $('.accordion-content');
    
    // Hide all accordion content initially
    $accordionContent.hide();

    $('.accordion-header').on('click', function() {
        const $accordionItem = $(this).closest('.accordion-item');
        const $content = $(this).siblings('.accordion-content');
        
        // Close other accordion items
        $('.accordion-item').not($accordionItem).removeClass('active');
        $('.accordion-content').not($content).slideUp();
        
        // Toggle current accordion item
        $accordionItem.toggleClass('active');
        $content.slideToggle();
    });

    ///////////////////////////////////////////////
    // Read More functionality
    ///////////////////////////////////////////////
    
    $('.read-more-btn').on('click', function() {
        const hiddenContent = $(this).next('.read-more-content-hidden');
        $(this).toggleClass('active');
        hiddenContent.toggleClass('show');
        
        $(this).text($(this).hasClass('active') ? 'Read Less' : 'Read More');
    });



     ///////////////////////////////////////////////
    // Proud to be affiliated with Load More Button
    ///////////////////////////////////////////////
    (function() {

        function initLoadMore() {
            var loadMoreBtn = document.getElementById('load-more-btn');
            
            if (loadMoreBtn) {
                loadMoreBtn.onclick = function() {
                    // Show all hidden items
                    var hiddenItems = document.querySelectorAll('.hidden-mobile');
                    
                    hiddenItems.forEach(function(item) {
                        item.classList.remove('hidden-mobile');
                    });
                    
                    // Hide the button container
                    var container = document.getElementById('load-more-container');
                    if (container) {
                        container.style.display = 'none';
                    }
                    
                    return false;
                };
            }
        }
    
        initLoadMore();
        
        document.addEventListener('DOMContentLoaded', initLoadMore);
    })();
    
    

});



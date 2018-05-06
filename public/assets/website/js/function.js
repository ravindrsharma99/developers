(function($) {

    "use strict"; // Start of use strict

    // Owl carousel

    function init_carousel() {

        $('.owl-product').owlCarousel({

            items: 1,

            thumbs: true,

            thumbsPrerendered: true

        });

        $(".owl-carousel").each(function(index, el) {

            var config = $(this).data();

            config.navText = ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'];

            var animateOut = $(this).data('animateout');

            var animateIn = $(this).data('animatein');

            var slidespeed = $(this).data('slidespeed');

            if (typeof animateOut != 'undefined') {

                config.animateOut = animateOut;

            }

            if (typeof animateIn != 'undefined') {

                config.animateIn = animateIn;

            }

            if (typeof(slidespeed) != 'undefined') {

                config.smartSpeed = slidespeed;

            }

            var owl = $(this);

            owl.on('initialized.owl.carousel', function(event) {

                var total_active = owl.find('.owl-item.active').length;

                var i = 0;

                owl.find('.owl-item').removeClass('item-first item-last');

                setTimeout(function() {

                    owl.find('.owl-item.active').each(function() {

                        i++;

                        if (i == 1) {

                            $(this).addClass('item-first');

                        }

                        if (i == total_active) {

                            $(this).addClass('item-last');

                        }

                    });

                }, 100);

            })

            owl.on('refreshed.owl.carousel', function(event) {

                var total_active = owl.find('.owl-item.active').length;

                var i = 0;

                owl.find('.owl-item').removeClass('item-first item-last');

                setTimeout(function() {

                    owl.find('.owl-item.active').each(function() {

                        i++;

                        if (i == 1) {

                            $(this).addClass('item-first');

                        }

                        if (i == total_active) {

                            $(this).addClass('item-last');

                        }

                    });

                }, 100);

            })

            owl.on('change.owl.carousel', function(event) {

                var total_active = owl.find('.owl-item.active').length;

                var i = 0;

                owl.find('.owl-item').removeClass('item-first item-last');

                setTimeout(function() {

                    owl.find('.owl-item.active').each(function() {

                        i++;

                        if (i == 1) {

                            $(this).addClass('item-first');

                        }

                        if (i == total_active) {

                            $(this).addClass('item-last');

                        }

                    });

                }, 100);

                owl.addClass('owl-changed');

                setTimeout(function() {

                    owl.removeClass('owl-changed');

                }, config.smartSpeed)

            })

            owl.on('drag.owl.carousel', function(event) {

                owl.addClass('owl-changed');

                setTimeout(function() {

                    owl.removeClass('owl-changed');

                }, config.smartSpeed)

            })

            owl.owlCarousel(config);

        });

    }

    // COUNTDOWN

    function kt_countdown() {

        if ($('.kt-countdown').length > 0) {

            var labels = ['Years', 'Months', 'Weeks', 'Days', 'Hrs', 'Mins', 'Secs'];

            var layout = '<span class="box-count day"><span class="number">{dnn}</span> <span class="text">Days</span></span><span class="dot">:</span><span class="box-count hrs"><span class="number">{hnn}</span> <span class="text">Hours</span></span><span class="dot">:</span><span class="box-count min"><span class="number">{mnn}</span> <span class="text">Mins</span></span><span class="dot">:</span><span class="box-count secs"><span class="number">{snn}</span> <span class="text">Secs</span></span>';

            $('.kt-countdown').each(function() {

                var austDay = new Date($(this).data('y'), $(this).data('m') - 1, $(this).data('d'), $(this).data('h'), $(this).data('i'), $(this).data('s'));

                $(this).countdown({

                    until: austDay,

                    labels: labels,

                    layout: layout

                });

            });

        }

    }

    // PRODUCT TAB EFFECT

    function tab_product_fade_effect() {

        // effect first tab

        var sleep = 0;

        $('.tab-product-fade-effect .nav-tab>li.active a[data-toggle="tab"]').each(function() {

            var tabElement = $(this);

            setTimeout(function() {

                tabElement.trigger('click');

            }, sleep);

            sleep += 10000

        })

        // effect click

        $(document).on('click', '.tab-product-fade-effect a[data-toggle="tab"]', function() {

            var tab_id = $(this).attr('href');

            var tab_animated = $(this).data('animated');

            tab_animated = (tab_animated == undefined || tab_animated == "") ? 'fadeInUp' : tab_animated;

            $(tab_id).find('.product-item').each(function(i) {

                var t = $(this);

                var style = $(this).attr("style");

                style = (style == undefined) ? '' : style;

                var delay = i * 200;

                t.attr("style", style +

                    ";-webkit-animation-delay:" + delay + "ms;"

                    +

                    "-moz-animation-delay:" + delay + "ms;"

                    +

                    "-o-animation-delay:" + delay + "ms;"

                    +

                    "animation-delay:" + delay + "ms;"

                ).addClass(tab_animated + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {

                    t.removeClass(tab_animated + ' animated');

                    t.attr("style", style);

                });

            })

        })

    }

    // MENU REPONSIIVE

    function smarket_menu_reposive() {

        var kt_is_mobile = (Modernizr.touch) ? true : false;

        if (kt_is_mobile === true) {

            $(document).on('click', '.smarket-nav .menu-item-has-children >a', function(e) {

                var licurrent = $(this).closest('li');

                var liItem = $('.smarket-nav .menu-item-has-children');

                if (!licurrent.hasClass('show-submenu')) {

                    liItem.removeClass('show-submenu');

                    licurrent.parents().each(function() {

                        if ($(this).hasClass('menu-item-has-children')) {

                            $(this).addClass('show-submenu');

                        }

                        if ($(this).hasClass('main-menu')) {

                            return false;

                        }

                    })

                    licurrent.addClass('show-submenu');

                    // Close all child submenu if parent submenu is closed

                    if (!licurrent.hasClass('show-submenu')) {

                        licurrent.find('li').removeClass('show-submenu');

                    }

                    return false;

                    e.preventDefault();

                } else {

                    licurrent.removeClass('show-submenu');

                    var href = $(this).attr('href');

                    if ($.trim(href) == '' || $.trim(href) == '#') {

                        licurrent.toggleClass('show-submenu');

                    } else {

                        window.location = href;

                    }

                }

                // Close all child submenu if parent submenu is closed

                if (!licurrent.hasClass('show-submenu')) {

                    licurrent.find('li').removeClass('show-submenu');

                }

                e.stopPropagation();

            });

            $(document).on('click', function(e) {

                var target = $(e.target);

                if (!target.closest('.show-submenu').length || !target.closest('.smarket-nav').length) {

                    $('.show-submenu').removeClass('show-submenu');

                }

            });

            // On Desktop

        } else {

            $(document).on('mousemove', '.smarket-nav .menu-item-has-children', function() {

                $(this).addClass('show-submenu');

                if ($(this).closest('.smarket-nav').hasClass('main-menu')) {

                    $('body').addClass('is-show-menu');

                }

            })

            $(document).on('mouseout', '.smarket-nav .menu-item-has-children', function() {

                $(this).removeClass('show-submenu');

                $('body').removeClass('is-show-menu');

            })

        }

    }

    //Sticky header

    function sticky_header() {

        var height_sticky = $('.vertical-menu-list').height();

        var offset = $('.vertical-menu-list').offset();

        if ($('.header-sticky').length > 0) {

            $('.header-sticky').sticky({

                topSpacing: 0

            });

            if ($('#box-vertical-megamenus').length > 0) {

                $(window).scroll(function(event) {

                    var scroll = $(window).scrollTop();

                    if (scroll > (height_sticky + offset.top)) {

                        $('.header-sticky').parent().addClass('is-sticky');

                        $('.header-sticky').css('position', 'fixed');

                        $(".vertical-menu-content").addClass('show');

                    } else {

                        $('.header-sticky').css('position', 'relative');

                        $('.header-sticky').parent().removeClass('is-sticky');

                        $(".vertical-menu-content").removeClass('show');

                    }

                });

            }

        }

    }

    //Sticky product

    function sticky_product() {

        var _winW = $(window).innerWidth();

        if (_winW > 991) {

            $('.sticky-product').each(function() {

                $(this).find('.summary').sticky({

                    topSpacing: 30,

                });

            })

            $(window).resize($(this).find('.summary').sticky('update'));

        }

    }

    //Menu Sticky

    function smarket_sticky_product() {

        var scrollUp = 0;

        $(window).scroll(function(event) {

            var scrollTop = $(this).scrollTop();

            var height_single_left = $('.single-left').outerHeight() - $('.summary').outerHeight();

            //Remove summary sticky

            if (scrollTop > height_single_left) {

                $('.summary').addClass('remove-sticky-detail-half')

            } else {

                $('.summary').removeClass('remove-sticky-detail-half');

            }

            if (scrollTop > height_single_left) {

                $('.summary').addClass('remove-sticky-detail')

            } else {

                $('.summary').removeClass('remove-sticky-detail');

            }

            scrollUp = scrollTop;

        })

    }

    // Resize mega menu

    function smarket_resizeMegamenu() {

        var window_size = jQuery('body').innerWidth();

        window_size += smarket_get_scrollbar_width();

        if (window_size > 1024) {

            if ($('.site-header .header-menu').length > 0) {

                var container = $('.site-header .header-menu');

                if (container != 'undefined') {

                    var container_width = 0;

                    container_width = container.innerWidth();

                    var container_offset = container.offset();

                    setTimeout(function() {

                        $('.header-menu .item-megamenu').each(function(index, element) {

                            $(element).children('.megamenu').css({

                                'max-width': container_width + 'px'

                            });

                            var sub_menu_width = $(element).children('.megamenu').outerWidth();

                            var item_width = $(element).outerWidth();

                            $(element).children('.megamenu').css({

                                'left': '-' + (sub_menu_width / 2 - item_width / 2) + 'px'

                            });

                            var container_left = container_offset.left;

                            var container_right = (container_left + container_width);

                            var item_left = $(element).offset().left;

                            var overflow_left = (sub_menu_width / 2 > (item_left - container_left));

                            var overflow_right = ((sub_menu_width / 2 + item_left) > container_right);

                            if (overflow_left) {

                                var left = (item_left - container_left);

                                $(element).children('.megamenu').css({

                                    'left': -left + 'px'

                                });

                            }

                            if (overflow_right && !overflow_left) {

                                var left = (item_left - container_left);

                                left = left - (container_width - sub_menu_width);

                                $(element).children('.megamenu').css({

                                    'left': -left + 'px'

                                });

                            }

                        })

                    }, 100);

                }

            }

        }

    }

    function smarket_get_scrollbar_width() {

        var $inner = jQuery('<div style="width: 100%; height:200px;">test</div>'),

            $outer = jQuery('<div style="width:200px;height:150px; position: absolute; top: 0; left: 0; visibility: hidden; overflow:hidden;"></div>').append($inner),

            inner = $inner[0],

            outer = $outer[0];

        jQuery('body').append(outer);

        var width1 = inner.offsetWidth;

        $outer.css('overflow', 'scroll');

        var width2 = outer.clientWidth;

        $outer.remove();

        return (width1 - width2);

    }

    //Auto width vertical menu

    function smarket_auto_width_vertical_menu() {

        var full_width = parseFloat($('.container-inner').actual('width'));

        var menu_width = parseFloat($('.vertical-menu-content').actual('width'));

        var w = (full_width - menu_width);

        $('.vertical-menu-content').find('.megamenu').each(function() {

            $(this).css('max-width', w + 'px');

        });

    }

    //EQUAL ELEM

    

    //slick slide

    function slick_slide() {

        var window_size = jQuery('body').innerWidth();

        window_size += smarket_get_scrollbar_width();

        if (window_size > 1024) {

            $('.slider-for').slick({

                slidesToShow: 1,

                slidesToScroll: 1,

                arrows: false,

                fade: true,

                asNavFor: '.slider-nav'

            });

            $('.slider-nav').slick({

                vertical: true,

                slidesToShow: 4,

                slidesToScroll: 1,

                asNavFor: '.slider-for',

                dots: false,

                centerMode: true,

                focusOnSelect: true

            });

        } else {

            $('.slider-for').slick({

                slidesToShow: 1,

                slidesToScroll: 1,

                arrows: false,

                fade: true,

                asNavFor: '.slider-nav'

            });

            $('.slider-nav').slick({

                vertical: false,

                slidesToShow: 4,

                slidesToScroll: 1,

                asNavFor: '.slider-for',

                dots: false,

                centerMode: true,

                focusOnSelect: true

            });

        }

    }

    /* ---------------------------------------------

     Scripts initialization

     --------------------------------------------- */

    $(window).load(function() {

        smarket_resizeMegamenu();
        if(typeof better_equal_elems !== 'undefined'){
            better_equal_elems();
        }
        
        smarket_sticky_product();

    });

    /* ---------------------------------------------

     Scripts resize

     --------------------------------------------- */

    $(window).on("resize", function() {

        smarket_resizeMegamenu();

        better_equal_elems();

        smarket_auto_width_vertical_menu();

        smarket_menu_reposive();

        smarket_sticky_product();

        $('.slider-for').slick('resize');

        $('.slider-nav').slick('resize');

    });

    /* ---------------------------------------------

     Scripts scroll

     --------------------------------------------- */

    $(window).scroll(function() {

        smarket_resizeMegamenu();

    });

    /* ---------------------------------------------

     Scripts ready

     --------------------------------------------- */

    $(document).ready(function() {

        //Wow animate

        new WOW().init();

        smarket_auto_width_vertical_menu();

        sticky_header();

        sticky_product();

        smarket_sticky_product();

        // OWL CAROUSEL

        init_carousel();

        // Resize Megamenu

        tab_product_fade_effect();

        kt_countdown();

        smarket_resizeMegamenu();

        slick_slide();

        smarket_menu_reposive();

        $(window).scroll(function() {

            if ($(this).scrollTop() > 100) {

                $('#scrollup').fadeIn();

            } else {

                $('#scrollup').fadeOut();

            }

        });

        $('#scrollup').on('click', function() {

            $("html, body").animate({

                scrollTop: 0

            }, 600);

            return false;

        });

        if ($('.link-lightbox').length) {

            $('.link-lightbox').simpleLightboxVideo();

        }

        //open category

        $(document).on('click', '.open-cate', function() {

            $(this).closest('.vertical-menu-content').find('li.cat-link-orther').each(function() {

                $(this).slideDown();

            });

            $(this).addClass('colse-cate').removeClass('open-cate').html('Close');

        })

        $(document).on('click', '.colse-cate', function() {

            $(this).closest('.vertical-menu-content').find('li.cat-link-orther').each(function() {

                $(this).slideUp();

            });

            $(this).addClass('open-cate').removeClass('colse-cate').html('+ All Categories');

            return false;

        })

        //Woocommerce plus and minius

        $(document).on('click', '.quantity .plus, .quantity .minus', function(e) {

            // Get values

            var $qty = $(this).closest('.quantity').find('.qty'),

                currentVal = parseFloat($qty.val()),

                max = parseFloat($qty.attr('max')),

                min = parseFloat($qty.attr('min')),

                step = $qty.attr('step');

            // Format values

            if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;

            if (max === '' || max === 'NaN') max = '';

            if (min === '' || min === 'NaN') min = 0;

            if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

            // Change the value

            if ($(this).is('.plus')) {

                if (max && (max == currentVal || currentVal > max)) {

                    $qty.val(max);

                } else {

                    $qty.val(currentVal + parseFloat(step));

                }

            } else {

                if (min && (min == currentVal || currentVal < min)) {

                    $qty.val(min);

                } else if (currentVal > 0) {

                    $qty.val(currentVal - parseFloat(step));

                }

            }

            // Trigger change event

            $qty.trigger('change');

            e.preventDefault();

        });

        $('.slider-range-price').each(function() {

            var min = parseInt($(this).data('min'));

            var max = parseInt($(this).data('max'));

            var unit = $(this).data('unit');

            var value_min = parseInt($(this).data('value-min'));

            var value_max = parseInt($(this).data('value-max'));

            var label_reasult = $(this).data('label-reasult');

            var t = $(this);

            $(this).slider({

                range: true,

                min: min,

                max: max,

                values: [value_min, value_max],

                slide: function(event, ui) {

                    var result = label_reasult + " <span>" + unit + ui.values[0] + ' </span> - <span> ' + unit + ui.values[1] + '</span>';

                    t.closest('.price_slider_wrapper').find('.price_slider_amount').html(result);

                }

            });

        });

        // menu on mobile

        $(".header-nav .toggle-submenu").on('click', function() {

            $(this).parent().toggleClass('open-submenu');

            return false;

        });

        $(".box-vertical-megamenus .toggle-submenu").on('click', function() {

            $(this).parent().toggleClass('open-submenu');

            return false;

        });

        $("[data-action='toggle-nav']").on('click', function() {

            $(this).toggleClass('active');

            $(".header-nav").toggleClass("has-open");

            return false;

        });

        $(".header-menu .btn-close").on('click', function() {

            $('.header-nav').removeClass('has-open');

            return false;

        });

        // vertical megamenu click

        $(".box-vertical-megamenus .title").on('click', function() {

            $(this).toggleClass('active');

            $(this).parent().toggleClass('has-open');

            return false;

        });

        $(".vertical-menu-content .btn-close").on('click', function() {

            $('.box-vertical-megamenus').removeClass('has-open');

            return false;

        });

        //chosen-select

        if ($('.chosen-select').length > 0) {

            $('.chosen-select').chosen();

        }

        //categories click

        $(".categories-content").each(function() {

            var main = $(this);

            main.children('.cat-parent').each(function() {

                var curent = $(this).find('.children');

                $(this).children('.arrow-cate').on('click', function() {

                    $(this).parent().toggleClass('show-sub');

                    $(this).parent().children('.children').slideToggle(400);

                    main.find('.children').not(curent).slideUp(400);

                    main.find('.cat-parent').not($(this).parent()).removeClass('show-sub');

                });

                var next_curent = $(this).find('.children');

                next_curent.children('.cat-parent').each(function() {

                    var child_curent = $(this).find('.children');

                    $(this).children('.arrow-cate').on('click', function() {

                        $(this).parent().toggleClass('show-sub');

                        $(this).parent().parent().find('.cat-parent').not($(this).parent()).removeClass('show-sub');

                        $(this).parent().parent().find('.children').not(child_curent).slideUp(400);

                        $(this).parent().children('.children').slideToggle(400);

                    })

                });

            });

        });

    });

})(jQuery); // End of use strict
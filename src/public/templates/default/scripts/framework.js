/* global $ */
(function(w,n) {
    w[n].ready('framework',function() {
        /* sign-in handling */
        $.signedIn = function() {
            if ($('body').hasClass('not-signed-in')) {
                if (typeof $.signedInCover == 'undefined') {
                    $.signedInCover = function() {
                        $('.sign-in-cover')
                            .on('click',function() {
                                $('body')
                                    .removeClass('sign-in');
                                    
                                $('html, body')
                                    .animate({
                                        scrollTop: $('body').data('sign-in-scroll')
                                    },50);
                                    
                                $.signedInCover = false;
                            });
                    };
                }
                
                $('body')
                    .data('sign-in-scroll',$(window).scrollTop());
                
                setTimeout(function() {
                    $('body')
                        .addClass('sign-in');
                        
                    if ($.signedInCover) $.signedInCover();
                },10);
                
                return false;
            }
            
            return true;
        };
        
        $('.sign-in-required')
            .on('click',function(e) {
                if (!$.signedIn()) {
                    e.preventDefault();
                    
                    return false;
                }
            });
        
        /* menu and sidebar handling */
        $('.menu-open, .sidebar-open')
            .each(function() {
                $(this)
                    .on('click',function(a,p) {
                        if ($(this).hasClass('sidebar-open') && !$.signedIn()) return false;
                        
                        a = $(this).hasClass('menu-open')? 'menu' : 'sidebar';
                        p = (a == 'menu')? 'sidebar' : 'menu';
                        
                        $('body')
                            .addClass(a);
                            
                        if ($('body').hasClass(p)) {
                            $('body')
                                .removeClass(p);
                        }
                        
                        $('#header, #page')
                            .one('click',function() {
                                if ($('body').hasClass('menu')) {
                                    $('.menu-close')
                                        .trigger('click');
                                }
                                
                                if ($('body').hasClass('sidebar')) {
                                    $('.sidebar-close')
                                        .trigger('click');
                                }
                            });
                    })
                    .next()
                    .on('click',function(a) {
                        a = $(this).hasClass('menu-close')? 'menu' : 'sidebar';
                        
                        if ($('body').hasClass(a)) {
                            $('body')
                                .removeClass(a);
                        }
                    });
            });
            
        $(window)
            .on('resize',function() {
                if ($('.header-nav li:last').position().top > 0) {
                    $('.header-nav button')
                        .show();
                        
                    if (!$(this).data('header-navn-button-resize-triggered')) $(this).data('header-navn-button-resize-triggered',true);
                }
                else if ($(this).data('header-navn-button-resize-triggered')) {
                    $('.header-nav button')
                        .hide();
                }
            })
            .trigger('resize');
        
        /* esc handling */
        $(window)
            .on('keydown',function(e) {
                if (e.which == 27) {
                    if ($('body').hasClass('menu')) {
                        $('body')
                            .removeClass('menu');
                    }
                    
                    if ($('body').hasClass('sidebar')) {
                        $('body')
                            .removeClass('sidebar');
                    }
                    
                    if ($('body').hasClass('sign-in')) {
                        $('.sign-in-cover')
                            .trigger('click');
                    }
                    
                    if ($('#page').hasClass('toolbox')) {
                        $('.toolbox-menu-item-filter-close')
                            .trigger('click');
                    }
                }
            });
        
        /* scrolling handling */
        $(window)
            .on('scroll',function() {
                /* #header is scrolled */
                if ($.scrollDetecter) clearTimeout($.scrollDetecter);
                
                $.scrollDetecter = setTimeout(function(w,h,c,s) {
                    w = $(window);
                    h = $('#header');
                    c = 'is-scrolled';
                    s = h.hasClass(c);
                    
                    if (w.scrollTop() > 0) {
                        if (!s) h.addClass(c);
                    }
                    else {
                        if (s) h.removeClass(c);
                    }
                },200);
            })
            .trigger('scroll');
        
        $(window)
            .on('scroll',function() {
                /* fixed #toolbox and #list */
                if ($.scrollAdjuster) clearTimeout($.scrollAdjuster);
                
                $.scrollAdjuster = setTimeout(function() {
                    if ($(window).scrollTop() > 0 || $(this).data('scroll-top-triggered')) {
                        $('#toolbox, #list')
                            .animate({
                                top: $(window).scrollTop()
                            },100);
                            
                        if (!$(this).data('scroll-top-triggered')) $(this).data('scroll-top-triggered',true);
                    }
                },300);
            })
            .trigger('scroll');
        
        /* toolbox search handling */
        $('.toolbox-menu-item-search')
            .on('click',function() {
                if ($('#list').toggleClass('search').hasClass('search')) {
                    $('.toolbox-menu-item-search')
                        .parent()
                        .addClass('active');
                    
                    setTimeout(function() {
                        $('#search')
                            .trigger('focus');
                    },100);
                }
                else {
                    $('.toolbox-menu-item-search')
                        .parent()
                        .removeClass('active');
                }
                
                if ($.searchHandler) $.searchHandler();
            })
            .eq(0)
            .each(function() {
                $.searchHandler = function() {
                    $('#search')
                        .on('blur',function() {
                            if ($(this).val().trim().length == 0) {
                                $('.toolbox-menu-item-search-close')
                                    .trigger('click');
                            }
                        })
                        .on('keydown',function(e) {
                            if (e.which == 27) {
                                $(this)
                                    .val('')
                                    .trigger('blur');
                            }
                        });
                        
                    $.searchHandler = null;
                };
            });
        
        /* toolbox filtering handling */
        $('.toolbox-menu-item-filter')
            .on('click',function() {
                if ($('#page').toggleClass('toolbox').hasClass('toolbox')) {
                    $('.toolbox-menu-item-filter')
                        .parent()
                        .addClass('active');
                }
                else {
                    $('.toolbox-menu-item-filter')
                        .parent()
                        .removeClass('active');
                }
            });
    });
})(window,'s');
(function ($) {
    "use strict";


    /*--
        Header Sticky
    -----------------------------------*/
    $(window).on('scroll', function (event) {
        var scroll = $(window).scrollTop();
        if (scroll <= 100) {
            $(".main-header").removeClass("sticky");
        } else {
            $(".main-header").addClass("sticky");
        }
    });


    /*--
        Menu Active
    -----------------------------------*/
    $(function () {
        var url = window.location.pathname;
        var activePage = url.substring(url.lastIndexOf('/') + 1);
        $('.nav-menu li a').each(function () {
            var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1);

            if (activePage == linkPage) {
                $(this).closest("li").addClass("active");
            }
        });
    });

    // signup-tab Start ----------------->
    $('.signup-tab button').each((i, btn) => {
        btn.addEventListener('click', (e) => {
            $('.signup-tab button').each((i, item) => { item.classList.remove("active") });
            e.target.classList.add('active')
        });
    });

    // Menu Blog Start ---------->
    $(function () {
        var url = window.location.pathname;
        var activePage = url.substring(url.lastIndexOf('/') + 1);
        $('.menu-blog li a').each(function () {
            var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1);

            if (activePage == linkPage) {
                $(this).closest("a").addClass("active");
            }
        });
    });
    // Menu Blog End <-----------
    /*--
        Menu Script
    -----------------------------------*/

    function menuScript() {

        $('.menu-toggle').on('click', function () {
            $('.mobile-menu').addClass('open')
            $('.overlay').addClass('open')
        });

        $('.menu-close').on('click', function () {
            $('.mobile-menu').removeClass('open')
            $('.overlay').removeClass('open')
        });

        $('.overlay').on('click', function () {
            $('.mobile-menu').removeClass('open')
            $('.overlay').removeClass('open')
        });

        /*Variables*/
        var $offCanvasNav = $('.mobile-menu-items'),
            $offCanvasNavSubMenu = $offCanvasNav.find('.sub-menu');

        /*Add Toggle Button With Off Canvas Sub Menu*/
        $offCanvasNavSubMenu.parent().prepend('<span class="mobile-menu-expand"></span>');

        /*Close Off Canvas Sub Menu*/
        $offCanvasNavSubMenu.slideUp();

        /*Category Sub Menu Toggle*/
        $offCanvasNav.on('click', 'li a, li .mobile-menu-expand, li .menu-title', function (e) {
            var $this = $(this);
            if (($this.parent().attr('class').match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('mobile-menu-expand'))) {
                e.preventDefault();
                if ($this.siblings('ul:visible').length) {
                    $this.parent('li').removeClass('active-expand');
                    $this.siblings('ul').slideUp();
                } else {
                    $this.parent('li').addClass('active-expand');
                    $this.closest('li').siblings('li').find('ul:visible').slideUp();
                    $this.closest('li').siblings('li').removeClass('active-expand');
                    $this.siblings('ul').slideDown();
                }
            }
        });

        $(".sub-menu").parent("li").addClass("menu-item-has-children");
    }
    menuScript();

    /*--
        Magnific Popup Activation
    -----------------------------------*/
    // $('.video-popup').magnificPopup({
    //     type: 'iframe'
    //     // other options
    // });

    // $('.image-popup').magnificPopup({
    //     type: 'image',
    //     gallery: {
    //         enabled: true
    //     }
    // });


    /*--
        Courses Tabs Menu
    -----------------------------------*/
    var edule = new Swiper('.courses-active .swiper-container', {
        speed: 600,
        spaceBetween: 30,
        navigation: {
            nextEl: '.courses-active .swiper-button-next',
            prevEl: '.courses-active .swiper-button-prev',
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 4,
            },
            1200: {
                slidesPerView: 5,
            }
        },
    });


    /*--
        Testimonial
    -----------------------------------*/
    // var edule = new Swiper('.testimonial-active .swiper-container', {
    //     speed: 600,
    //     spaceBetween: 30,
    //     pagination: {
    //         el: '.testimonial-active .swiper-pagination',
    //         clickable: true,
    //     },
    //     breakpoints: {
    //         0: {
    //             slidesPerView: 1,
    //         },
    //         768: {
    //             slidesPerView: 2,
    //         },
    //         992: {
    //             slidesPerView: 3,
    //         }
    //     },
    // });
    // Teachears -----------
    // var swiper = new Swiper('.teachers-active .swiper-container', {
    //     slidesPerView: 3,
    //     speed: 600,
    //     spaceBetween: 30,
    //     pagination: {
    //         el: '.teachers-active .swiper-pagination',
    //         clickable: true,
    //     },
    //     // breakpoints: {
    //     //     0: {
    //     //         slidesPerView: 1,
    //     //     },
    //     //     768: {
    //     //         slidesPerView: 2,
    //     //     },
    //     //     992: {
    //     //         slidesPerView: 3,
    //     //     }
    //     // },
    //     breakpoints: {
    //         "@0.00": {
    //             slidesPerView: 1,
    //             spaceBetween: 10,
    //         },
    //         "@0.75": {
    //             slidesPerView: 2,
    //             spaceBetween: 20,
    //         },
    //         "@1.00": {
    //             slidesPerView: 3,
    //             spaceBetween: 40,
    //         },
    //         "@1.50": {
    //             slidesPerView: 4,
    //             spaceBetween: 50,
    //         },
    //     },
    // });

    /*--
        Brand
    -----------------------------------*/
    // var edule = new Swiper('.brand-active .swiper-container', {
    //     speed: 600,
    //     spaceBetween: 30,
    //     navigation: {
    //         nextEl: '.brand-active .swiper-next',
    //         prevEl: '.brand-active .swiper-prev',
    //     },
    //     loop: true,
    //     breakpoints: {
    //         0: {
    //             slidesPerView: 1,
    //             spaceBetween: 20,
    //         },
    //         576: {
    //             slidesPerView: 3,
    //         },
    //         768: {
    //             slidesPerView: 4,
    //         },
    //         992: {
    //             slidesPerView: 5,
    //             spaceBetween: 45,
    //         },
    //         1200: {
    //             slidesPerView: 5,
    //             spaceBetween: 85,
    //         }
    //     },
    //     autoplay: {
    //         delay: 8000,
    //     },
    // });


    /*--
        Reviews
    -----------------------------------*/
    var edule = new Swiper('.reviews-active .swiper-container', {
        speed: 600,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: '.reviews-active .swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 8000,
        },
    });


    /*--
        Student's
    -----------------------------------*/
    var edule = new Swiper('.students-active .swiper-container', {
        speed: 600,
        spaceBetween: 30,
        navigation: {
            nextEl: '.students-active .swiper-button-next',
            prevEl: '.students-active .swiper-button-prev',
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1600: {
                slidesPerView: 3,
            }
        },
    });


    /*--
        Rating Script
    -----------------------------------*/

    $("#rating li").on('mouseover', function () {
        var onStar = parseInt($(this).data('value'), 10);
        var siblings = $(this).parent().children('li.star');
        Array.from(siblings, function (item) {
            var value = item.dataset.value;
            var child = item.firstChild;
            if (value <= onStar) {
                child.classList.add('hover')
            } else {
                child.classList.remove('hover')
            }
        })
    })

    $("#rating").on('mouseleave', function () {
        var child = $(this).find('li.star i');
        Array.from(child, function (item) {
            item.classList.remove('hover');
        })
    })


    $('#rating li').on('click', function (e) {
        var onStar = parseInt($(this).data('value'), 10);
        var siblings = $(this).parent().children('li.star');
        Array.from(siblings, function (item) {
            var value = item.dataset.value;
            var child = item.firstChild;
            if (value <= onStar) {
                child.classList.remove('hover', 'fa-star-o');
                child.classList.add('star')
            } else {
                child.classList.remove('star');
                child.classList.add('fa-star-o')
            }
        })
    })


    /*--
        Video Active
    -----------------------------------*/
    $('.video-playlist .link').on('click', function (event) {
        $(this).siblings('.active').removeClass('active');
        $(this).addClass('active');
        event.preventDefault();
    });


    // Start Select Dropdown
    // $('.dropdown-link a.link-profile').on('click', function () {
    //     $('.dropdown-link ul.dropdown-menu').toggle('show');
    // });
    // // -------------------
    // $('.dropdown-notification a.link-notification').on('click', function () {
    //     $('.dropdown-notification ul.dropdown-notification').toggle('show');
    // });
    // End Select Dropdown

    /*--
        Nice Select
    -----------------------------------*/
    // $('select').niceSelect();


    /*--
        Back to top Script
    -----------------------------------*/
    // Show or hide the sticky footer button
    $(window).on('scroll', function (event) {
        if ($(this).scrollTop() > 600) {
            $('.back-to-top').fadeIn(200)
        } else {
            $('.back-to-top').fadeOut(200)
        }
    });

    //Animate the scroll to yop
    $('.back-to-top').on('click', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: 0,
        }, 1500);
    });

    // Start how work scroll up and down function
    let lastChildItem = Array.from($('.widget_item-works'));
    let numS = 1;
    if ($('.widget_item-works').length <= 4) {
        $('#how-work #scroll-up').addClass("d-none");
        $('#how-work #scroll-down').addClass("d-none");
    } else {
        $('#how-work #scroll-up').addClass("d-block");
        $('#how-work #scroll-down').addClass("d-block");
    }
    $('#how-work #scroll-up').on('click', () => {
        numS = 1;
        $('#how-work #scroll-down').removeClass("not-pointer");
        $('#work-box-slide').animate({
            scrollTop: 0,
        }, 300);
    });
    $('#how-work #scroll-down').on('click', () => {
        $("#work-box-slide").animate({
            scrollTop: lastChildItem[numS].offsetTop,

        }, 300);
        numS === lastChildItem.length - 1 ? $('#how-work #scroll-down').addClass("not-pointer") : numS++;
    });
    // End how work scroll up and down function

    // Start Loop Animation In Hero Section
    let textElement = document.querySelector(".swiper-homePage .home-content .middale-title h2");
    if (textElement) {
        let words = textElement.textContent.split(' ');
        textElement.innerHTML = "";
        const filteredWords = words.filter(word => word.trim() !== "");
        filteredWords.map(word => {
            textElement.innerHTML += `<span>${word}</span> `;
        });
        let spans = textElement.querySelectorAll('span');
        let totalTime = words.length * 2 + 2;
        function animateWords() {
            spans.forEach((span, index) => {
                let delayIn = index * 2; // Delay before fade-in
                let delayOut = totalTime - 2; // Delay before fade-out (after all have faded in)
                span.style.animation = `text-fade-in 2s ${delayIn}s forwards, text-fade-out 2s ${delayOut}s forwards`;
            });

            setTimeout(() => {
                spans.forEach(span => {
                    span.style.opacity = 0; // Reset opacity to 0 for all spans
                    span.style.animation = ''; // Reset animation
                });
                setTimeout(animateWords, 500); // Restart the animation after a brief delay
            }, totalTime * 1000); // Wait for the full cycle before restarting
        }
        animateWords();
    }
    // End Loop Animation In Hero Section <3
    // Start Books Animation on Hover
    const booksAnimation = document.querySelector('.swiper-homePage .books-animation');
    const booksAnimationItems = document.querySelectorAll('img.animation-items');

    if (booksAnimation) {
        booksAnimation.onmouseover = () => {
            const closedBook = booksAnimation.querySelector('img.closed-book');
            if (closedBook) {
                closedBook.style.display = 'none';
            }

            booksAnimationItems.forEach((item, index) => {
                item.style.display = 'block';

                // Add delay for staggered effect using setTimeout
                setTimeout(() => {
                    item.style.opacity = 1;
                }, index * 300); // 300ms delay between each item
            });
        };
    }
    // End Books Animation on Hover
})(jQuery);







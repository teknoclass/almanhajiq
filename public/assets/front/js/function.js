// const { auto } = require("@popperjs/core");

(function ($) {
    "use-strict";


    $(window).on("load", function () {
        $(".loader-page").fadeOut(500);
        wow = new WOW({
            animateClass: "animated",
            offset: 50,
        });
        wow.init();
    });

    /*------------------------------------
          menu mobile
      --------------------------------------*/
    $(".header-mobile__toolbar,.mobile-menu-overlay,.main-header .btn-close-header-mobile").on("click", function () {
        $(".menu--mobile").toggleClass("menu-mobile-active");
        $(".mobile-menu-overlay").toggleClass("mobile-menu-overlay-active");
    });


    // Start Ready SetActive Method
    function setActive(arr) {
        arr.forEach((item) => {
            item.addEventListener("click", (e) => {
                arr.forEach(el => el.classList.remove("active"));
                e.currentTarget.classList.add("active");
            });
        });
    }
    // End Ready SetActive Method
    //  Start Lecturer Page Filter
    setActive(document.querySelectorAll('#lecturer .filter-form-body .filter-head .time-create-event a'));
    setActive(document.querySelectorAll('#lecturer .filter-form-body .filter-head .category-link li a'));
    //  End Lecturer Page Filter


    /*------------------------------------
         fancybox
      --------------------------------------*/

    $('[data-fancybox]').fancybox({
        // Options will go here
    });








    /*------------------------------------
          selectpicker
      --------------------------------------*/
    $(".selectpicker").selectpicker();




    /*------------------------------------
          toggle search
      --------------------------------------*/
    $(".toggle-search").click(function () {
        $('.dropdow-search').toggleClass('active')
    })







    $(window).scroll(function () {
        $(".tab").each(function () {
            if ($(window).scrollTop() > $(this).offset().top - 60) {
                var blockID = $(this).attr("id");
                $(".nav-tabs .nav-item .nav-link[data-scroll]").removeClass("active");
                $('.nav-tabs .nav-item .nav-link[data-scroll="' + blockID + '"]').addClass(
                    "active"
                );
            }
        });
    });

    $(".nav-course [data-scroll]").click(
        function (e) {
            e.preventDefault();
            $("html, body").animate(
                {
                    scrollTop: $("#" + $(this).data("scroll")).offset().top - 50,
                },
                1400
            );
        }
    );

    $(".same-page-nav-link [data-scroll]").click(
        function (e) {
            e.preventDefault();
            $("html, body").animate(
                {
                    scrollTop: $("#" + $(this).data("scroll")).offset().top - 50,
                },
                1400
            );
        }
    );








    /*------------------------------------
         Chnage Image Profile
     --------------------------------------*/
    $(".imgload").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                console.log($(this).closest('.uploadImg'))
                $('.uploadImg').find('i').fadeOut(0)
                $('.imgShow').attr('src', e.target.result).fadeIn();
            }
            reader.readAsDataURL(this.files[0]);
        }
    });






    // $(".widget_item-faq .form-control").keyup(function() {
    //     var input = $(this);
    //     if( input.val() != "" ) {
    //       $(this).closest('.widget_item-faq ').addClass('selected')
    //     }else{
    //       $(this).closest('.widget_item-faq ').removeClass('selected')
    //     }
    // });

})(jQuery);

var swiper_2 = new Swiper(".swiper-filter", {
    speed: 1000,
    slidesPerView: 3,
    grid: {
        rows: 2,
    },
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-filter .swiper-pagination",
        clickable: true,
    },
    spaceBetween: 15,
    breakpoints: {
        0: {
            slidesPerView: 1,
            grid: {
                rows: 2,
            },
        },
        992: {
            slidesPerView: 2,
            grid: {
                rows: 2,
            },
        },
        1200: {
            slidesPerView: 3,
            grid: {
                rows: 2,
            },
        },
    }
});

$(".categories .item-categ").on("click", function () {
    var filter = $(this).data("filter");
    $(".categories .item-categ");
    $(".categories .item-categ").removeClass("active");
    $(this).addClass("active");

    if (filter == "all") {
        $(".swiper-filter [data-filter]")
            .show();
    } else {
        $(".swiper-filter .swiper-slide")
            .not("[data-filter='" + filter + "']")
            .hide();
        $(".swiper-filter [data-filter='" + filter + "']")
            .show();
    }
});

var swiperblog = new Swiper(".swiper-blog", {
    slidesPerView: 3,
    // centeredSlides: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false
    },
    spaceBetween: 20,
    speed: 1500,
    navigation: {
        nextEl: ".swiper-blog .swiper-button-next",
        prevEl: ".swiper-blog .swiper-button-prev",
    },
    pagination: {
        el: ".swiper-blog .swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        576: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        992: {
            slidesPerView: 3,
        },
        1200: {
            slidesPerView: 3,
        }
    },
    // on: {
    //     init: function () {
    //         $(".swiper-blog .swiper-slide-active .swiper-title").addClass("fadeInUp");
    //         $(".swiper-blog .swiper-slide-active .swiper-text").addClass("fadeInUp");
    //     },
    //     transitionStart: function () {
    //         $(".swiper-blog .swiper-title").removeClass("fadeInUp");
    //         $(".swiper-blog .swiper-text").removeClass("fadeInUp");
    //         $(".swiper-blog .swiper-slide-active .swiper-title").addClass("fadeInUp");
    //         $(".swiper-blog .swiper-slide-active .swiper-text").addClass("fadeInUp");
    //     },
    //     onSlideChangeEnd: function (swiper) {
    //         $(".swiper-blog .swiper-title").removeClass("fadeInUp");
    //         $(".swiper-blog.swiper-text").removeClass("fadeInUp");
    //     },
    // },
});
/* Not use
var swiperTeacher = new Swiper(".swiper-teacher", {
    slidesPerView: 1,
    spaceBetween: 15,
    speed: 1000,
    navigation: {
        nextEl: ".swiper-action-teacher .swiper-next",
        prevEl: ".swiper-action-teacher .swiper-prev",
    },
});
*/





var swiperLatestBlog = new Swiper(".swiper-latestBlog", {
    slidesPerView: 1,
    spaceBetween: 10,
    speed: 1500,
    // autoplay: {
    //   delay: 4000,
    //   disableOnInteraction: false
    // },
    navigation: {
        nextEl: '.latestBlog .swiper-next',
        prevEl: '.latestBlog .swiper-prev'
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        576: {
            slidesPerView: 1,
        },
        992: {
            slidesPerView: 2,
        },
    },
});

var swiperLatestBlog = new Swiper(".swiper-latestBlog-2", {
    slidesPerView: 1,
    spaceBetween: 0,
    speed: 1500,
    // autoplay: {
    //   delay: 4000,
    //   disableOnInteraction: false
    // },
    navigation: {
        nextEl: '.latestBlog .swiper-next',
        prevEl: '.latestBlog .swiper-prev'
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        576: {
            slidesPerView: 2,
        },
        992: {
            slidesPerView: 3,
        },
    },
});

var swiperHomePage = new Swiper(".swiper-homePage", {
    slidesPerView: 1,
    loop: $(".swiper-homePage .swiper-slide").length > 1,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    effect: "slide",
    speed: 1500,
    navigation: {
        nextEl: ".swiper-homePage .swiper-button-next",
        prevEl: ".swiper-homePage .swiper-button-prev",
    }
});

var swiperAboutStudent = new Swiper(".swiper-rating", {
    slidesPerView: 1,
    spaceBetween: 30,
    speed: 1500,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false
    },
    navigation: {
        nextEl: '.swiper-action-rating .swiper-next',
        prevEl: '.swiper-action-rating .swiper-prev'
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        576: {
            slidesPerView: 1,
        },
        992: {
            slidesPerView: 2,
        },
    },
});
/*--
    Testimonial
-----------------------------------*/
var swiper = new Swiper('.testimonial-active .swiper-container', {
    speed: 600,
    spaceBetween: 30,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.testimonial-active .swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        992: {
            slidesPerView: 2,
        }
    },
});

// Teachers ----------------
const teacherSwiper = new Swiper('.teachers-active .swiper-container', {
    slidesPerView: 2,
    spaceBetween: 30,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    freeMode: true,
    navigation: {
        nextEl: '.teachers-active .swiper-next',
        prevEl: '.teachers-active .swiper-prev'
    },
    breakpoints: {
        "@0.00": {
            slidesPerView: 1,
            spaceBetween: 10,
        },
        "@0.75": {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        "@1.00": {
            slidesPerView: 2,
            spaceBetween: 40,
        },
        "@1.50": {
            slidesPerView: 2,
            spaceBetween: 50,
        },
        "@2.00": {
            slidesPerView: 3,
            spaceBetween: 50,
        }
    },
});

// Teams
const teansSwiper = new Swiper('.swiper-teams .swiper-container', {
    slidesPerView: 2,
    spaceBetween: 30,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    freeMode: true,
    pagination: {
        el: '.swiper-teams .swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        "@0.00": {
            slidesPerView: 1,
            spaceBetween: 10,
        },
        "@0.75": {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        "@1.00": {
            slidesPerView: 2,
            spaceBetween: 40,
        },
        "@1.50": {
            slidesPerView: 2,
            spaceBetween: 50,
        },
        "@2.00": {
            slidesPerView: 3,
            spaceBetween: 50,
        }
    },
});

/*--
    Brand
-----------------------------------*/
const brandSwiper = new Swiper('.brand-active .swiper-container', {
    spaceBetween: 25,
    autoplay: {
        delay: 1000,
        disableOnInteraction: false,
    },
    loop: true,
    speed: 1000,
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        420: {
            slidesPerView: 2
        },
        992: {
            slidesPerView: 4,
        },
        1199: {
            slidesPerView: 7,
        },
    },
});

// About Page:Swiper
const ourTeamSwiper = new Swiper(".our-team .swiper-container", {
    spaceBetween: 20,
    centeredSlides: true,
    autoplay: {
        delay: 1000,
        disableOnInteraction: false,
    },
    speed: 1000,

    freeMode: true,
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1199: {
            slidesPerView: 3,
        },
    },
});
const foundersSwiper = new Swiper(".founders .swiper-container", {
    spaceBetween: 20,
    autoplay: {
        delay: 1000,
        disableOnInteraction: false,
    },
    speed: 1000,

    freeMode: true,
    breakpoints: {
        0: {
            slidesPerView: 1,
            spaceBetween: 60,
        },
        768: {
            slidesPerView: 2,
        },
        1199: {
            slidesPerView: 3,
        },
    },
});

/*------------------------------------
       upload image
   --------------------------------------*/
// Input image 1
$(".input-file-image-1").on('change', function () {
    var $this = $(this)
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        var fileName = this.files[0].name;
        reader.onload = function (e) {
            $($this).closest('.input-image-preview').addClass('uploaded')
            $($this).closest('.input-image-preview').find('.img-show').text(fileName).fadeIn();
        }
        reader.readAsDataURL(this.files[0]);
    }
});

// Input image 2
$(".input-file-image-2").on('change', function () {
    var $this = $(this)
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            console.log($(this))
            $($this).closest('.input-image-preview').addClass('uploaded')
            $($this).closest('.input-image-preview').find('.img-show').attr('src', e.target.result).fadeIn();
        }
        reader.readAsDataURL(this.files[0]);
    }
});
// // Input image 3
$(".input-file-image-3").on('change', function () {
    var $this = $(this)
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            console.log($(this))
            $($this).closest('.input-image-preview').addClass('uploaded')
            $($this).closest('.input-image-preview').find('.img-show').attr('src', e.target.result).fadeIn();
        }
        reader.readAsDataURL(this.files[0]);
    }
});

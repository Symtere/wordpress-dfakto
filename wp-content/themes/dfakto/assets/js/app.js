function debounce(func, wait, immediate) {
    var timeout;

    return function () {
        var context = this, args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

/*
window.addEventListener('wheel', debounce(function(e) {
    slideAnim(event);
}, 90));
*/

//== Close offAsideMenuCanvas on resize
const asideMenu = document.getElementById('aside-menu');
if (null != asideMenu) {

    const offAsideMenuCanvas = new bootstrap.Offcanvas(asideMenu);

    window.addEventListener('resize', debounce((e) => {
        offAsideMenuCanvas.hide();
    }, 40));
}

//== Avoid menu close onclick inside dropdown menu
const asideDropdown = document.querySelector('#aside-menu .dropdown-menu');
if (asideDropdown != null) {

    document.querySelector('#aside-menu .dropdown-menu').addEventListener('click', (e) => {
        e.stopPropagation();
    });
}

//== Sticky header (for animation)
function addStickyClassToHeader() {

    const header = document.getElementById('header');

    if (null != header) {

        window.addEventListener('scroll', debounce((e) => {

            if (window.pageYOffset > 0) {
                header.classList.add('is-sticky');
            } else {
                header.classList.remove('is-sticky');
            }
        }, 10));
    }
}
addStickyClassToHeader();

//== Sliders
const swiperLoader = {

    on: {
        afterInit: (e) => {
            e.el.classList.remove('swiper-is-loading');
        },
    },
}

document.addEventListener('DOMContentLoaded', (event) => {

    //== TODO :: Example slider => remove me if unecessary
    function exampleSlider() {

        const relatedProductsId = document.getElementById('related-products-slider');
        if (relatedProductsId != null) {

            const relatedProductsSwiper = new Swiper(relatedProductsId, {
                slidesPerView: 1.4,
                spaceBetween: 15,
                allowTouchMove: true,
                watchOverflow: true,
                centeredSlidesBounds: true,
                lazyLoading: true,
                grabCursor: true,
                pagination: {
                    el: '.products-slider-pagination',
                    type: 'bullets',
                    clickable: true,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1.3,
                        spaceBetween: 15,
                        centeredSlidesBounds: true,
                    },
                    569: {
                        slidesPerView: 2,
                        spaceBetween: 15,
                        centeredSlidesBounds: false,
                    },
                    892: {
                        slidesPerView: 3,

                    }
                },
                ...swiperLoader
            });
        }
    }
    // exampleSlider();


    //== Parallax
    function setBannerParallax() {
        const banners = document.querySelectorAll('.wp-block-cover.is-style-has-parallax');

        if (banners) {

            banners.forEach(banner => {
                banner.classList.add('jarallax');
                const bannerImg = banner.querySelector('.wp-block-cover__image-background');

                if (bannerImg) {
                    bannerImg.classList.add('jarallax-img');

                    jarallax(banner, {
                        speed: 0.5,
                        imgPosition: '50% 0',
                    });
                }
            });
        }
    }
    setBannerParallax();

    //== Header sticky if no banner first
    const noBannerFirst = document.querySelector('.site-main .container > .no-page-banner-first');
    const body = document.querySelector('body');

    if (null !== noBannerFirst && null !== body) {
        body.classList.add('has-header-bg');
    }




    function testimonialSlider() {

        const testimonialSlider = document.querySelector('.row-testimonials');
        if (testimonialSlider != null) {

            const testimonialSliderSwiper = new Swiper(testimonialSlider, {
                slidesPerView: 1,
                allowTouchMove: true,
                watchOverflow: true,
                centeredSlidesBounds: true,
                lazyLoading: true,
                grabCursor: true,
                pagination: {
                    el: '.testimonials-slider-pagination',
                    type: 'bullets',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.testimonials-button-next',
                    prevEl: '.testimonials-button-prev',
                },
                breakpoints: {
                    0: {
                    },
                    569: {
                    },
                    892: {

                    }
                },
                ...swiperLoader
            });
        }
    }
    testimonialSlider();


});

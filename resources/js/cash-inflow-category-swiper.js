import Swiper from 'swiper';
import '../css/cash-inflow-category-swiper.css';

const cashInflowSwiper = new Swiper('.cash-inflow-category-swiper', {
    // direction: "horizontal",
    // slidesPerView: 'auto',
    // spaceBetween: 5,
    // mousewheel: {
    //     forceToAxis: true, // Optional: Forces mousewheel to work only with the defined direction
    // },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },
    speed: 400,
    spaceBetween: 10,
    direction: 'horizontal',
    slidesPerView: 3,
    navigation: {
        nextEl: '.swiper-button-previous-works-next',
        prevEl: '.swiper-button-previous-works-prev',
    },
});
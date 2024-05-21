const swiperForm = new Swiper('.form__body', {
    rewind: 0,
    navigation: {
        nextEl: '.form__question__next',
        prevEl: '.form__question__prev',
    },
    spaceBetween: 30,
    simulateTouch: 0,
    touchRatio: 1,
    touchAngle: 45,
    grabCursor: 0,
    allowTouchMove: false,
    autoHeight: true

});
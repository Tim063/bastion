$(document).ready((function() {
    $(".header__nav__burger").click((function(event) {
        event.stopPropagation();
        $(".header__nav__burger").toggleClass("header__nav__burger_open"), $(".list_flex").toggleClass("header__nav__list_open"), $("body").toggleClass("fixed-page")
    })), $(".list__item").click((function() {
        $(".list_flex").removeClass("header__nav__list_open"), $(".header__nav__burger").removeClass("header__nav__burger_open"), $("body").removeClass("fixed-page")
    })),
    $(document).on("click", function(e) {
        if ($(e.target).closest('.list__item_price').length === 0) {
            $(".list_flex").removeClass("header__nav__list_open");
            $(".header__nav__burger").removeClass("header__nav__burger_open");
            $("body").removeClass("fixed-page");
        }
    });
}));

ymaps.ready(init);
function init(){
    // Создание карты.
    var myMap = new ymaps.Map("map", {
        // Координаты центра карты.
        // Порядок по умолчанию: «широта, долгота».
        // Чтобы не определять координаты центра карты вручную,
        // воспользуйтесь инструментом Определение координат.
        center: [53.50463425336131, 49.294920625590734],
        // Уровень масштабирования. Допустимые значения:
        // от 0 (весь мир) до 19.
        zoom: 17
    });

    if (window.matchMedia("(max-width: 1070px)").matches) {
    myMap.setCenter([53.50440056099693,49.28934848102063])
    };

    if (window.matchMedia("(max-width: 540px)").matches) {
    myMap.setCenter([53.509,49.296]);
    myMap.setZoom(15)
    };

    myMap.controls.remove('geolocationControl'); // удаляем геолокацию
    myMap.controls.remove('searchControl'); // удаляем поиск
    myMap.controls.remove('trafficControl'); // удаляем контроль трафика
    myMap.controls.remove('typeSelector'); // удаляем тип
    myMap.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим
    myMap.controls.remove('zoomControl'); // удаляем контрол зуммирования
    myMap.controls.remove('rulerControl'); // удаляем контрол правил

    var myPlacemark = new ymaps.Placemark([53.50463425336131, 49.294920625590734], {}, {
        iconLayout: 'default#image',
        iconImageHref: 'images/map.svg',
        icon_imagesize: [122, 122]
    });

    myMap.geoObjects.add(myPlacemark);
}
ymaps.ready(init);
function init () {
    var centerMap = jQuery("#yandex-map").attr("data-point");
    if(centerMap){
        centerMap = centerMap.split(",");
        var myMap = new ymaps.Map("yandex-map", {
            center: [centerMap[0], centerMap[1]],
            zoom: 14,
            behaviors: ["default", "scrollZoom"],
            controls: ["zoomControl"]
        });

        myMap.behaviors.disable('scrollZoom');
        var myPlacemark = new ymaps.Placemark([centerMap[0], centerMap[1]]);
        return myMap.geoObjects.add(myPlacemark);
    }
}

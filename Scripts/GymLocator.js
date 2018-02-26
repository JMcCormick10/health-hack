var infowindowContent;
var markerArray = [];
//var curresult;
window.onload = function() {
    var infoWindow;
    infowindowContent = document.getElementById('infowindow-content');
    var service;
    initMap();
}
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14
    });

    var gcoder = new google.maps.Geocoder();
    var address = "205 Humber College Blvd, Toronto, ON M9W 5L7";
    gcoder.geocode(
        { 'address': address },
        function(results, status) {
            if (status == 'OK') {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    position: results[0].geometry.location,
                    map: map
                });
                markerArray.push(marker);
            }
        }
    );

    searchForGyms(map);
    searchForPlace(map);
}

function searchForGyms(map) {
    infoWindow = new google.maps.InfoWindow();
    service = new google.maps.places.PlacesService(map);

    map.addListener('idle', performSearch);

    function performSearch() {
        var request = {
            bounds: map.getBounds(),
            keyword: "gym",
            location: map.getCenter(),
            radius: 2000,
            type: "gym"
        };
        service.nearbySearch(request, callback);
    }

    function callback(results, status) {
        if (status !== google.maps.places.PlacesServiceStatus.OK) {
            return;
        }
        for (var i = 0, result; result = results[i]; ++i) {
            addMarker(result);
        }
    }

    function addMarker(place) {
        var marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location,
            icon: {
                url: 'https://developers.google.com/maps/documentation/javascript/images/circle.png',
                anchor: new google.maps.Point(10, 10),
                scaledSize: new google.maps.Size(10, 17)
            }
        });

        google.maps.event.addListener(marker, 'click', function() {
            service.getDetails(place, function(result, status) {
                if (status  !== google.maps.places.PlacesServiceStatus.OK) {
                    console.log(status);
                    return;
                }
                console.log(result.place_id);
                infoWindow.setContent(infowindowContent);
                infowindowContent.children['place-name'].textContent = result.name;
                infowindowContent.children['place-address'].textContent = result.formatted_address;
                /*if (result.photos) {
                    infowindowContent.children['place-photo'].src = result.photos[0].getUrl({maxHeight: 50, minHeight: 50});
                } else {
                    infowindowContent.children['place-photo'].src = "../opt-imgs/favicon.png";
                }*/

                infowindowContent.children['place-photo'].src = "../opt-imgs/favicon.png";

                infowindowContent.children['add-gym-form'].children['place-id-input'].value = result.place_id;
                infowindowContent.children['add-gym-form'].children['place-name-input'].value = result.name;
                infowindowContent.children['add-gym-form'].children['place-address-input'].value = result.formatted_address;
                infowindowContent.children['add-gym-form'].children['place-lat-input'].value = result.geometry.location.lat();
                infowindowContent.children['add-gym-form'].children['place-lng-input'].value = result.geometry.location.lng();
                /*if (result.opening_hours.weekday_text) {
                    infowindowContent.children['add-gym-form'].children['place-hours-array'].value = JSON.stringify(result.opening_hours.weekday_text);
                }
                console.log(result.opening_hours);*/
                infoWindow.open(map, marker);
            });
        });
    }
}

function searchForPlace(map) {
    var input = document.getElementById('pac-input');

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content-place');
    infowindow.setContent(infowindowContent);

    var marker = new google.maps.Marker({
        map: map
    });

    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        markerArray[0].setMap(null);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(14);
        }

        marker.setPlace({
            placeId: place.place_id,
            location: place.geometry.location
        });
        marker.setVisible(true);

        infowindowContent.children['search-place-name'].textContent = place.name;
        infowindowContent.children['search-place-address'].textContent = place.formatted_address;
        infowindow.open(map, marker);
    });
}
/*
function getGymData(result) {
    if (result)
    {
        var postData = {
            "name": result.name,
            "address": result.formatted_address,
            "lat": result.geometry.location.lat(),
            "lng": result.geometry.location.lng(),
            "hours": result.opening_hours.weekday_text
        }

        console.log(postData);

        $.ajax({
            type: "POST",
            url: "/health-hack/GymLocator/index.php",
            data: {myData: postData},
            success: function(data) {
                alert('items added');
            }
        });
    }
}*/
<style>
.custom .leaflet-popup-tip,
.custom .leaflet-popup-content-wrapper {
    height: 400px;
    width: 400px;
}

.custom-popup {
    width: 450px;
    /* adjust the width as you like */
    height: 400px;
    /* adjust the height as you like */
}

.buttons {
    display: flex;
    flex-direction: row;
}

.button {
    background-color: transparent;
    border: 1px solid transparent;
    border-radius: 4px;
    font-size: 12px;
    margin-right: 5px;
}
</style>
<div class="card" data-sr-id="87"
    style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
    <div class="p-3-4">
        <div class="d-flex mb-3">
            <div>
                <div id="map_atms_title"></div>
            </div>
        </div>
        <div class="p-2" id="map_atms" style="height: 550px; width: 100%; z-index: 1">
        </div>
    </div>
</div>

<script>

var google = L.tileLayer("https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}", {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
    attribution: '&copy; Trans HubDat | <a href="https://www.google.com/intl/id/permissions/geoguidelines/">Google Maps</a>'
});

var satellite = L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    });

var map_atms = L.map('map_atms', {
    center: [-7.614529, 110.712246],
    zoom: 7,
    fullscreenControl: true,
    layers: [google, satellite]
});

var baseMaps = {
    "Satellite": satellite,
    "Google": google
};

var atms = L.layerGroup();
var cctv = L.layerGroup();

$(document).ready(function() {
    $.ajax({
        url: '<?= base_url() ?>/main/getDataApi',
        type: 'GET',
        dataType: 'json',
        success: function(data) {

            var ttl_counttraffic = data.query.length;
            var countSangatLancar = 0;
            var countLancar = 0;
            var countSedangLancar = 0;
            var countSedangAgakMacet = 0;
            var countMacet = 0;
            var countMacetTotal = 0;

            for (let i = 0; i <= data.query.length - 1; i++) {

                var lat = data.query[i]['lat'];
                var long = data.query[i]['long'];
                var latlng = L.latLng(lat, long);
                var kota = data.query[i]['kabupaten_kota'];
                var provinsi = data.query[i]['provinsi'];
                var jenis_tc = data.query[i]['jenis_tc'];
                var nama = data.query[i]['nama'];
                var motor = data.query[i]['motor'];
                var mobil = data.query[i]['mobil'];
                var bus_kecil = data.query[i]['bus_kecil'];
                var truck_kecil = data.query[i]['truck_kecil'];
                var sedang = data.query[i]['sedang'];
                var bus_besar = data.query[i]['bus_besar'];
                var truck_besar = data.query[i]['truck_besar'];
                var besar = data.query[i]['besar'];
                var speed = data.query[i]['speed'];
                var kinerja = data.query[i]['kinerja'];
                var timestamp = data.query[i]['timestamp'];
                var color = data.query[i]['kinerja'] == 'A (Sangat Lancar)' ? '#43936C' :
                    data.query[i]['kinerja'] == 'B (Lancar)' ? '#A99F31' :
                    data.query[i]['kinerja'] == 'C (Sedang Lancar)' ? '#FFAA00' :
                    data.query[i]['kinerja'] == 'D (Sedang agak macet)' ? '#FF7800' :
                    data.query[i]['kinerja'] == 'E (Macet)' ? '#CB3A31' :
                    data.query[i]['kinerja'] == 'F (Macet Total)' ? '#731912' : 'black';

                var fontcolor = data.query[i]['kinerja'] == 'E (Macet)' || data.query[i][
                    'kinerja'
                ] == 'F (Macet Total)' ? 'white' : 'black';


                var sangatLancar = data.query[i]['kinerja'] == 'A (Sangat Lancar)' ?
                    countSangatLancar++ :
                    0;
                var lancar = data.query[i]['kinerja'] == 'B (Lancar)' ? countLancar++ : 0;
                var sedangLancar = data.query[i]['kinerja'] == 'C (Sedang Lancar)' ?
                    countSedangLancar++ :
                    0;
                var sedangAgakMacet = data.query[i]['kinerja'] == 'D (Sedang agak macet)' ?
                    countSedangAgakMacet++ : 0;
                var macet = data.query[i]['kinerja'] == 'E (Macet)' ? countMacet++ : 0;
                var macetTotal = data.query[i]['kinerja'] == 'F (Macet Total)' ?
                    countMacetTotal++ :
                    0;


                // create a custom marker
                var customMarker = L.icon.pulse({
                    color: color,
                    fillColor: color,
                    iconSize: [10, 10],
                });

                // create popup contents
                var customPopup = "<div class='card'>" +
                    "<div class='card-header' style='background-color:" + color + "; color: " +
                    fontcolor + "'>" +
                    "<h6 class='card-title' style='color: " + fontcolor + "'>" + nama + ", " +
                    kota + ", " + provinsi +
                    "</h6>" +
                    "<p style='margin-top: 10px;'>Tampilkan CCTV</p>" +
                    "</div>" +
                    "<div class='card-body'>" +
                    "<div class='row'>" +
                    "<div class='col-lg-6'>" +
                    "<p style='margin-top: -20px;'>Motor : " + motor + "</p>" +
                    "<p style='margin-top: -20px;'>Mobil : " + mobil + "</p>" +
                    "<p style='margin-top: -20px;'>Bus Besar : " + bus_besar + "</p>" +
                    "<p style='margin-top: -20px;'>Bus Kecil : " + bus_kecil + "</p>" +
                    "<p style='margin-top: -20px;'>Truck Besar : " + truck_besar + "</p>" +
                    "</div>" +
                    "<div class='col-lg-6'>" +
                    "<p style='margin-top: -20px;'>Truck Kecil : " + truck_kecil + "</p>" +
                    "<p style='margin-top: -20px;'>Besar : " + besar + "</p>" +
                    "<p style='margin-top: -20px;'>Sedang : " + sedang + "</p>" +
                    "<p style='margin-top: -20px;'>Speed : " + speed + "</p>" +
                    "<p style='margin-top: -20px;'>Kinerja : " + kinerja + "</p>" +
                    "</div>" +
                    "</div>" +
                    "</.div>" +
                    "</div>" +
                    "<div class='text-muted'>Sumber Data : API HubDat, Last Update : " +
                    timestamp +
                    "</div>";

                // specify popup options 
                var customOptions = {
                    'maxWidth': '500',
                    'className': 'custom'
                }

                // add markers with custom icons and popups
                var marker_atms = L.marker([lat, long], {
                    icon: customMarker
                }).bindPopup(customPopup, customOptions).addTo(atms);


                marker_atms.on('click', function(e) {
                    // map_atms.setView(e.latlng, 15).getCenter();
                    map_atms.flyTo(e.latlng, 15).getCenter();
                });
            }

            L.tileLayer("https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}", {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '&copy; Trans HubDat | <a href="https://www.google.com/intl/id/permissions/geoguidelines/">Google Maps</a>'
            }).addTo(map_atms);

            var buttons = L.DomUtil.create('div', 'buttons');

            var button1 = L.DomUtil.create('button', 'button', buttons);
            button1.innerHTML =
                '<span class="btn" id="all" style="background-color:#2D4CB9; color: #FFC453">Jumlah Titik: ' +
                ttl_counttraffic + '</span>';

            var button2 = L.DomUtil.create('button', 'button', buttons);
            button2.innerHTML =
                '<span class="btn" id="sangatLancar" style="background-color:#43936C; color: white">Sangat Lancar: ' +
                countSangatLancar + '</span>';

            var button3 = L.DomUtil.create('button', 'button', buttons);
            button3.innerHTML =
                '<span class="btn" id="lancar" style="background-color:#A99F31; color: white">Lancar: ' +
                countLancar + '</span>';

            var button4 = L.DomUtil.create('button', 'button', buttons);
            button4.innerHTML =
                '<span class="btn" id="sedangLancar" style="background-color:#FFAA00; color: white">Sedang Lancar: ' +
                countSedangLancar + '</span>';

            var button5 = L.DomUtil.create('button', 'button', buttons);
            button5.innerHTML =
                '<span class="btn" id="sedangAgakMacet" style="background-color:#FF7F00; color: white">Sedang Agak Macet: ' +
                countSedangAgakMacet + '</span>';

            var button6 = L.DomUtil.create('button', 'button', buttons);
            button6.innerHTML =
                '<span class="btn" id="macet" style="background-color:#FF0000; color: white">Macet: ' +
                countMacet + '</span>';

            var button7 = L.DomUtil.create('button', 'button', buttons);
            button7.innerHTML =
                '<span class="btn" id="macetTotal" style="background-color:#8B0000; color: white">Macet Total: ' +
                countMacetTotal + '</span>';

            var control = L.control({
                setPosition: 'bottomright'
            });
            control.onAdd = function(atms) {
                return buttons;
            };
            control.addTo(atms);
            control.setPosition('bottomright');

            $('#map_atms_title').html(
                '<h4 class="card-title">Intelegent Traffic Managemen Systems (ITMS)</h4>');
        }
    });

    $.ajax({
                url: '<?= base_url() ?>/main/getCctv',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var countCctv = data.length;
                    // console.log(countCctv);

                    for (let i = 0; i < countCctv; i++) {
                        let cctv_lat = data[i].cctv_lat;
                        let cctv_long = data[i].cctv_long;
                        let cctv_name = data[i].cctv_name;
                        let cctv_location = data[i].cctv_location;
                        let url_cctv = data[i].cctv_url;
                        let cctv_type = data[i].cctv_type;
                        var icon_cctv = (cctv_type == '0') ?
                            '<?= base_url() ?>/assets/icon/cctvyellow.png' :
                            '<?= base_url() ?>/assets/icon/cctvblue.png';

                        var customMarker = L.icon({
                            iconUrl: icon_cctv,
                            iconSize: [15, 15],
                            iconAnchor: [15, 15],
                            popupAnchor: [0, -15]
                        });



                        let isUrlM3U8 = url_cctv.slice(-5) === '.m3u8';

                        let customPopup = isUrlM3U8 ? `
                                    <video id='my_video_${i}' class='video-js' controls preload='auto' autoplay width='400' height='250' data-setup='{}'>
                                    <source src='${url_cctv}' type='application/x-mpegURL'></video>` :
                            `
                                    <div>
                                    <iframe width='400' height='250' src='${url_cctv}' frameborder='0' allowfullscreen></iframe>
                                    </div>`;

                        // var customPopup =
                        //     "<video id='my_video_" + i +
                        //     "' class='video-js' controls preload='auto' autoplay width='400' height='250' data-setup='{}'>" +
                        //     "<source src='" + url_cctv + "' type='application/x-mpegURL'></video>";

                        // specify popup options
                        let customOptions = {
                            'className': 'custom-popup'
                        }

                        // add markers with custom icons and popups
                        let marker_cctv = L.marker([cctv_lat, cctv_long], {
                            icon: customMarker
                        }).bindPopup(customPopup, customOptions).addTo(cctv);

                        marker_cctv.on('click', function(e) {
                            if (isUrlM3U8) {
                                var player = videojs('my_video_' + i);
                                player.play();
                            }
                            let popup = e.target.getPopup();
                            popup.setLatLng(e.latlng);
                            popup.openOn(layerGroup2);
                        });
                    }
                    

                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
            var overlayMaps = {
            "ATMs": atms,
            "CCTV": cctv,
        };

        var layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map_atms);
});
</script>
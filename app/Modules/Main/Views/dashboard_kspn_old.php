<style>
.custom .leaflet-popup-tip,
.custom .leaflet-popup-content-wrapper {
    height: auto;
    width: 300px;
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
                <div id="map_kspn_title"></div>
            </div>
        </div>
        <div class="p-2" id="map_kspn" style="height: 550px; width: 100%; z-index: 1">
        </div>
    </div>
</div>
<script>
var map_kspn = L.map('map_kspn', {
    fullscreenControl: true
}).setView([-0.789275, 113.921327], 5);


// add a tile layer
// L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
//     maxZoom: 20
// }).addTo(map_kspn);

L.tileLayer("https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}", {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
    attribution: '&copy; Trans HubDat | <a href="https://www.google.com/intl/id/permissions/geoguidelines/">Google Maps</a>'
}).addTo(map_kspn);
$(document).ready(function() {
    $.ajax({
        url: '<?=base_url()?>/main/APIGetLiveTrack',
        type: 'GET',
        dataType: 'json',
        success: function(data) {

          var countJumlahArmada = data.data.length;
          var countJumlahHidup = 0;
          var countJumlahMati = 0;

            for (let i = 0; i <= data.data.length - 1; i++) {
                var lat = data.data[i]['latitude'];
                var long = data.data[i]['longitude'];
                var latlng = L.latLng(lat, long);
                var gps_id = data.data[i]['gps_id'];
                var timestamp = data.data[i]['timestamp'];
                var kode_bus = data.data[i]['kode_bus'];
                var kecepatan = data.data[i]['kecepatan'];
                var status_mesin = data.data[i]['status_mesin'];
                var total_penumpang = data.data[i]['total_penumpang'];
                var color = data.data[i]['status_mesin'] == 'Hidup' ? '#43936C' : '#731912';

                var customMarker = L.icon.pulse({
                    color: color,
                    fillColor: color,
                    iconSize: [10, 10],
                });

                var fontcolor = data.data[i]['status_mesin'] == 'Mati' ? 'white' : 'black';

                // create popup contents
                var customPopup = "<div class='card'>" +
                    "<div class='card-header' style='background-color: " + color + "; color: " +
                    fontcolor + "'>" +
                    "<h6 class='card-title' style='color: " + fontcolor + "'>" + kode_bus +
                    "</h6>" +
                    "</div>" +
                    "<div class='card-body'>" +
                    "<p style='margin-top: -15px;'>GPS ID : " + gps_id + "</p>" +
                    "<p style='margin-top: -15px;'>Kecepatan : " + kecepatan + " Km/Jam</p>" +
                    "<p style='margin-top: -15px;'>Status Mesin : " + status_mesin + "</p>" +
                    "<p style='margin-top: -15px;'>Jumlah Penumpang : " + total_penumpang +
                    "</p>" +
                    "<p style='margin-top: -15px;'>Jam : " + timestamp + "</p>" +
                    "</div>" +
                    "</div>" +
                    "<div class='text-muted'>Sumber Data : API HubDat</div>";

                // specify popup options 
                var customOptions = {
                    'maxWidth': '500',
                    'className': 'custom'
                }

                var jumlahHidup = data.data[i]['status_mesin'] == 'Hidup' ?
                    countJumlahHidup++ :
                    0;
                var jumlahMati = data.data[i]['status_mesin'] == 'Mati' ?
                    countJumlahMati++ :
                    0;

                // add markers with custom icons and popups
                var marker1 = L.marker([lat, long], {
                    icon: customMarker
                }).bindPopup(customPopup, customOptions).addTo(map_kspn);

                marker1.on('click', function(e) {
                    map_kspn.flyTo(e.latlng, 10).getCenter();
                });
            }
            var buttons = L.DomUtil.create('div', 'buttons');

            var button1 = L.DomUtil.create('button', 'button', buttons);
            button1.innerHTML = '<span class="btn" id="all" style="background-color:grey; color: white">Jumlah Armada: ' +
                countJumlahArmada + '</span>';

            var button2 = L.DomUtil.create('button', 'button', buttons);
            button2.innerHTML = '<span class="btn" id="sangatLancar" style="background-color:#43936C; color: white">Jumlah Armada Beroperasi: ' +
                countJumlahHidup + '</span>';

            var button3 = L.DomUtil.create('button', 'button', buttons);
            button3.innerHTML = '<span class="btn" id="lancar" style="background-color:#731912; color: white">Jumlah Armada Tidak Beroperasi: ' +
                countJumlahMati + '</span>';

            var control = L.control({
                position: 'bottomleft',
            });
            control.onAdd = function(map) {
                return buttons;
            };
            control.addTo(map_kspn);
        }
    });
});
</script>

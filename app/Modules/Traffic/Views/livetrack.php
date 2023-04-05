<style>
.custom .leaflet-popup-tip,
.custom .leaflet-popup-content-wrapper {
    height: auto;
    max-width: 300px;
}
</style>
<div>
    <div class="page-content page-container" id="page-content">
        <div class="card">
            <div class="card-body">
                <div id="map" style="height: 600px"></div>
            </div>
        </div>
    </div>
</div>

<script>
const url = '<?=base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1)?>';
$(document).ready(function() {
    $.ajax({
        url: url + '_APIGetLiveTrack',
        type: 'GET',
        dataType: 'json',
        success: function(data) {

            var map = L.map('map', {
                fullscreenControl: true
            }).setView([-2.3933754, 108.8612248], 5);

            // add a tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                maxZoom: 20
            }).addTo(map);

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
                    "<p style='margin-top: -15px;'>Jumlah Penumpang : " + total_penumpang + "</p>" +
                    "<p style='margin-top: -15px;'>Jam : " + timestamp + "</p>" +
                    "</div>" +
                    "</div>" +
                    "<div class='text-muted'>Sumber Data : API HubDat</div>";

                // specify popup options 
                var customOptions = {
                    'maxWidth': '500',
                    'className': 'custom'
                }

                // add markers with custom icons and popups
                var marker1 = L.marker([lat, long], {
                    icon: customMarker
                }).bindPopup(customPopup, customOptions).addTo(map);

                marker1.on('click', function(e) {
                    map.setView(e.latlng, 10).getCenter();
                });
            }
        }
    });
})
</script>
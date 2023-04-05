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
const url = '<?=base_url()."/".uri_segment(0)."/action/".uri_segment(1)?>';
const url_ajax = '<?=base_url()."/".uri_segment(0)."/ajax"?>';
const url_icon = '<?=base_url()?>';

$(document).ready(function() {
  $.ajax({
        url: url + '_APIGetTrafficCount',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          
            var map = L.map('map', {
                fullscreenControl: true
            }).setView([-7.614529, 110.712246], 7);

            // add a tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                maxZoom: 18
            }).addTo(map);

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

                // create a custom marker
                var customMarker = L.icon.pulse({
                    color: color,
                    fillColor: color,
                    iconSize: [10, 10],
                });

                // create popup contents
                var customPopup = "<div class='card'>" +
                    "<div class='card-header' style='background-color: " + color + "; color: " +
                    fontcolor + "'>" +
                    "<h6 class='card-title' style='color: " + fontcolor + "'>" + nama + " " + kota +
                    "</h6>" +
                    "<br> <p style='margin-top: -15px; color: " + fontcolor + "'>" + kota + ", " +
                    provinsi + "</p>" +
                    "</div>" +
                    "<div class='card-body'>" +
                    "<p style='margin-top: -15px;'>Motor : " + motor + "</p>" +
                    "<p style='margin-top: -15px;'>Mobil : " + mobil + "</p>" +
                    "<p style='margin-top: -15px;'>Bus Besar : " + bus_besar + "</p>" +
                    "<p style='margin-top: -15px;'>Bus Kecil : " + bus_kecil + "</p>" +
                    "<p style='margin-top: -15px;'>Truck Besar : " + truck_besar + "</p>" +
                    "<p style='margin-top: -15px;'>Truck Kecil : " + truck_kecil + "</p>" +
                    "<p style='margin-top: -15px;'>Besar : " + besar + "</p>" +
                    "<p style='margin-top: -15px;'>Sedang : " + sedang + "</p>" +
                    "<p style='margin-top: -15px;'>Speed : " + speed + "</p>" +
                    "<p style='margin-top: -15px;'>Kinerja : " + kinerja + "</p>" +
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
});

</script>

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
                <div id="map_tl_title"></div>
            </div>
        </div>
        <div class="p-2" id="map_tl" style="height: 550px; width: 100%; z-index: 1">
        </div>
    </div>
</div>

<script>
var map_tl = L.map('map_tl', {
    fullscreenControl: true
}).setView([-7.614529, 110.712246], 7);

L.tileLayer("https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}", {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
    attribution: '&copy; Trans HubDat | <a href="https://www.google.com/intl/id/permissions/geoguidelines/">Google Maps</a>'
}).addTo(map_tl);

$(document).ready(function() {
    $.ajax({
        url: '<?=base_url()?>/main/APIGetTrafficLight',
        type: 'GET',
        dataType: 'json',
        success: function(data) {

            var ttl_trafficlight = data.query.length;

            for (let i = 0; i <= data.query.length - 1; i++) {

                var latlng = data.query[i]['latlong'];
                var lat = latlng.split(",")[0];
                var lng = latlng.split(",")[1];
                var note = data.query[i]['note'];

                var marker = L.marker([lat, lng], {
                    icon: L.icon({
                        iconUrl: '<?=base_url()?>/assets/icon/tl.png',
                        iconSize: [20, 20],
                        iconAnchor: [20, 20],
                        popupAnchor: [0, -20]
                    })
                }).addTo(map_tl);

                marker.bindPopup(
                    '<div class="custom">' +
                    '<h6><span class="badge text-uppercase" style="background-color:#2D4CB9; color: #FFC453"><b>TL ' +
                    note + '</b></span></h6>' +
                    '</div>'
                );
            }


            $('#map_tl_title').html(
                '<h4 class="card-title">Traffic Ligth and Simpang</h4>');
        }
    });

    $.ajax({
        url: '<?=base_url()?>/main/APIGetSimpang',
        type: 'GET',
        dataType: 'json',
        success: function(data) {

            var ttl_simpang = data.query.length;

            for (let i = 0; i <= data.query.length - 1; i++) {
                var latlng = data.query[i]['titik_koordinat'];
                var lat = latlng.split(",")[0];
                var lng = latlng.split(",")[1];
                if (isNaN(lat) || isNaN(lng) || lat == null || lng == null) {
                    continue;
                } else {
                    var nama_ruas_jalan = data.query[i]['nama_ruas_jalan'];
                    var titik_pengenal_awal_ruas = data.query[i]['titik_pengenal_awal_ruas'];
                    var titik_pengenal_akhir_ruas = data.query[i]['titik_pengenal_akhir_ruas'];
                    var nama_simpang = data.query[i]['nama_simpang'];
                    var lokasi = data.query[i]['lokasi'];
                    var kabupaten_kota = data.query[i]['kabupaten_kota'];
                    var provinsi = data.query[i]['provinsi'];
                    var titik_pengenal = data.query[i]['titik_pengenal'];


                    // var customMarker = L.marker([lat, lng], {
                    //     icon: L.icon({
                    //         iconUrl: '<?=base_url()?>/assets/icon/simpang2.png',
                    //         iconSize: [30, 30],
                    //         iconAnchor: [15, 30],
                    //         popupAnchor: [0, -30]
                    //     })
                    // }).addTo(map_tl);

                    var customMarker = L.icon({
                        iconUrl: '<?=base_url()?>/assets/icon/simpang2.png',
                        iconSize: [15, 15],
                        iconAnchor: [15, 15],
                        popupAnchor: [0, -15]
                    });

                    var customPopup =
                        '<div class="card" style="width: 400px">' +
                        '<div class="card-header" style="background-color:#2D4CB9; color: #FFC453">' +
                        '<p class="card-text"><b>' + nama_simpang + '</b></p>' +
                        '<p class="card-text">' + lokasi + ', ' + kabupaten_kota + '</p>' +
                        '</div>' +
                        '<div class="card-body">' +
                        '<p class="card-text" style="margin-top: -15px"><b>Titik Pengenal : </b> ' +
                        titik_pengenal + '</p>' +
                        '<p class="card-text" style="margin-top: -15px"><b>Nama Ruas Jalan : </b> ' +
                        nama_ruas_jalan + '</p>' +
                        '<p class="card-text" style="margin-top: -15px"><b>Titik Pengenal Awal Ruas : </b> ' +
                        titik_pengenal_awal_ruas + '</p>' +
                        '<p class="card-text" style="margin-top: -15px"><b>Titik Pengenal Akhir Ruas : </b> ' +
                        titik_pengenal_akhir_ruas + '</p>' +
                        '</div>' +
                        '<div class="card-footer" style="background-color:#2D4CB9; color: #FFC453; margin-top:-15px">' +
                        '<p class="card-text">Sumber Data <b>API Hubdat</b></p>' +
                        '</div>' +
                        '</div>';

                    let customOptions = {
                        'className': 'custom-popup'
                    }

                    // add markers with custom icons and popups
                    let marker_simpang = L.marker([lat, lng], {
                        icon: customMarker
                    }).bindPopup(customPopup, customOptions).addTo(map_tl);

                    marker_simpang.on('click', function(e) {
                    map_tl.flyTo(e.latlng, 18).getCenter();
                });
                }
            }

        }

    });



});
</script>
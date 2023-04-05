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
                <div id="map_jto_title"></div>
            </div>
        </div>
        <div class="p-2" id="map_jto" style="height: 550px; width: 100%; z-index: 1">
        </div>
    </div>
</div>
<script>
var map_jto = L.map('map_jto', {
    fullscreenControl: true
}).setView([-0.789275, 113.921327], 5);

L.tileLayer("https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}", {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
    attribution: '&copy; Trans HubDat | <a href="https://www.google.com/intl/id/permissions/geoguidelines/">Google Maps</a>'
}).addTo(map_jto);

$(document).ready(function() {
    $.ajax({
        url: '<?=base_url()?>/main/GetJto',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var countJto = data.length;
            for (let i = 0; i < data.length; i++) {
                var lat = data[i].koordinat_x;
                var lng = data[i].koordinat_y;
                if (isNaN(lat) || isNaN(lng) || lat == null || lng == null) {
                    continue;
                } else {
                    var latlng = L.latLng(lat, lng);
                    var provinsi = data[i].nama_provinsi;
                    var kota = data[i].nama_kota;
                    var jembatan = data[i].nama_jembatan;
                    var alamat = data[i].alamat;
                    var status = data[i].status;
                    var kode = data[i].kode_jt;

                    var marker = L.marker([lat, lng], {
                        icon: L.icon({
                            iconUrl: '<?=base_url()?>/assets/icon/jto.png',
                            iconSize: [30, 30],
                            iconAnchor: [15, 30],
                            popupAnchor: [0, -30]
                        })
                    }).addTo(map_jto);

                    marker.bindPopup(
                        '<div class="custom">' +
                        '<h5><span class="badge text-uppercase" style="background-color:#2D4CB9; color: #FFC453"><b>' + jembatan + ' (' + kode + ')</b></span></h5>'+
                        '<h6><span class="badge text-uppercase" style="background-color:#2D4CB9; color: #FFC453"><b>' + provinsi + ', ' + kota +'</b></span></h6>'+
                        '<p>' + alamat + '</p>' +
                        '</div>'
                    );
                }
            }
        },
    });

});
</script>

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
                <div id="map_terminal_title"></div>
            </div>
        </div>
        <div class="p-2" id="map_terminal" style="height: 550px; width: 100%; z-index: 1">
        </div>
    </div>
</div>
<script>
var map_terminal = L.map('map_terminal', {
    fullscreenControl: true
}).setView([-0.789275, 113.921327], 5);

L.tileLayer("https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}", {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
    attribution: '&copy; Trans HubDat | <a href="https://www.google.com/intl/id/permissions/geoguidelines/">Google Maps</a>'
}).addTo(map_terminal);

$(document).ready(function() {
    $.ajax({
        url: '<?=base_url()?>/main/GetTerminal',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var countJumlahTerminal = 0;
            var countBanten = 0;
            var countDKI = 0;
            var countJawaBarat = 0;
            var countJawaTengah = 0;
            var countJawaTimur = 0;
            var countJogja = 0;

            for (var i = 0; i < data.length; i++) {
                var lat = data[i].terminal_lat;
                var long = data[i].terminal_lng;
                if (isNaN(lat) || isNaN(long)) {
                    continue;
                } else {

                    let customMarker = L.icon({
                        iconUrl: '<?=base_url()?>/assets/icon/bus.png',
                        iconSize: [15, 15],
                        iconAnchor: [15, 15],
                        popupAnchor: [0, 15]
                    });

                    let customPopup =
                    '<div class="custom">' +
                      '<h3><span class="badge text-uppercase" style="background-color:#2D4CB9; color: #FFC453"><b>' + data[i].terminal_name + '</b></span></h3>'+
                      '<br>' +
                      '<h5><span>Alamat: '+ data[i].terminal_address + '</span></h5>' +
                        '</div>';

                    // specify popup options
                    let customOptions = {
                        
                    }

                    // add markers with custom icons and popups
                    let marker_terminal = L.marker([lat, long], {
                        icon: customMarker
                    }).bindPopup(customPopup, customOptions).addTo(map_terminal);

                    marker_terminal.on('click', function(e) {
                        map_terminal.setView(e.latlng, 12).getCenter();
                    });

                    var banten = data[i].api_kode_prov_bps == '36' ? countBanten++ : 0;
                    var dki = data[i].api_kode_prov_bps == '31' ? countDKI++ : 0;
                    var jabar = data[i].api_kode_prov_bps == '32' ? countJawaBarat++ : 0;
                    var jateng = data[i].api_kode_prov_bps == '33' ? countJawaTengah++ : 0;
                    var jatim = data[i].api_kode_prov_bps == '35' ? countJawaTimur++ : 0;
                    var jogja = data[i].api_kode_prov_bps == '34' ? countJogja++ : 0;


                    countJumlahTerminal++;
                }
            }
            var buttons = L.DomUtil.create('div', 'buttons');

            //All
            var button_all = L.DomUtil.create('button', 'button', buttons);
            button_all.innerHTML =
                '<span class="btn" id="all" style="background-color:#FFC453; color: #2D4CB9">Jumlah Terminal: ' +
                countJumlahTerminal + '</span>';
            button_all.onclick = function() {
                map.flyTo([-0.789275, 113.921327], 5).getCenter();
            };

            //Banten
            var button_Banten = L.DomUtil.create('button', 'button', buttons);
            button_Banten.innerHTML =
                '<span class="btn" id="banten" style="background-color:#2D4CB9; color: #FFC453">Banten: ' +
                countBanten + '</span>';
            button_Banten.onclick = function() {
                map.flyTo([-6.4457721, 105.379533], 9).getCenter();
            };

            //Jakarta
            var button_jakarta = L.DomUtil.create('button', 'button', buttons);
            button_jakarta.innerHTML =
                '<span class="btn" id="jakarta" style="background-color:#2D4CB9; color: #FFC453">DKI Jakarta: ' +
                countDKI + '</span>';
            button_jakarta.onclick = function() {
                map.flyTo([-6.175110, 106.865036], 10).getCenter();
            };

            //Jabar
            var button_jabar = L.DomUtil.create('button', 'button', buttons);
            button_jabar.innerHTML =
                '<span class="btn" id="jabar" style="background-color:#2D4CB9; color: #FFC453">Jawa Barat: ' +
                countJawaBarat + '</span>';
            button_jabar.onclick = function() {
                map.flyTo([-7.090911, 107.668884], 8).getCenter();
            };

            //Jateng
            var button_jateng = L.DomUtil.create('button', 'button', buttons);
            button_jateng.innerHTML =
                '<span class="btn" id="jateng" style="background-color:#2D4CB9; color: #FFC453">Jawa Tengah: ' +
                countJawaTengah + '</span>';
            button_jateng.onclick = function() {
                map.flyTo([-7.150975, 110.140259], 8).getCenter();
            };

            //DIY Yogyakarta
            var button_jogja = L.DomUtil.create('button', 'button', buttons);
            button_jogja.innerHTML =
                '<span class="btn" id="jogja" style="background-color:#2D4CB9; color: #FFC453">DIY Yogyakarta: ' +
                countJogja + '</span>';
            button_jogja.onclick = function() {
                map.flyTo([-7.8753849, 110.4262088], 10).getCenter();
            };

            //Jatim
            var button_jatim = L.DomUtil.create('button', 'button', buttons);
            button_jatim.innerHTML =
                '<span class="btn" id="all" style="background-color:#2D4CB9; color: #FFC453">Jawa Timur: ' +
                countJawaTimur + '</span>';
            button_jatim.onclick = function() {
                map.flyTo([-7.536064, 112.238403], 8).getCenter();
            };


            var control = L.control({
                position: 'bottomleft',
            });
            control.onAdd = function(map) {
                return buttons;
            };
            control.addTo(map_terminal);
        },
    });

});
</script>

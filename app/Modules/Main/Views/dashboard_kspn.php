<style>

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
        url: '<?=base_url()?>/main/APIGetEasyGo',
        type: 'GET',
        dataType: 'json',
        success: function(data) {

          var countJumlahArmada = data.Data.length;
          var countJumlahHidup = 0;
          var countJumlahMati = 0;

            for (let i = 0; i <= data.Data.length - 1; i++) {
                var lat = data.Data[i]['lat'];
                var long = data.Data[i]['lon'];
                var latlng = L.latLng(lat, long);
                var address = data.Data[i]['addr'];
                var car_model = data.Data[i]['car_model'];
                var car_type = data.Data[i]['car_type'];
                var company_nm = data.Data[i]['company_nm'];
                var gps_sn = data.Data[i]['gps_sn'];
                var gsm_no = data.Data[i]['gsm_no'];
                var kec = data.Data[i]['kec'];
                var kode_pos = data.Data[i]['kode_pos'];
                var kota = data.Data[i]['kota'];
                var no_aset = data.Data[i]['no_aset'];
                var no_pol = data.Data[i]['no_pol'];
                var kode_pos = data.Data[i]['kode_pos'];
                var provinsi = data.Data[i]['provinsi'];
                var stime = data.Data[i]['stime'];
                var group_nm = data.Data[i]['group_nm'];
                var main_power_voltage = data.Data[i]['main_power_voltage'];
                var keterangan = data.Data[i]['currentStatusVehicle']['ket'];
                // console.log(keterangan);
                var color = data.Data[i]['currentStatusVehicle']['ket'] == 'Parking' ? '#731912' : '#43936C';

                var customMarker = '';
                if(data.Data[i]['currentStatusVehicle']['ket'] == 'Parking'){
                  var customMarker = L.icon({
                        iconUrl: '<?=base_url()?>/assets/icon/redbus.png',
                        iconSize: [15, 15],
                        iconAnchor: [15, 15],
                        popupAnchor: [0, 15]
                    });
                  } else {
                    var customMarker = L.icon({
                        iconUrl: '<?=base_url()?>/assets/icon/greenbus.png',
                        iconSize: [15, 15],
                        iconAnchor: [15, 15],
                        popupAnchor: [0, 15]
                    });
                  }

                var fontcolor = 'white';

                // create popup contents
                var customPopup = "<div class='card'>" +
                    "<div class='card-header' style='background-color: " + color + "; color: " +
                    fontcolor + "'>" +
                    "<h6 class='card-title' style='color: " + fontcolor + "'>" + company_nm + "<br>" + kota + ", " + provinsi + "</h6>" +
                    "</div>" +
                    "<div class='card-body'>" +
                    "<p style='margin-top: -15px;'>GPS SN : " + gps_sn + "</p>" +
                    "<p style='margin-top: -15px;'>GSM No : " + gsm_no + "</p>" +
                    "<p style='margin-top: -15px;'>Car Model / Type : " + car_model + " " + car_type + "</p>" +
                    "<p style='margin-top: -15px;'>No Aset : " + no_aset + "</p>" +
                    "<p style='margin-top: -15px;'>No Kendaraan : " + no_pol + "</p>" +
                    "<p style='margin-top: -15px;'>Group : " + group_nm + "</p>" +
                    "<p style='margin-top: -15px;'>Position : " + address + "</p>" +
                    "<p style='margin-top: -15px;'>Status : " + keterangan + "</p>" +
                    "<p style='margin-top: -15px;'>Power Voltage : " + main_power_voltage + "</p>" +
                    "<p style='margin-top: -15px;'>Last Update : " + stime + "</p>" +
                    "</div>" +
                    "</div>" +
                    "<div class='text-muted'>Sumber Data : API HubDat</div>";


                var jumlahHidup = data.Data[i]['currentStatusVehicle']['ket'] != 'Parking' ?
                    countJumlahHidup++ :
                    0;
                var jumlahMati = data.Data[i]['currentStatusVehicle']['ket'] == 'Parking' ?
                    countJumlahMati++ :
                    0;

                // add markers with custom icons and popups
                var marker1 = L.marker([lat, long], {
                    icon: customMarker
                }).bindPopup(customPopup).addTo(map_kspn);

                marker1.on('click', function(e) {
                    map_kspn.flyTo(e.latlng, 18).getCenter();
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

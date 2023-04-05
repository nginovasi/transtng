<?php
$session = \Config\Services::session();
#print_r($session->get());
$instansiId = $session->get('instansi_detail_id');  

?>

<style>
#loadingChart1, #loadingChart2, #loadingChart3, #loadingrampcheckPerBptd, #loadingLastFiveRampcheck, #loadingtopFiveUserRampcheck, #loadingtopTenRampcheckLocationPerBptd {
    display: none;
}
.card {
    background-color: transparent;
    word-wrap: normal; 
    padding: 0;
    border: 0;
    border-radius: 0;
    box-shadow: none;
    margin-left: 15px;
    margin-right: 15px;
    
}
@media only screen and (max-width: 600px) {
    .apexcharts-canvas {
        width: 100% !important;
        height: 100% !important;
        margin-left: auto;
        margin-right: auto;
        display: block;
    }
    .page-title {
        margin-right: 15px;
        margin-left: 15px;
    }
}

table.dataTable th {
    vertical-align: middle;
}
</style>

<div class="">
<div class="page-hero page-container " id="page-hero">
        <div class="padding d-flex">
            <div class="page-title">
                <h2 class="text-md text-highlight">Dashboard <?=$session->get('role_name')?></h2>
                <!-- <h5 class="text-muted">Welcome aboard, <strong style="color:#008FFB;"><?=$session->get('name')?>, </strong></h5> -->
                <small class="text-muted">
                    Welcome aboard, <strong style="color:#008FFB;"><?=$session->get('name')?> </strong>
                    <strong style="color:#008FFB;"> (<?=$session->get('instansi_detail_name')?>)</strong>
                </small>
            </div>
            <div class="flex"></div>
        </div>
    </div>
    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <!-- carousel -->
            <div id="lastUpdate" class="lastUpdate"></div>
            <br>
            <!-- end carousel -->
            <div class="row row-sm sr">
                <div class="col-md-6 d-flex">
                    <div class="card flex" data-sr-id="11"
                        style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                        <div class="card-header" style="background-color:#008FFB;">
                            <h5 class="card-title text-center" style="color:white">Statistik Rampcheck Tahun
                                <?=date('Y');?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-sm-12">
                                    <div class="row row-sm">
                                        <div class="col-3">
                                            <div class="text-highlight text-md text-center ramp-thisyear">0</div>
                                            <div class="text-center"><small>Tahun Ini</small></div>
                                        </div>
                                        <div class="col-2">
                                            <div class="text-warning text-md text-center ramp-thismonth">0</div>
                                            <div class="text-center"><small>Bulan Ini</small></div>
                                        </div>
                                        <div class="col-2">
                                            <div class="text-primary text-md text-center ramp-today">+0</div>
                                            <div class="text-center"><small>Hari Ini</small></div>
                                        </div>
                                        <div class="col-2">
                                            <div class="text-success text-md text-center laik-monthly">0%</div>
                                            <div class="text-center"><small>Laik</small></div>
                                        </div>
                                        <div class="col-2">
                                            <div class="text-danger text-md text-center tdk-laik-monthly">0%</div>
                                            <div class="text-center"><small>Tidak Laik</small></div>
                                        </div>
                                    </div>
                                    <br>
                                    
                                    <div class="col-sm-12">
                                        <div id="loadingChart1">
                                            <img src="<?=base_url()?>/assets/img/loading.gif" style="display: block; margin-left: auto; margin-right: auto; width: 50%;">
                                        </div>
                                            <div id="chart1"></div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="card flex" data-sr-id="11"
                        style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                        <div class="card-header" style="background-color:#008FFB;">
                            <h5 class="card-title text-center" style="color:white">Statistik Rampcheck Per Jenis
                                Angkutan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-sm-12">
                                    <div class="row row-sm">
                                        <div class="col-3">
                                            <div class="text-primary text-md text-center ramp-akap">0</div>
                                            <div class="text-center"><small>AKAP</small></div>
                                        </div>
                                        <div class="col-3">
                                            <div class="text-success text-md text-center ramp-akdp">0</div>
                                            <div class="text-center"><small>AKDP</small></div>
                                        </div>
                                        <div class="col-3">
                                            <div class="text-warning text-md text-center ramp-pariwisata">0</div>
                                            <div class="text-center"><small>Pariwisata</small></div>
                                        </div>
                                        <div class="col-3">
                                            <div class="text-danger text-md text-center ramp-lainnya">0</div>
                                            <div class="text-center"><small>Lainnya</small></div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row row-sm">
                                        <div class="col-sm-12">
                                        <div id="loadingChart3">
                                                <img src="<?=base_url()?>/assets/img/loading.gif" style="display: block; margin-left: auto; margin-right: auto; width: 50%;">
                                            </div>
                                            <div id="chart3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-sm sr">
                <div class="col-md-12 d-flex">
                    <div class="card flex" data-sr-id="11"
                        style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                        <div class="card-header" style="background-color:#008FFB;">
                            <h5 class="card-title text-center" style="color:white">Rampcheck Weekly History</h5>
                        </div>
                        <div class="card-body">
                            <div id="loadingChart2">
                                <img src="<?=base_url()?>/assets/img/loading.gif" style="display: block; margin-left: auto; margin-right: auto; width: 50%;">
                            </div>
                            <div id="chart2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-sm sr">
                <div class="col-md-6 d-flex">
                    <div class="card flex" data-sr-id="11"
                        style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                        <div class="card-header" style="background-color:#008FFB;">
                            <h5 class="card-title text-center" style="color:white">Lokasi Rampcheck</h5>
                        </div>
                        <div class="card-body">
                            <div id="loadingtopTenRampcheckLocationPerBptd">
                                <img src="<?=base_url()?>/assets/img/loading.gif" style="display: block; margin-left: auto; margin-right: auto; width: 50%;">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-sm"
                                    id="topTenRampcheckLocationPerBptd">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Lokasi</th>
                                            <th>Nama Lokasi</th>
                                            <th class="text-center">Jumlah</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" data-sr-id="11"
                        style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                        <div class="card-header" style="background-color:#008FFB;">
                            <h5 class="card-title text-center" style="color:white">User Rampcheck</h5>
                        </div>
                        <div class="card-body">
                            <div id="loadingtopFiveUserRampcheck">
                                            <img src="<?=base_url()?>/assets/img/loading.gif" style="display: block; margin-left: auto; margin-right: auto; width: 50%;">
                                        </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-sm" id="topFiveUserRampcheck">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama User</th>
                                            <th class="text-center">Jumlah</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-sm sr">
                <div class="col-md-12 d-flex">
                    <div class="card" data-sr-id="11"
                        style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
                        <div class="card-header" style="background-color:#008FFB;">
                            <h5 class="card-title text-center" style="color:white">Last 5 Rampcheck</h5>
                        </div>
                        <div class="card-body">
                            <div id="loadingLastFiveRampcheck">
                            <img src="<?=base_url()?>/assets/img/loading.gif" style="display: block; margin-left: auto; margin-right: auto; width: 50%;">
                        </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-sm" id="lastFiveRampcheck">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>

                                            <th>Nomor Rampcheck<br />Nama Lokasi</th>
                                            <th>Tanggal Rampcheck</th>
                                            <th>Nomor Kendaraan</th>
                                            <th>Jenis Angkutan</th>
                                            <th>Trayek</th>
                                            <th>Status</th>
                                            <th>Log Input</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
var rampThisYear = document.getElementsByClassName('ramp-thisyear');
var rampThisMonth = document.getElementsByClassName('ramp-thismonth');
var rampToday = document.getElementsByClassName('ramp-today');
var laikMonthly = document.getElementsByClassName('laik-monthly');
var tdkLaikMonthly = document.getElementsByClassName('tdk-laik-monthly');
var rampAkap = document.getElementsByClassName('ramp-akap');
var rampAkdp = document.getElementsByClassName('ramp-akdp');
var rampPariwisata = document.getElementsByClassName('ramp-pariwisata');
var rampLainnya = document.getElementsByClassName('ramp-lainnya');


$(document).ready(function() {
    $.ajax({
        url: '<?=base_url()?>/main/getCountRampcheckToday',
        type: "GET",
        dataType: "json",
        success: function(data) {
            for (let i = 0; i < data.length; i++) {
                var ttlToday = parseInt(data[0].ttl_rampcheck).toLocaleString();
                rampToday[i].innerHTML = '+' + ttlToday;
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
    $.ajax({
        url: '<?=base_url()?>/main/getCountRampcheckPerStatus',
        type: "GET",
        dataType: "json",
        beforeSend: function() {
            $('#loadingChart1').show();
        },
        success: function(data) {
            for (let i = 0; i < data.length; i++) {
                var ttlLaik = parseInt(data[0].laik).toLocaleString();
                var ttlTdkLaik = parseInt(data[0].tidak_laik).toLocaleString();
                laikMonthly[i].innerHTML = ttlLaik;
                tdkLaikMonthly[i].innerHTML = ttlTdkLaik;
            }
            // create pie chart with apexchart
            var total_data = parseInt(data[0].laik) + parseInt(data[0].tidak_laik);
            rampThisYear[0].innerHTML = (parseInt(data[0].laik) + parseInt(data[0].tidak_laik)).toLocaleString();
            rampThisMonth[0].innerHTML = parseInt(data[0].this_month).toLocaleString();
            var percentLaik = (data[0].laik / total_data) * 100;
            var percentTdkLaik = (data[0].tidak_laik / total_data) * 100;
            var options = {
                chart: {
                    type: 'donut',
                    toolbar: {
                        show: false
                    },
                    width: "100%",
                    height: 350
                },
                dataLabels: {
                    enabled: true
                },
                series: [percentLaik, percentTdkLaik],
                labels: ['Laik', 'Tidak Laik'],
                colors: ['#00E396', '#FF4560'],
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        chart: {
                            width: "100%",
                            height: 350
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            }
            var chart1 = new ApexCharts(document.querySelector("#chart1"), options);
            chart1.render();
        },
        error: function(data) {
            console.log(data);
        }, complete: function() {
            $('#loadingChart1').hide();
        }
    });
    $.ajax({
        url: '<?=base_url()?>/main/getCountRampcheckPerJenisAngkutan',
        type: "GET",
        dataType: "json",
        beforeSend: function() {
            $('#loadingChart3').show();
        },
        success: function(data) {
            let ttlAkapX=0;
            let ttlAkdpX=0;
            let ttlPariwisataX=0;
            let ttlLainnyaX=0;
            let ttlAkapY=0;
            let ttlAkdpY=0;
            let ttlPariwisataY=0;
            let ttlLainnyaY=0;
            data.forEach(element => {

                if (element.jenis_angkutan_name == 'AKAP') {
                    ttlAkapX = element.ttl;
                    ttlAkapY = parseInt(element.ttl).toLocaleString();
                    rampAkap[0].innerHTML = ttlAkapY;
                } else if (element.jenis_angkutan_name == 'AKDP') {
                    ttlAkdpX = element.ttl;
                    ttlAkdpY = parseInt(element.ttl).toLocaleString();
                    rampAkdp[0].innerHTML = ttlAkdpY;
                } else if (element.jenis_angkutan_name == 'Pariwisata') {
                    ttlPariwisataX = element.ttl;
                    ttlPariwisataY = parseInt(element.ttl).toLocaleString();
                    rampPariwisata[0].innerHTML = ttlPariwisataY;
                } else {
                    ttlLainnyaX = element.ttl;
                    ttlLainnyaY = parseInt(element.ttl).toLocaleString();
                    rampLainnya[0].innerHTML = ttlLainnyaY;
                } 
            });
            // create pie chart with apexchart as chart3
            let total_data = parseInt(ttlAkapX) + parseInt(ttlAkdpX) + parseInt(ttlPariwisataX) + parseInt(ttlLainnyaX);
            let percentAkap = (ttlAkapX / total_data) * 100;
            let percentAkdp = (ttlAkdpX / total_data) * 100;
            let percentPariwisata = (ttlPariwisataX / total_data) * 100;
            let percentLainnya = (ttlLainnyaX / total_data) * 100;
            var options = {
                chart: {
                    type: 'donut',
                    toolbar: {
                        show: false
                    },
                    width: "100%",
                    height: 350
                },
                dataLabels: {
                    enabled: true
                },
                series: [percentAkap, percentAkdp, percentPariwisata, percentLainnya],
                labels: ['AKAP', 'AKDP', 'Pariwisata', 'Lainnya'],
                // define color blue, green, yellow, magenta
                colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560'],
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        chart: {
                            width: "100%",
                            height: 350
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            }
            var chart3 = new ApexCharts(document.querySelector("#chart3"), options);
            chart3.render();
        },
        error: function(data) {
            console.log(data);
        }, complete: function() {
            $('#loadingChart3').hide();
        }
    });
    $.ajax({
        url: '<?=base_url()?>/main/getRampcheckHistory',
        type: "GET",
        dataType: "json",
        beforeSend: function() {
            $('#loadingChart2').show();
        },
        success: function(data) {
            console.log(data);

            var options = {
                chart: {
                    type: 'line',
                    toolbar: {
                        show: false
                    },
                    width: "100%",
                    height: 350
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    curve: 'straight'
                },
                series: [],
                xaxis: {
                    categories: []
                },
                yaxis: {
                    title: {
                        text: 'Total Ramp Check'
                    }
                },
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        chart: {
                            width: "100%",
                            height: 350
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            }

            // Assuming you have your data in a variable named 'data'
            var seriesData = {};
            data.forEach(function(item) {
                if (seriesData[item.rampcheck_kesimpulan_status] === undefined) {
                    seriesData[item.rampcheck_kesimpulan_status] = [];
                }
                seriesData[item.rampcheck_kesimpulan_status].push(item.ttl_rampcheck);
                if (options.xaxis.categories.indexOf(item.rampcheck_date) === -1) {
                    options.xaxis.categories.push(item.rampcheck_date);
                }
            });

            for (var key in seriesData) {
                var seriesItem = {
                    name: key,
                    data: seriesData[key]
                };
                options.series.push(seriesItem);
            }
            var chart2 = new ApexCharts(document.querySelector('#chart2'), options);
            chart2.render();
        },
        error: function(data) {
            console.log(data);
        }, complete: function() {
            $('#loadingChart2').hide();
        }
    });
    $.ajax({
        url: '<?=base_url()?>/main/getTopTenRampcheckLocationPerBptd',
        type: "GET",
        dataType: "json",
        beforeSend: function() {
            $('#loadingtopTenRampcheckLocationPerBptd').show();
        },
        success: function(data) {
            var table = $('#topTenRampcheckLocationPerBptd').DataTable({
                data: data,
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'jenis_lokasi_name'
                    },
                    {
                        data: 'rampcheck_nama_lokasi'
                    },
                    {
                        data: 'ttl_rampcheck'
                    },
                ],
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "columnDefs": [{
                    "targets": 0,
                    "className": "text-center"
                }, {
                    "targets": 3,
                    "className": "text-right"
                }],
                "pageLength": 10,
                "bLengthChange": false,
                "bInfo": false,
                "bFilter": false,
                "bPaginate": true,
            });
        },
        error: function(data) {
            console.log(data);
        },  complete: function() {
            $('#loadingtopTenRampcheckLocationPerBptd').hide();
        }
    });
    $.ajax({
        url: '<?=base_url()?>/main/getTopFiveUserRampcheckPerBptd',
        type: "GET",
        dataType: "json",
        beforeSend: function() {
            $('#loadingtopFiveUserRampcheck').show();
        },
        success: function(data) {
            var table = $('#topFiveUserRampcheck').DataTable({
                data: data,
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'user_web_name'
                    },
                    {
                        data: 'ttl_rampcheck'
                    },
                ],
                "columnDefs": [{
                    "targets": 0,
                    "className": "text-center"
                }, {
                    "targets": 2,
                    "className": "text-right"
                }],
                "pageLength": 10,
                "bLengthChange": false,
                "bInfo": false,
                "bFilter": false,
                "bPaginate": true,
            });
        },
        error: function(data) {
            console.log(data);
        }, complete: function() {
            $('#loadingtopFiveUserRampcheck').hide();
        }
    });
    $.ajax({
        url: '<?=base_url()?>/main/getCountRampcheckPerBptd',
        type: "GET",
        dataType: "json",
        beforeSend: function() {
            $('#loadingrampcheckPerBptd').show();
        },
        success: function(data) {
            // create datatable for rampcheckPerBptd
            var table = $('#rampcheckPerBptd').DataTable({
                data: data,
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'instansi_detail_name'
                    },
                    {
                        data: 'rampcheck'
                    }
                ],
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "columnDefs": [{
                    "targets": 2,
                    "className": "text-right"
                }],
                "pageLength": 5,
                "bLengthChange": false,
                "bInfo": false,
            });
        },
        error: function(data) {
            console.log(data);
        }, complete: function() {
            $('#loadingrampcheckPerBptd').hide();
        }
    });

    $.ajax({
        url: '<?=base_url()?>/main/getLastFiveRampcheck',
        type: "GET",
        dataType: "json",
        beforeSend: function() {
            $('#loadingLastFiveRampcheck').show();
        },
        success: function(data) {
            var table = $('#lastFiveRampcheck').DataTable({
                data: data,
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'rampcheck_no',
                        render: function(data, type, row, meta) {
                            return row.rampcheck_no + '<br/><small><strong>di ' +
                                row.rampcheck_nama_lokasi +
                                '</strong><br/>Oleh : ' + row.user_web_name +
                                '</small>';
                        }
                    },
                    {
                        data: 'rampcheck_date'
                    },
                    {
                        data: 'rampcheck_noken'
                    },
                    {
                        data: 'jenis_angkutan_name'
                    },
                    {
                        data: 'rampcheck_trayek'
                    },
                    {
                        data: 'rampcheck_status'
                    }, {
                        data: 'created_at',
                        render: function(data, type, row, meta) {
                            return '<small>' + row.created_at + '</small>'
                        }
                    }
                ],
                "lengthMenu": [
                    [5, 10, 25, 50],
                    [5, 10, 25, 50, "All"]
                ],
                "bFilter": false,
                "bPaginate": false,
                "pageLength": 5,
                "bLengthChange": false,
                "bInfo": false,
            });
        },
        error: function(data) {
            console.log(data);
        }, complete: function() {
            $('#loadingLastFiveRampcheck').hide();
        }
    });
});
// refresh the document ready every 5 minutes
setInterval(function() {
    $(document).ready();
    // show information about last update
    var d = new Date();
    var n = d.toLocaleTimeString();
    $('#lastUpdate').html('Last Update: ' + n);
}, 300000);
</script>

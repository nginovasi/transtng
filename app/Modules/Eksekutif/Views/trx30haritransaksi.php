<!-- style internal -->
<style>
    .select2-container {
        width: 100% !important;
    }
</style>

<!-- content -->
<div>
    <!-- title -->
    <div class="page-hero page-container" id="page-hero">
        <div class="padding d-flex">
            <div class="page-title">
                <h2 class="text-md text-highlight"><?= $page_title ?></h2>
            </div>
            <div class="flex"></div>
        </div>
    </div>

    <!-- body -->
    <div class="container page-content page-container" id="page-content">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills no-border" id="tab">
                    <li class="nav-item">
                        <a class="nav-link active" id="nav-data" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="false"><i class="fa fa-list"></i> Transaksi Per Jalur</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">

                        <div class="form-group row">
                            <div class="input-group mb-3 col-md-3">
                                <select class="custom-select select2" name="haltebis_id" id="haltebis_id" required></select>
                            </div>
                        </div>

                        <div class="tab-content-header my-3" style="display: block;">    
                            <h6 class="tab-content-title-harian text-center font-weight-bold">REKAP LAPORAN TRANSAKSI 30 Hari Terakhir</h6>
                        </div>
                        
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">

                            <div id="chartdiv1" style="min-height: 500px; display: none"></div>
                            <div id="chartdiv2" style="min-height: 500px; display: none"></div>

                            <table class="table table-striped table-bordered table-hover" id="tabel_trx_30d" style="display: none;">
                                <thead>
                                    <tr class="border-dark" style="border:1px solid #555255">
                                        <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">No</th>
                                        <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Tanggal</th>
                                        <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Jam Aktif Transaksi</th>
                                        <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Pendapatan</th>
                                        <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Jml Transaksi</th>
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

<!-- script external -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- script internal -->
<script type="text/javascript">
    const auth_insert = '<?= $rules->i ?>';
    const auth_edit = '<?= $rules->e ?>';
    const auth_delete = '<?= $rules->d ?>';
    const auth_otorisasi = '<?= $rules->o ?>';

    const base_url = '<?= base_url() ?>';
    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';

    var dataStart = 0;
    var coreEvents;

    var chart1 = null;
    var chart2 = null;

    // init select2
    const select2Array = [
        {
            id: 'haltebis_id',
            url: '/haltebis_id_per_trx30d_select_get',
            placeholder: 'Pilih Halte/Bis',
            params: null
        }
    ];

    $(document).ready(function() {
        // init core event
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };

        // datatable load
        // coreEvents.tableColumn = datatableColumn();

        // insert
        coreEvents.insertHandler = {
        }

        // update
        coreEvents.editHandler = {
        }

        // delete
        coreEvents.deleteHandler = {
        }

        // reset
        coreEvents.resetHandler = {
        }

        select2Array.forEach(function(x) {
            coreEvents.select2InitCtmListHalteBisPendapatan('#' + x.id, x.url, x.placeholder, x.params);
        });
        
        // coreEvents.load(null, [0, 'asc'], null);

        loadGraph()
    });

    $('#haltebis_id').on('change', function() {
        loadGraph()
    })

    function loadGraph() {
        var haltebis_id = $('#haltebis_id').val();

        loaderStart();

        $.ajax({
            method: "post",
            dataType : "json",
            url: url_ajax + "/chart_trx_30d",
            data:{
                <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                "haltebis_id": haltebis_id,
                
            },
            success : function (rs) {
                if(rs.success){
                    var pendapatanarray = [];
                    var transaksiarray = [];
                    var tanggalarray = [];

                    rs['data'].forEach(function(data){
                        pendapatanarray.push(parseInt(data.pendapatan));
                        transaksiarray.push(parseInt(data.trx));
                        tanggalarray.push(data.tanggal);
                    });

                    var options1 = {
                        series: [
                            {
                                name: "Pendapatan",
                                data: pendapatanarray
                            }
                        ],
                        chart: {
                            height: 350,
                            type: 'line',
                            dropShadow: {
                                enabled: true,
                                color: '#000',
                                top: 18,
                                left: 7,
                                blur: 10,
                                opacity: 0.2
                            },
                            toolbar: {
                                show: true
                            },
                            offsetX: 20
                        },
                        colors: ['#77B6EA', '#545454'],
                        dataLabels: {
                            enabled: true,
                            formatter: function(val, { seriesIndex, dataPointIndex, w }) {
                                return numberWithCommas(val)
                            }
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        title: {
                            text: 'Grafik Pendapatan',
                            align: 'left'
                        },
                        grid: {
                            borderColor: '#e7e7e7',
                            row: {
                                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                opacity: 0.5
                            },
                            padding: {
                                top: 0,
                                right: 50,
                                bottom: 0,
                                left: 50
                            }
                        },
                        markers: {
                            size: 1
                        },
                        xaxis: {
                            categories: tanggalarray,
                            title: {
                                text: 'Tanggal'
                            },
                            labels: {
                                rotate: -45
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Kredit'
                            },
                            labels: {
                                formatter: function(val, index) {
                                    return numberWithCommas(val);
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            floating: true,
                            offsetY: -25,
                            offsetX: -5
                        }
                    };

                    var options2 = {
                        series: [
                            {
                                name: "Transaksi",
                                data: transaksiarray
                            }
                        ],
                        chart: {
                            height: 350,
                            type: 'line',
                            dropShadow: {
                                enabled: true,
                                color: '#000',
                                top: 18,
                                left: 7,
                                blur: 10,
                                opacity: 0.2
                            },
                            toolbar: {
                                show: true
                            },
                            offsetX: 20
                        },
                        colors: ['#77B6EA', '#545454'],
                        dataLabels: {
                            enabled: true,
                            formatter: function(val, { seriesIndex, dataPointIndex, w }) {
                                return numberWithCommas(val)
                            }
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        title: {
                            text: 'Grafik Jumlah Transaksi',
                            align: 'left'
                        },
                        grid: {
                            borderColor: '#e7e7e7',
                            row: {
                                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                opacity: 0.5
                            },
                            padding: {
                                top: 0,
                                right: 50,
                                bottom: 0,
                                left: 50
                            }
                        },
                        markers: {
                            size: 1
                        },
                        xaxis: {
                            categories: tanggalarray,
                            title: {
                                text: 'Tanggal'
                            },
                            labels: {
                                rotate: -45
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Transaksi'
                            },
                            labels: {
                                formatter: function(val, index) {
                                    return numberWithCommas(val);
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            floating: true,
                            offsetY: -25,
                            offsetX: -5
                        }
                    };

                    $('#chartdiv1').empty();
                    $('#chartdiv2').empty();

                    if(chart1 != null && chart2 != null){
                        chart1.destroy();
                        chart2.destroy();
                    }

                    chart1 = new ApexCharts(document.querySelector("#chartdiv1"), options1);
                    chart2 = new ApexCharts(document.querySelector("#chartdiv2"), options2);

                    chart1.render();
                    chart2.render();

                    $('#tabel_trx_30d').show();
                    $("#tabel_trx_30d").find("tr:gt(0)").remove();
                    $.each(rs.data, function(index, value){
                        var result = `
                            <tr class="border-dark">
                                <td class="border-dark text-center" class="text-center">${index + 1 }</td>
                                <td class="border-dark text-center" class="text-center">${value.tanggal}</td>
                                <td class="border-dark text-center">${value.jam_aktif_transaksi}</td>
                                <td class="border-dark text-right">${numberWithCommas(value.pendapatan)}</td>
                                <td class="border-dark text-right">${numberWithCommas(value.trx)}</td>
                            </tr>
                        `;

                        $("#tabel_trx_30d").append(result);
                    });

                    loaderEnd()
                }else{
                    $("#tabel_trx_30d").find("tr:gt(0)").remove();
                    $('#tabel_trx_30d').css('display','none');

                    loaderEnd();
                }
            }
        })
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function loaderStart() {
        Swal.fire({
            title: "",
            icon: "info",
            text: "Proses menampilkan data, mohon ditunggu...",
            didOpen: function() {
                Swal.showLoading()
            }
        });
    }

    function loaderEnd() {
        swal.close();
    }

</script>

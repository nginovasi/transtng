<!-- style internal -->
<style>
    .select2-container {
        width: 100% !important;
    }

    #grafik-rekap {
        width: 100%;
        height: 500px;
    }

    #grafik-rekap2 {
        width: 100%;
        height: 500px;
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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="true"><i class="fa fa-calendar" aria-hidden="true"></i> Data</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="form-group row">
                                <div class="input-group mb-3 col-lg-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-md date" name="date" id="date" placeholder="Masukkan Tanggal" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-control-sm mt-n1 col-md-2">
                                    <button class="btn btn-success btn-transaction" id="btn-transaction">Lihat Transaksi</button>
                                </div>
                                <div class="mb-2">
                                    <div class="btn-group" style="display: none;">
                                        <button class="btn btn-white">Export</button>
                                        <button class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(93px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" id="download-pdf">
                                                PDF
                                            </a>    
                                            <!-- <a class="dropdown-item">
                                                Excel
                                            </a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="grafik-title">
                                <h5 class="text-center d-none">Statistik Rekap Transaksi Jalur - (10-06-2023 s/d 26-06-2023)</h5>
                            </div>

                            <div id="grafik-rekap"></div>

                            <div id="grafik-rekap2"></div>
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
<script src="https://www.amcharts.com/lib/4/themes/kelly.js"></script>

<!-- script internal -->
<script type="text/javascript">
    const auth_insert = '<?= $rules->i ?>';
    const auth_edit = '<?= $rules->e ?>';
    const auth_delete = '<?= $rules->d ?>';
    const auth_otorisasi = '<?= $rules->o ?>';

    const base_url = '<?= base_url() ?>';
    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';
    const url_pdf = '<?= base_url() . "/" . uri_segment(0) . "/pdf/exportTransaksiPerJenisHarian" . "" ?>';

    var dataStart = 0;
    var coreEvents;

    // init select2
    const select2Array = [
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

        coreEvents.daterangepicker('#date', 'yyyy-mm-dd')

        $('#download-pdf').on('click', function(e) {
            let date = $('#date').val()

            $(this).attr("href", url_pdf + '?date=' + date + '');
            $(this).attr("target", "_blank");
        });

    });

    $('#btn-transaction').on('click', function() {
        let date = $('#date').val()

        $.ajax({
            method: "post",
            dataType : "json",
            url: url_ajax + "/getTrxGrfkPerJalurDateRange",
            data:{
                <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                "date": date,
            },
            success : function (rs) {
                if(rs.success){
                    $('.grafik-title h5').removeClass('d-none')
                    $('.grafik-title h5').addClass('d-block')
                    $('.grafik-title h5').text(`Statistik Rekap Transaksi Jalur - (${date})`)
                    
                    $('.btn-group').css('display', 'block')  
                            
                    grafik(rs.data.result);

                    runChart2("grafik-rekap2", "transaksi", rs.data.result, rs.data.list_jalur)
                }
            }
        })
    })

    function grafik(dataTrans, waktu = "koridor"){
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var container = "grafik-rekap";
        var chart = am4core.create(container, am4charts.XYChart);
        chart.width = am4core.percent(100);
        chart.height = am4core.percent(100);
        chart.data = dataTrans;

        chart.maskBullets = false;

        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        var yAxis = chart.yAxes.push(new am4charts.CategoryAxis());

        xAxis.dataFields.category = "jalur";
        yAxis.dataFields.category = "jenis";

        xAxis.renderer.grid.template.disabled = true;
        xAxis.renderer.minGridDistance = 40;
        xAxis.title.text = "Tenant";
        xAxis.title.fontWeight = 600;

        xAxis.events.on("sizechanged", function(ev) {
            var axis = ev.target;
            var cellWidth = axis.pixelWidth / (axis.endIndex - axis.startIndex);
            if (cellWidth < 90) {
                axis.renderer.labels.template.rotation = -90;
                axis.renderer.labels.template.horizontalCenter = "top";
                axis.renderer.labels.template.verticalCenter = "middle";
                axis.renderer.labels.template.wrap = false;
            }
            else {
                axis.renderer.labels.template.rotation = 0;
                axis.renderer.labels.template.horizontalCenter = "middle";
                axis.renderer.labels.template.verticalCenter = "top";
                axis.renderer.labels.template.wrap = true;
                axis.renderer.labels.template.maxWidth = 100;
            }
        });

        yAxis.renderer.grid.template.disabled = true;
        yAxis.renderer.inversed = true;
        yAxis.renderer.minGridDistance = 30;
        yAxis.renderer.labels.template.align = "left";
        yAxis.title.text = "Waktu ("+waktu+")";
        yAxis.title.fontWeight = 600;

        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.categoryX = "jalur";
        series.dataFields.categoryY = "jenis";
        series.dataFields.value = "ttl_trx";
        series.sequencedInterpolation = true;
        series.defaultState.transitionDuration = 3000;

        var bgColor = new am4core.InterfaceColorSet().getFor("background");

        var columnTemplate = series.columns.template;
        columnTemplate.strokeWidth = 1;
        columnTemplate.strokeOpacity = 0.2;
        columnTemplate.stroke = bgColor;
        columnTemplate.tooltipText = "{jenis} "+waktu+" {jalur} ({ttl_trx} penumpang): Rp.{jml_trx.formatNumber('#,###')}";
        columnTemplate.width = am4core.percent(100);
        columnTemplate.height = am4core.percent(100);

        series.heatRules.push({
            target: columnTemplate,
            property: "fill",
            min: am4core.color("#e4fcfc"),
            max: chart.colors.getIndex(0)
        });

        // heat legend
        var heatLegend = chart.bottomAxesContainer.createChild(am4charts.HeatLegend);
        heatLegend.width = am4core.percent(100);
        heatLegend.series = series;
        heatLegend.marginTop = 50;
        heatLegend.valueAxis.renderer.labels.template.fontSize = 10;
        heatLegend.valueAxis.title.fontSize = 10;
        heatLegend.valueAxis.renderer.minGridDistance = 30;
        heatLegend.valueAxis.title.text = "Skala Jml Penumpang";
        heatLegend.valueAxis.title.fontWeight = 400;

        // heat legend behavior
        series.columns.template.events.on("over", function(event) {
            handleHover(event.target);
        })

        series.columns.template.events.on("hit", function(event) {
            handleHover(event.target);
        })

        function handleHover(column) {
            if (!isNaN(column.dataItem.value)) {
                heatLegend.valueAxis.showTooltipAt(column.dataItem.value)
            }
            else {
                heatLegend.valueAxis.hideTooltip();
            }
        }

        series.columns.template.events.on("out", function(event) {
            heatLegend.valueAxis.hideTooltip();
        })
    }

    // function runChart2(div, jenis, dataTrans, listKoridor) {
    //     am4core.useTheme(am4themes_animated);

    //     // Create chart instance
    //     var chart = am4core.create("grafik-rekap2", am4charts.XYChart);

    //     // Add data
    //     chart.data = [
    //     {
    //         "jalur": "dyr 01",
    //         "value1": 450,
    //         "value2": 162,
    //         "value3": 1100
    //     }, {
    //         "jalur": "dyr 02",
    //         "value1": 669,
    //         "value3": 841
    //     }];

    //     console.info('wokeee')
    //     console.info(chart.data)

    //     // Create axes
    //     var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    //     dateAxis.renderer.grid.template.location = 0;
    //     dateAxis.renderer.minGridDistance = 30;

    //     var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

    //     // Create series
    //     function createSeries(field, name) {
    //         var series = chart.series.push(new am4charts.LineSeries());
    //         series.dataFields.valueY = field;
    //         series.dataFields.dateX = "jalur";
    //         series.name = name;
    //         series.tooltipText = "{dateX}: [b]{valueY}[/]";
    //         series.strokeWidth = 2;
            
    //         // series.smoothing = "monotoneX";
            
    //         var bullet = series.bullets.push(new am4charts.CircleBullet());
    //         bullet.circle.stroke = am4core.color("#fff");
    //         bullet.circle.strokeWidth = 2;
            
    //         return series;
    //     }

    //     createSeries("value1", "Series #1");
    //     createSeries("value2", "Series #2");
    //     createSeries("value3", "Series #3");

    //     chart.legend = new am4charts.Legend();
    //     chart.cursor = new am4charts.XYCursor();
    // }

    function runChart2(div, jenis, dataTransd, listKoridord) {
            let dataTrans = [
                                {
                                    "jenis": "Jalur 10",
                                    "kredit": "1,033,560",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 10",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 10": "402"
                                },
                                {
                                    "jenis": "Jalur 11",
                                    "kredit": "547,920",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 11",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 11": "253"
                                },
                                {
                                    "jenis": "Jalur 13",
                                    "kredit": "280,800",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 13",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 13": "103"
                                },
                                {
                                    "jenis": "Jalur 14",
                                    "kredit": "750,240",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 14",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 14": "371"
                                },
                                {
                                    "jenis": "Jalur 15",
                                    "kredit": "1,428,060",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 15",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 15": "602"
                                },
                                {
                                    "jenis": "Jalur 1A",
                                    "kredit": "184,140",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 1A",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 1A": "64"
                                },
                                {
                                    "jenis": "Jalur 1B",
                                    "kredit": "3,487,920",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 1B",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 1B": "1,201"
                                },
                                {
                                    "jenis": "Jalur 2B",
                                    "kredit": "1,142,160",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 2B",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 2B": "523"
                                },
                                {
                                    "jenis": "Jalur 3A",
                                    "kredit": "1,761,900",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 3A",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 3A": "717"
                                },
                                {
                                    "jenis": "Jalur 3B",
                                    "kredit": "1,404,600",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 3B",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 3B": "574"
                                },
                                {
                                    "jenis": "Jalur 4A",
                                    "kredit": "304,680",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 4A",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 4A": "122"
                                },
                                {
                                    "jenis": "Jalur 4B",
                                    "kredit": "271,440",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 4B",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 4B": "96"
                                },
                                {
                                    "jenis": "Jalur 5A",
                                    "kredit": "324,120",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 5A",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 5A": "138"
                                },
                                {
                                    "jenis": "Jalur 5B",
                                    "kredit": "503,100",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 5B",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 5B": "242"
                                },
                                {
                                    "jenis": "Jalur 6A",
                                    "kredit": "457,860",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 6A",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 6A": "163"
                                },
                                {
                                    "jenis": "Jalur 6B",
                                    "kredit": "329,820",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 6B",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 6B": "122"
                                },
                                {
                                    "jenis": "Jalur 7",
                                    "kredit": "149,880",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 7",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 7": "57"
                                },
                                {
                                    "jenis": "Jalur 8",
                                    "kredit": "773,460",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 8",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 8": "258"
                                },
                                {
                                    "jenis": "Jalur 9",
                                    "kredit": "756,480",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur 9",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 9": "312"
                                },
                                {
                                    "jenis": "Jalur CAD1",
                                    "kredit": "6,259,560",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur CAD1",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur CAD1": "2,080"
                                },
                                {
                                    "jenis": "Jalur CAD2",
                                    "kredit": "677,520",
                                    "tanggal": "2023-06-15",
                                    "jam": "Jalur CAD2",
                                    "koridor": "2023-06-15",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur CAD2": "224"
                                },
                                {
                                    "jenis": "Jalur 10",
                                    "kredit": "1,078,860",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 10",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 10": "481"
                                },
                                {
                                    "jenis": "Jalur 11",
                                    "kredit": "396,900",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 11",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 11": "229"
                                },
                                {
                                    "jenis": "Jalur 13",
                                    "kredit": "339,060",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 13",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 13": "121"
                                },
                                {
                                    "jenis": "Jalur 14",
                                    "kredit": "680,820",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 14",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 14": "365"
                                },
                                {
                                    "jenis": "Jalur 15",
                                    "kredit": "1,505,040",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 15",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 15": "610"
                                },
                                {
                                    "jenis": "Jalur 1A",
                                    "kredit": "295,440",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 1A",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 1A": "113"
                                },
                                {
                                    "jenis": "Jalur 1B",
                                    "kredit": "3,342,360",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 1B",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 1B": "1,183"
                                },
                                {
                                    "jenis": "Jalur 2A",
                                    "kredit": "200,580",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 2A",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 2A": "75"
                                },
                                {
                                    "jenis": "Jalur 2B",
                                    "kredit": "1,146,900",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 2B",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 2B": "526"
                                },
                                {
                                    "jenis": "Jalur 3A",
                                    "kredit": "1,641,120",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 3A",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 3A": "685"
                                },
                                {
                                    "jenis": "Jalur 3B",
                                    "kredit": "1,402,500",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 3B",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 3B": "578"
                                },
                                {
                                    "jenis": "Jalur 4A",
                                    "kredit": "255,480",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 4A",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 4A": "112"
                                },
                                {
                                    "jenis": "Jalur 4B",
                                    "kredit": "255,120",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 4B",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 4B": "91"
                                },
                                {
                                    "jenis": "Jalur 5A",
                                    "kredit": "259,080",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 5A",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 5A": "129"
                                },
                                {
                                    "jenis": "Jalur 5B",
                                    "kredit": "430,860",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 5B",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 5B": "226"
                                },
                                {
                                    "jenis": "Jalur 6A",
                                    "kredit": "329,340",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 6A",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 6A": "141"
                                },
                                {
                                    "jenis": "Jalur 6B",
                                    "kredit": "425,520",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 6B",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 6B": "158"
                                },
                                {
                                    "jenis": "Jalur 7",
                                    "kredit": "196,020",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 7",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 7": "73"
                                },
                                {
                                    "jenis": "Jalur 8",
                                    "kredit": "699,480",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 8",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 8": "252"
                                },
                                {
                                    "jenis": "Jalur 9",
                                    "kredit": "686,940",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur 9",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 9": "304"
                                },
                                {
                                    "jenis": "Jalur CAD1",
                                    "kredit": "5,811,000",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur CAD1",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur CAD1": "2,060"
                                },
                                {
                                    "jenis": "Jalur CAD2",
                                    "kredit": "777,120",
                                    "tanggal": "2023-06-16",
                                    "jam": "Jalur CAD2",
                                    "koridor": "2023-06-16",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur CAD2": "326"
                                },
                                {
                                    "jenis": "Jalur 10",
                                    "kredit": "1,045,980",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 10",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 10": "356"
                                },
                                {
                                    "jenis": "Jalur 11",
                                    "kredit": "436,260",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 11",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 11": "146"
                                },
                                {
                                    "jenis": "Jalur 13",
                                    "kredit": "236,760",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 13",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 13": "73"
                                },
                                {
                                    "jenis": "Jalur 14",
                                    "kredit": "674,640",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 14",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 14": "390"
                                },
                                {
                                    "jenis": "Jalur 15",
                                    "kredit": "1,333,560",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 15",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 15": "479"
                                },
                                {
                                    "jenis": "Jalur 1A",
                                    "kredit": "366,060",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 1A",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 1A": "122"
                                },
                                {
                                    "jenis": "Jalur 1B",
                                    "kredit": "3,403,320",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 1B",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 1B": "1,124"
                                },
                                {
                                    "jenis": "Jalur 2A",
                                    "kredit": "221,100",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 2A",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 2A": "76"
                                },
                                {
                                    "jenis": "Jalur 2B",
                                    "kredit": "966,900",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 2B",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 2B": "356"
                                },
                                {
                                    "jenis": "Jalur 3A",
                                    "kredit": "1,620,360",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 3A",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 3A": "587"
                                },
                                {
                                    "jenis": "Jalur 3B",
                                    "kredit": "1,037,340",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 3B",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 3B": "378"
                                },
                                {
                                    "jenis": "Jalur 4A",
                                    "kredit": "266,100",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 4A",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 4A": "94"
                                },
                                {
                                    "jenis": "Jalur 4B",
                                    "kredit": "242,280",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 4B",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 4B": "80"
                                },
                                {
                                    "jenis": "Jalur 5A",
                                    "kredit": "279,480",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 5A",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 5A": "115"
                                },
                                {
                                    "jenis": "Jalur 5B",
                                    "kredit": "405,600",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 5B",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 5B": "175"
                                },
                                {
                                    "jenis": "Jalur 6A",
                                    "kredit": "414,840",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 6A",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 6A": "138"
                                },
                                {
                                    "jenis": "Jalur 6B",
                                    "kredit": "427,980",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 6B",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 6B": "154"
                                },
                                {
                                    "jenis": "Jalur 7",
                                    "kredit": "147,120",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 7",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 7": "53"
                                },
                                {
                                    "jenis": "Jalur 8",
                                    "kredit": "760,260",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 8",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 8": "264"
                                },
                                {
                                    "jenis": "Jalur 9",
                                    "kredit": "731,280",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur 9",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 9": "263"
                                },
                                {
                                    "jenis": "Jalur CAD1",
                                    "kredit": "6,905,520",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur CAD1",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur CAD1": "2,188"
                                },
                                {
                                    "jenis": "Jalur CAD2",
                                    "kredit": "818,520",
                                    "tanggal": "2023-06-17",
                                    "jam": "Jalur CAD2",
                                    "koridor": "2023-06-17",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur CAD2": "258"
                                },
                                {
                                    "jenis": "Jalur null",
                                    "kredit": "3,600",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur null",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur null": "1"
                                },
                                {
                                    "jenis": "Jalur 10",
                                    "kredit": "1,015,320",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 10",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 10": "349"
                                },
                                {
                                    "jenis": "Jalur 11",
                                    "kredit": "352,680",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 11",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 11": "125"
                                },
                                {
                                    "jenis": "Jalur 13",
                                    "kredit": "211,560",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 13",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 13": "65"
                                },
                                {
                                    "jenis": "Jalur 14",
                                    "kredit": "681,900",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 14",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 14": "246"
                                },
                                {
                                    "jenis": "Jalur 15",
                                    "kredit": "1,700,040",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 15",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 15": "590"
                                },
                                {
                                    "jenis": "Jalur 1A",
                                    "kredit": "162,060",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 1A",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 1A": "50"
                                },
                                {
                                    "jenis": "Jalur 1B",
                                    "kredit": "3,091,800",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 1B",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 1B": "1,003"
                                },
                                {
                                    "jenis": "Jalur 2A",
                                    "kredit": "218,760",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 2A",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 2A": "84"
                                },
                                {
                                    "jenis": "Jalur 2B",
                                    "kredit": "774,120",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 2B",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 2B": "282"
                                },
                                {
                                    "jenis": "Jalur 3A",
                                    "kredit": "1,264,140",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 3A",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 3A": "464"
                                },
                                {
                                    "jenis": "Jalur 3B",
                                    "kredit": "1,093,260",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 3B",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 3B": "372"
                                },
                                {
                                    "jenis": "Jalur 4A",
                                    "kredit": "146,040",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 4A",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 4A": "53"
                                },
                                {
                                    "jenis": "Jalur 4B",
                                    "kredit": "166,920",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 4B",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 4B": "59"
                                },
                                {
                                    "jenis": "Jalur 5A",
                                    "kredit": "297,600",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 5A",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 5A": "106"
                                },
                                {
                                    "jenis": "Jalur 5B",
                                    "kredit": "422,460",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 5B",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 5B": "163"
                                },
                                {
                                    "jenis": "Jalur 6A",
                                    "kredit": "421,380",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 6A",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 6A": "130"
                                },
                                {
                                    "jenis": "Jalur 6B",
                                    "kredit": "317,400",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 6B",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 6B": "105"
                                },
                                {
                                    "jenis": "Jalur 7",
                                    "kredit": "152,400",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 7",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 7": "52"
                                },
                                {
                                    "jenis": "Jalur 8",
                                    "kredit": "772,980",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 8",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 8": "261"
                                },
                                {
                                    "jenis": "Jalur 9",
                                    "kredit": "678,180",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur 9",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 9": "229"
                                },
                                {
                                    "jenis": "Jalur CAD1",
                                    "kredit": "6,986,220",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur CAD1",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur CAD1": "2,186"
                                },
                                {
                                    "jenis": "Jalur CAD2",
                                    "kredit": "847,110",
                                    "tanggal": "2023-06-18",
                                    "jam": "Jalur CAD2",
                                    "koridor": "2023-06-18",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur CAD2": "274"
                                },
                                {
                                    "jenis": "Jalur 10",
                                    "kredit": "487,260",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 10",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 10": "173"
                                },
                                {
                                    "jenis": "Jalur 11",
                                    "kredit": "142,620",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 11",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 11": "51"
                                },
                                {
                                    "jenis": "Jalur 13",
                                    "kredit": "128,760",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 13",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 13": "41"
                                },
                                {
                                    "jenis": "Jalur 14",
                                    "kredit": "456,000",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 14",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 14": "203"
                                },
                                {
                                    "jenis": "Jalur 15",
                                    "kredit": "426,360",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 15",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 15": "158"
                                },
                                {
                                    "jenis": "Jalur 1A",
                                    "kredit": "57,780",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 1A",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 1A": "20"
                                },
                                {
                                    "jenis": "Jalur 1B",
                                    "kredit": "1,312,380",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 1B",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 1B": "425"
                                },
                                {
                                    "jenis": "Jalur 2A",
                                    "kredit": "70,500",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 2A",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 2A": "27"
                                },
                                {
                                    "jenis": "Jalur 2B",
                                    "kredit": "232,260",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 2B",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 2B": "93"
                                },
                                {
                                    "jenis": "Jalur 3A",
                                    "kredit": "476,040",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 3A",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 3A": "189"
                                },
                                {
                                    "jenis": "Jalur 3B",
                                    "kredit": "335,400",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 3B",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 3B": "123"
                                },
                                {
                                    "jenis": "Jalur 4A",
                                    "kredit": "129,540",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 4A",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 4A": "57"
                                },
                                {
                                    "jenis": "Jalur 4B",
                                    "kredit": "90,120",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 4B",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 4B": "30"
                                },
                                {
                                    "jenis": "Jalur 5A",
                                    "kredit": "48,720",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 5A",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 5A": "19"
                                },
                                {
                                    "jenis": "Jalur 5B",
                                    "kredit": "117,960",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 5B",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 5B": "54"
                                },
                                {
                                    "jenis": "Jalur 6A",
                                    "kredit": "62,100",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 6A",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 6A": "19"
                                },
                                {
                                    "jenis": "Jalur 6B",
                                    "kredit": "138,600",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 6B",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 6B": "58"
                                },
                                {
                                    "jenis": "Jalur 7",
                                    "kredit": "61,260",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 7",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 7": "20"
                                },
                                {
                                    "jenis": "Jalur 8",
                                    "kredit": "347,880",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 8",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 8": "118"
                                },
                                {
                                    "jenis": "Jalur 9",
                                    "kredit": "282,300",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur 9",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur 9": "94"
                                },
                                {
                                    "jenis": "Jalur CAD1",
                                    "kredit": "2,436,660",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur CAD1",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur CAD1": "772"
                                },
                                {
                                    "jenis": "Jalur CAD2",
                                    "kredit": "487,440",
                                    "tanggal": "2023-06-19",
                                    "jam": "Jalur CAD2",
                                    "koridor": "2023-06-19",
                                    "transaksiInt": 0,
                                    "kreditInt": 0,
                                    "Jalur CAD2": "159"
                                }
                            ];
        
            let listKoridor = [
                                "10",
                                "11",
                                "13",
                                "14",
                                "15",
                                "1A",
                                "1B",
                                "2A",
                                "2B",
                                "3A",
                                "3B",
                                "4A",
                                "4B",
                                "5A",
                                "5B",
                                "6A",
                                "6B",
                                "7",
                                "8",
                                "9",
                                "CAD1",
                                "CAD2"
                            ]
            
            var sentence = titleCase(jenis);
            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            // Create chart instance
            var chart = am4core.create(div, am4charts.XYChart);

            // Increase contrast by taking evey second color
            chart.colors.step = 2;

            // Add data
            chart.data = dataTrans;
            // console.log(chart.data);

            // Create axes
            var dateAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            dateAxis.renderer.minGridDistance = 50;
            dateAxis.dataFields.category = "tanggal";
            dateAxis.title.text = "Tanggal";
            dateAxis.title.fontWeight = 600;

            dateAxis.events.on("sizechanged", function(ev) {
                var axis = ev.target;
                var cellWidth = axis.pixelWidth / (axis.endIndex - axis.startIndex);
                if (cellWidth < 90) {
                    axis.renderer.labels.template.rotation = -90;
                    axis.renderer.labels.template.horizontalCenter = "top";
                    axis.renderer.labels.template.verticalCenter = "middle";
                    axis.renderer.labels.template.wrap = false;
                }
                else {
                    axis.renderer.labels.template.rotation = 0;
                    axis.renderer.labels.template.horizontalCenter = "middle";
                    axis.renderer.labels.template.verticalCenter = "top";
                    axis.renderer.labels.template.wrap = true;
                    axis.renderer.labels.template.maxWidth = 100;
                }
            });

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.minGridDistance = 20;
            valueAxis.renderer.labels.template.align = "left";
            valueAxis.title.text = "Jumlah "+sentence;
            valueAxis.title.fontWeight = 600;

            let bullets = ["rectangle","triangle"];
            var series = [];
            var arrayseries = [];
            listKoridor.forEach(element => {
                let randomBullets = bullets[Math.floor(Math.random() * bullets.length)];
                var dataseries = dataTrans.filter(obj => {
                    return obj.jenis === "Jalur "+element
                });
                series[element] = dataseries;
                if (series[element].length > 0){
                    createAxisAndSeries("Jalur "+element, sentence+" Jalur "+element, true, randomBullets, element, arrayseries, series[element]);
                }
            });
            // Create series
            function createAxisAndSeries(field, name, opposite, bullet, element, arrayseries, dataseries) {
                arrayseries[element] = chart.series.push(new am4charts.LineSeries());
                arrayseries[element].dataFields.valueY = field;
                arrayseries[element].dataFields.categoryX = "tanggal";
                arrayseries[element].strokeWidth = 2;
                // arrayseries[element].yAxis = valueAxis;
                arrayseries[element].name = name;
                arrayseries[element].tooltipText = name+" Tanggal {tanggal}: [bold]{valueY}[/]";
                arrayseries[element].tensionX = 0.8;
                arrayseries[element].data = dataseries;
                // console.log(arrayseries[element].data);

                var interfaceColors = new am4core.InterfaceColorSet();

                switch(bullet) {
                    case "triangle":
                        var bullet = arrayseries[element].bullets.push(new am4charts.Bullet());
                        bullet.width = 12;
                        bullet.height = 12;
                        bullet.horizontalCenter = "middle";
                        bullet.verticalCenter = "middle";

                        var triangle = bullet.createChild(am4core.Triangle);
                        triangle.stroke = interfaceColors.getFor("background");
                        triangle.strokeWidth = 2;
                        triangle.direction = "top";
                        triangle.width = 12;
                        triangle.height = 12;
                        break;
                    case "rectangle":
                        var bullet = arrayseries[element].bullets.push(new am4charts.Bullet());
                        bullet.width = 10;
                        bullet.height = 10;
                        bullet.horizontalCenter = "middle";
                        bullet.verticalCenter = "middle";

                        var rectangle = bullet.createChild(am4core.Rectangle);
                        rectangle.stroke = interfaceColors.getFor("background");
                        rectangle.strokeWidth = 2;
                        rectangle.width = 10;
                        rectangle.height = 10;
                        break;
                    default:
                        var bullet = arrayseries[element].bullets.push(new am4charts.CircleBullet());
                        bullet.circle.stroke = interfaceColors.getFor("background");
                        bullet.circle.strokeWidth = 2;
                        break;
                }
            }

            // Add legend
            chart.legend = new am4charts.Legend();

            // Add cursor
            chart.cursor = new am4charts.XYCursor();
        }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function titleCase(text){
        var result = text.replace( /([A-Z])/g, " $1" );
        var finalResult = result.charAt(0).toUpperCase() + result.slice(1);
        return finalResult;
    }

</script>

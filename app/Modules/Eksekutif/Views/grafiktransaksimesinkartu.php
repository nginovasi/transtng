<!-- style internal -->
<style>
    .select2-container {
        width: 100% !important;
    }

    #grafik-rekap-jam {
        width: 100%;
        height: 500px;
    }

    #grafik-rekap-tanggal {
        width: 100%;
        height: 500px;
    }

    #grafik-rekap-bulan {
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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data-jam" role="tab" aria-controls="tab-data-jam" aria-selected="true"><i class="fa fa-calendar" aria-hidden="true"></i> Harian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-data-tanggal" role="tab" aria-controls="tab-data-tanggal" aria-selected="false"><i class="fa fa-calendar" aria-hidden="true"></i> Bulanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-data-bulan" role="tab" aria-controls="tab-data-bulan" aria-selected="false"><i class="fa fa-calendar" aria-hidden="true"></i> Tahunan</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data-jam" role="tabpanel" aria-labelledby="tab-data-jam">
                            <div class="form-group row">
                                <div class="input-group mb-3 col-lg-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-md date" name="date-jam" id="date-jam" placeholder="Masukkan Tanggal" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="btn-group-jam" style="display: none;">
                                        <button class="btn btn-white">Export</button>
                                        <button class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(93px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" id="download-jam-pdf">
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

                            <div id="grafik-rekap-jam"></div>
                        </div>
                        <div class="tab-pane fade" id="tab-data-tanggal" role="tabpanel" aria-labelledby="tab-data-tanggal">
                            <div class="form-group row">
                                <div class="input-group mb-3 col-lg-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-md date" name="date-tanggal" id="date-tanggal" placeholder="Masukkan Tanggal" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <div class="btn-group-tanggal" style="display: none;">
                                        <button class="btn btn-white">Export</button>
                                        <button class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(93px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" id="download-tanggal-pdf">
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

                            <div id="grafik-rekap-tanggal"></div>
                        </div>
                        <div class="tab-pane fade" id="tab-data-bulan" role="tabpanel" aria-labelledby="tab-data-bulan">
                            <div class="form-group row">
                                <div class="input-group mb-3 col-lg-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-md date" name="date-bulan" id="date-bulan" placeholder="Masukkan Tahun" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <div class="btn-group-bulan" style="display: none;">
                                        <button class="btn btn-white">Export</button>
                                        <button class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(93px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" id="download-bulan-pdf">
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

                            <div id="grafik-rekap-bulan"></div>
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
    const url_pdf_jam = '<?= base_url() . "/" . uri_segment(0) . "/pdf/exportTransaksiPerJenisHarian" . "" ?>';
    const url_pdf_tanggal = '<?= base_url() . "/" . uri_segment(0) . "/pdf/exportTransaksiPerJenisBulanan" . "" ?>';
    const url_pdf_bulan = '<?= base_url() . "/" . uri_segment(0) . "/pdf/exportTransaksiPerJenisTahunan" . "" ?>';

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

        coreEvents.datepicker('#date-jam', 'yyyy-mm-dd')

        $('#download-jam-pdf').on('click', function(e) {
            let dateJam = $('#date-jam').val()

            $(this).attr("href", url_pdf_jam + '?date=' + dateJam + '');
            $(this).attr("target", "_blank");
        });

        coreEvents.datepickermonthly('#date-tanggal', 'yyyy-mm')

        $('#download-tanggal-pdf').on('click', function(e) {
            let dateTanggal = $('#date-tanggal').val()

            $(this).attr("href", url_pdf_tanggal + '?date=' + dateTanggal + '');
            $(this).attr("target", "_blank");
        });

        coreEvents.datepickeryears('#date-bulan', 'yyyy')

        $('#download-bulan-pdf').on('click', function(e) {
            let dateBulan = $('#date-bulan').val()

            $(this).attr("href", url_pdf_bulan + '?date=' + dateBulan + '');
            $(this).attr("target", "_blank");
        });

    });

    $('#date-jam').on('change', function() {
        let date = $(this).val()

        $.ajax({
            method: "post",
            dataType : "json",
            url: url_ajax + "/getTrxGrfkPerjenisHarian",
            data:{
                <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                "date": date,
                
            },
            success : function (rs) {

                if(rs.success){
                    $('.btn-group-jam').css('display', 'block')  
                            
                    grafik(rs.data.result, 'jam');
                }
            }
        })
    })

    $('#date-tanggal').on('change', function() {
        let date = $(this).val()

        $.ajax({
            method: "post",
            dataType : "json",
            url: url_ajax + "/getTrxGrfkPerjenisBulanan",
            data:{
                <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                "date": date,
                
            },
            success : function (rs) {
                if(rs.success){
                    $('.btn-group-tanggal').css('display', 'block')  
                            
                    grafik(rs.data.result, 'tanggal');
                }
            }
        })
    })

    $('#date-bulan').on('change', function() {
        let date = $(this).val()

        $.ajax({
            method: "post",
            dataType : "json",
            url: url_ajax + "/getTrxGrfkPerjenisTahunan",
            data:{
                <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                "date": date,
                
            },
            success : function (rs) {
                if(rs.success){
                    $('.btn-group-bulan').css('display', 'block')  
                            
                    grafik(rs.data.result, 'bulan');
                }
            }
        })
    })

    function grafik(dataTrans, waktu){
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var container = "grafik-rekap-"+waktu;
        var chart = am4core.create(container, am4charts.XYChart);
        chart.width = am4core.percent(100);
        chart.height = am4core.percent(100);
        chart.data = dataTrans;

        chart.maskBullets = false;

        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        var yAxis = chart.yAxes.push(new am4charts.CategoryAxis());

        xAxis.dataFields.category = "jenis";
        yAxis.dataFields.category = "waktu";

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
        series.dataFields.categoryX = "jenis";
        series.dataFields.categoryY = "waktu";
        series.dataFields.value = "ttl_trx";
        series.sequencedInterpolation = true;
        series.defaultState.transitionDuration = 3000;

        var bgColor = new am4core.InterfaceColorSet().getFor("background");

        var columnTemplate = series.columns.template;
        columnTemplate.strokeWidth = 1;
        columnTemplate.strokeOpacity = 0.2;
        columnTemplate.stroke = bgColor;
        columnTemplate.tooltipText = "{jenis} "+waktu+" {waktu} ({ttl_trx} penumpang): Rp.{jml_trx.formatNumber('#,###')}";
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

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

</script>

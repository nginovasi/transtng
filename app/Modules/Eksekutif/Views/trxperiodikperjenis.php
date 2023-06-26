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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data-harian" role="tab" aria-controls="tab-data-harian" aria-selected="true"><i class="fa fa-calendar" aria-hidden="true"></i> Harian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-data-bulan" role="tab" aria-controls="tab-data-bulan" aria-selected="false"><i class="fa fa-calendar" aria-hidden="true"></i> Bulanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-data-tahun" role="tab" aria-controls="tab-data-tahun" aria-selected="false"><i class="fa fa-calendar" aria-hidden="true"></i> Tahunan</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data-harian" role="tabpanel" aria-labelledby="tab-data-harian">
                            <div class="form-group row">
                                <div class="input-group mb-3 col-lg-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-md date" name="date-harian" id="date-harian" placeholder="Masukkan Tanggal" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="btn-group-harian" style="display: none;">
                                        <button class="btn btn-white">Export</button>
                                        <button class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(93px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" id="download-harian-pdf">
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

                            <div class="tab-content-header my-3" style="display: block;">    
                                <h6 class="tab-content-title-harian text-center font-weight-bold"></h6>
                            </div>

                            <div id="statistik-rekap-harian"></div>
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
                                        <input type="text" class="form-control form-control-md date" name="date-bulanan" id="date-bulanan" placeholder="Masukkan Bulan" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <div class="btn-group-bulanan" style="display: none;">
                                        <button class="btn btn-white">Export</button>
                                        <button class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(93px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" id="download-bulanan-pdf">
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

                            <div class="tab-content-header my-3" style="display: block;">    
                                <h6 class="tab-content-title-bulanan text-center font-weight-bold"></h6>
                            </div>

                            <div id="statistik-rekap-bulanan"></div>
                        </div>
                        <div class="tab-pane fade" id="tab-data-tahun" role="tabpanel" aria-labelledby="tab-data-tahun">
                            <div class="form-group row">
                                <div class="input-group mb-3 col-lg-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-md date" name="date-tahunan" id="date-tahunan" placeholder="Masukkan Tahun" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <div class="btn-group-tahunan" style="display: none;">
                                        <button class="btn btn-white">Export</button>
                                        <button class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(93px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" id="download-tahunan-pdf">
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

                            <div class="tab-content-header my-3" style="display: block;">    
                                <h6 class="tab-content-title-tahunan text-center font-weight-bold"></h6>
                            </div>

                            <div id="statistik-rekap-tahunan"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- script internal -->
<script type="text/javascript">
    const auth_insert = '<?= $rules->i ?>';
    const auth_edit = '<?= $rules->e ?>';
    const auth_delete = '<?= $rules->d ?>';
    const auth_otorisasi = '<?= $rules->o ?>';

    const base_url = '<?= base_url() ?>';
    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';
    const url_pdf_harian = '<?= base_url() . "/" . uri_segment(0) . "/pdf/exportTrxPerJenisHarian" . "" ?>';
    const url_pdf_bulanan = '<?= base_url() . "/" . uri_segment(0) . "/pdf/exportTrxPerJenisBulanan" . "" ?>';
    const url_pdf_tahunan = '<?= base_url() . "/" . uri_segment(0) . "/pdf/exportTrxPerJenisTahunan" . "" ?>';

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

        coreEvents.datepicker('#date-harian', 'yyyy-mm-dd')

        $('#download-harian-pdf').on('click', function(e) {
            let dateHarian = $('#date-harian').val()

            $(this).attr("href", url_pdf_harian + '?date=' + dateHarian + '');
            $(this).attr("target", "_blank");
        });

        coreEvents.datepickermonthly('#date-bulanan', 'yyyy-mm')

        $('#download-bulanan-pdf').on('click', function(e) {
            let dateBulanan = $('#date-bulanan').val()

            $(this).attr("href", url_pdf_bulanan + '?date=' + dateBulanan + '');
            $(this).attr("target", "_blank");
        });

        coreEvents.datepickeryears('#date-tahunan', 'yyyy')

        $('#download-tahunan-pdf').on('click', function(e) {
            let dateTahunan = $('#date-tahunan').val()

            $(this).attr("href", url_pdf_tahunan + '?date=' + dateTahunan + '');
            $(this).attr("target", "_blank");
        });

    });

    $('#date-harian').on('change', function() {
        let date = $(this).val()

        loaderStart()

        $.ajax({
            method: "post",
            dataType : "json",
            url: url_ajax + "/getTrxPerJenisHarian",
            data:{
                <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                "date": date,
                
            },
            success : function (rs) {

                if(rs.success){
                    $('#statistik-rekap-harian').html('')

                    $('.btn-group-harian').css('display', 'block')

                    let explodeDateHarian = date.split('-');

                    $(".tab-content-title-harian").text("")

                    $(".tab-content-title-harian").text(`REKAP LAPORAN TRANSAKSI PER JENIS PERIODE ${explodeDateHarian[2]} ${getMonth(explodeDateHarian[1])} ${explodeDateHarian[0]}`)

                    let result = `
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="">
                            <thead>
                                <tr class="border-dark" style="border:1px solid #555255">
                                    <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Jenis Transaksi</th>
                                    <th colspan="${rs.data.total_per_date.length}" class="text-center border-dark" style="border:1px solid #555255">Jam</th>
                                    <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Total Trans</th>
                                    <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Total Rupiah</th>
                                </tr>
                                <tr>
                    `

                    $.each(rs.data.total_per_date, function(i, val){
                        result += `
                            <th class="text-center border-dark" style="border:1px solid #555255">${i}</th>
                        `
                    })

                    result += `
                                </tr>
                            </thead>
                            <tbody>
                    `

                    $.each(rs.data.jenis, function(i, val){
                        result += `
                                <tr class="border-dark" style="border:1px solid #555255">
                                    <th class="text-center border-dark" style="border:1px solid #555255">${val.jenis}</th>
                        `

                        
                        let ttl_trx = 0;
                        let jml_trx = 0;
                        for (let n = 0; n < rs.data.total_per_date.length; n++) {
                            result += `
                                <th class="text-center border-dark" style="border:1px solid #555255">${rs.data.result['ttl_trx'][val.jenis] ? (rs.data.result['ttl_trx'][val.jenis][n] ? rs.data.result['ttl_trx'][val.jenis][n] : 0) : 0 }</th>
                            `

                            ttl_trx += parseInt(rs.data.result['ttl_trx'][val.jenis] ? (rs.data.result['ttl_trx'][val.jenis][n] ? rs.data.result['ttl_trx'][val.jenis][n] : 0) : 0)
                            jml_trx += parseInt(rs.data.result['jml_trx'][val.jenis] ? (rs.data.result['jml_trx'][val.jenis][n] ? rs.data.result['jml_trx'][val.jenis][n] : 0) : 0)
                        }

                        result += `
                                    <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(ttl_trx)}</th>
                                    <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(jml_trx)}</th>
                                </tr>
                            `
                    })

                    result += `
                                    </tbody>
                                <tfoot>
                            <th class="text-center border-dark" style="border:1px solid #555255">Total</th>
                    `

                    for (let n = 0; n < rs.data.total_per_date.length; n++) {
                        result += `
                            <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(rs.data.total_per_date[n])}</th>
                        `
                    }

                    result += `
                                    <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(rs.data.ttl_trx)}</th>
                                    <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(rs.data.jml_trx)}</th>
                                </tfoot>
                            </table>
                        </div>
                    `

                    $('#statistik-rekap-harian').append(result)

                    loaderEnd()
                }
            }
        })
    })

    $('#date-bulanan').on('change', function() {
        let date = $(this).val()

        loaderStart()

        $.ajax({
            method: "post",
            dataType : "json",
            url: url_ajax + "/getTrxPerjenisBulan",
            data:{
                <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                "date": date,
                
            },
            success : function (rs) {

                if(rs.success){
                    $('#statistik-rekap-bulanan').html('')

                    $('.btn-group-bulanan').css('display', 'block')

                    let explodeDateBulanan = date.split('-');

                    $(".tab-content-title-bulanan").text("")

                    $(".tab-content-title-bulanan").text(`REKAP LAPORAN TRANSAKSI PER JENIS PERIODE ${getMonth(explodeDateBulanan[1])} ${explodeDateBulanan[0]}`)

                    let result = `
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="">
                            <thead>
                                <tr class="border-dark" style="border:1px solid #555255">
                                    <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Jenis Transaksi</th>
                                    <th colspan="${objSize(rs.data.total_per_date)}" class="text-center border-dark" style="border:1px solid #555255">Tanggal</th>
                                    <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Total Trans</th>
                                    <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Total Rupiah</th>
                                </tr>
                                <tr>
                    `

                    $.each(rs.data.total_per_date, function(i, val){
                        if(i != 0) {
                            result += `
                                <th class="text-center border-dark" style="border:1px solid #555255">${i}</th>
                            `
                        }
                    })

                    result += `
                                </tr>
                            </thead>
                            <tbody>
                    `

                    $.each(rs.data.jenis, function(i, val){
                        result += `
                            <tr class="border-dark" style="border:1px solid #555255">
                                <th class="text-center border-dark" style="border:1px solid #555255">${val.jenis}</th>
                        `

                        
                        let ttl_trx = 0;
                        let jml_trx = 0;
                        for (let n = 1; n <= objSize(rs.data.total_per_date); n++) {
                            result += `
                                <th class="text-center border-dark" style="border:1px solid #555255">${rs.data.result['ttl_trx'][val.jenis] ? (rs.data.result['ttl_trx'][val.jenis][n] ? rs.data.result['ttl_trx'][val.jenis][n] : 0) : 0 }</th>
                            `

                            ttl_trx += parseInt(rs.data.result['ttl_trx'][val.jenis] ? (rs.data.result['ttl_trx'][val.jenis][n] ? rs.data.result['ttl_trx'][val.jenis][n] : 0) : 0)
                            jml_trx += parseInt(rs.data.result['jml_trx'][val.jenis] ? (rs.data.result['jml_trx'][val.jenis][n] ? rs.data.result['jml_trx'][val.jenis][n] : 0) : 0)
                        }

                        result += `
                                    <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(ttl_trx)}</th>
                                    <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(jml_trx)}</th>
                                </tr>
                            `
                    })

                    result += `
                                    </tbody>
                                <tfoot>
                            <th class="text-center border-dark" style="border:1px solid #555255">Total</th>
                    `

                    for (let n = 1; n <= objSize(rs.data.total_per_date); n++) {
                            result += `
                                <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(rs.data.total_per_date[n])}</th>
                            `
                    }

                    result += `
                                    <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(rs.data.ttl_trx)}</th>
                                    <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(rs.data.jml_trx)}</th>
                                </tfoot>
                            </table>
                        </div>
                    `

                    $('#statistik-rekap-bulanan').append(result)

                    loaderEnd()
                }
            }
        })
    })

    $('#date-tahunan').on('change', function() {
        let date = $(this).val()

        loaderStart()

        $.ajax({
            method: "post",
            dataType : "json",
            url: url_ajax + "/getTrxPerjenisTahun",
            data:{
                <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                "date": date,
                
            },
            success : function (rs) {

                if(rs.success){
                    $('#statistik-rekap-tahunan').html('')

                    $('.btn-group-tahunan').css('display', 'block')

                    let explodeDateTahunan = date.split('-');

                    $(".tab-content-title-tahunan").text("")

                    $(".tab-content-title-tahunan").text(`REKAP LAPORAN TRANSAKSI PER JENIS PERIODE ${explodeDateTahunan[0]}`)

                    let result = `
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="">
                            <thead>
                                <tr class="border-dark" style="border:1px solid #555255">
                                    <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Jenis Transaksi</th>
                                    <th colspan="12" class="text-center border-dark" style="border:1px solid #555255">Bulan</th>
                                    <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Total Trans</th>
                                    <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Total Rupiah</th>
                                </tr>
                                <tr>
                    `

                    $.each(rs.data.total_per_date, function(i, val){
                        if(i != 0) {
                            result += `
                                <th class="text-center border-dark" style="border:1px solid #555255">${i}</th>
                            `
                        }
                    })

                    result += `
                                </tr>
                            </thead>
                            <tbody>
                    `

                    $.each(rs.data.jenis, function(i, val) {
                        result += `
                            <tr class="border-dark" style="border:1px solid #555255">
                                <th class="text-center border-dark" style="border:1px solid #555255">${val.jenis}</th>
                        `

                        
                        let ttl_trx = 0;
                        let jml_trx = 0;
                        for (let n = 1; n <= rs.data.total_per_date.length - 1; n++) {
                            result += `
                                <th class="text-center border-dark" style="border:1px solid #555255">${rs.data.result['ttl_trx'][val.jenis] ? (rs.data.result['ttl_trx'][val.jenis][n] ? rs.data.result['ttl_trx'][val.jenis][n] : 0) : 0 }</th>
                            `

                            ttl_trx += parseInt(rs.data.result['ttl_trx'][val.jenis] ? (rs.data.result['ttl_trx'][val.jenis][n] ? rs.data.result['ttl_trx'][val.jenis][n] : 0) : 0)
                            jml_trx += parseInt(rs.data.result['jml_trx'][val.jenis] ? (rs.data.result['jml_trx'][val.jenis][n] ? rs.data.result['jml_trx'][val.jenis][n] : 0) : 0)
                        }

                        result += `
                                    <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(ttl_trx)}</th>
                                    <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(jml_trx)}</th>
                                </tr>
                            `
                    })

                    result += `
                                    </tbody>
                                <tfoot>
                            <th class="text-center border-dark" style="border:1px solid #555255">Total</th>
                    `

                    for (let n = 1; n <= rs.data.total_per_date.length -1; n++) {
                        result += `
                            <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(rs.data.total_per_date[n])}</th>
                        `
                    }

                    result += `
                                    <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(rs.data.ttl_trx)}</th>
                                    <th class="text-center border-dark" style="border:1px solid #555255">${numberWithCommas(rs.data.jml_trx)}</th>
                                </tfoot>
                            </table>
                        </div>
                    `

                    $('#statistik-rekap-tahunan').append(result)

                    loaderEnd()
                }
            }
        })
    })

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

    var objSize = function(obj) {
        var count = 0;
        
        if (typeof obj == "object") {
        
            if (Object.keys) {
                count = Object.keys(obj).length;
            } else if (window._) {
                count = _.keys(obj).length;
            } else if (window.$) {
                count = $.map(obj, function() { return 1; }).length;
            } else {
                for (var key in obj) if (obj.hasOwnProperty(key)) count++;
            }
            
        }
        
        return count;
    };

    function getMonth(month) { 
        let result
        if(month == 01) {
            result = "JANUARI"
        } else if(month == 02) {
            result = "FEBRUARI"
        } else if(month == 03) {
            result = "MARET"
        } else if(month == 04) {
            result = "APRIL"
        } else if(month == 05) {
            result = "MEI"
        } else if(month == 06) {
            result = "JUNI"
        } else if(month == 07) {
            result = "JULI"
        } else if(month == 08) {
            result = "AGUSTUS"
        } else if(month == 09) {
            result = "SEPTEMBER"
        } else if(month == 10) {
            result = "OKTOBER"
        } else if(month == 11) {
            result = "NOVEMBER"
        } else {
            result = "DESEMBER"
        }

        return result
    }

</script>

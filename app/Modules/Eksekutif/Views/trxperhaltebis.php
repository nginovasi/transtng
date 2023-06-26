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

                            <div class="tab-content-header my-3" style="display: block;">    
                                <h6 class="tab-content-title text-center font-weight-bold"></h6>
                            </div>

                            <div id="statistik-rekap"></div>
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
    const url_pdf = '<?= base_url() . "/" . uri_segment(0) . "/pdf/exportTrxPerHalteBisHarian" . "" ?>';

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

        coreEvents.datepicker('#date', 'yyyy-mm-dd')

        $('#download-pdf').on('click', function(e) {
            let date = $('#date').val()

            $(this).attr("href", url_pdf + '?date=' + date + '');
            $(this).attr("target", "_blank");
        });

    });

    $('#date').on('change', function() {
        let date = $(this).val()

        loaderStart()

        $.ajax({
            method: "post",
            dataType : "json",
            url: url_ajax + "/getTransaksiPerHalteBisHarian",
            data:{
                <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                "date": date,
                
            },
            success : function (rs) {

                if(rs.success){
                    $('#statistik-rekap').html('')

                    $('.btn-group').css('display', 'block')

                    let explodeDateHarian = date.split('-');

                    $(".tab-content-title").text("")

                    $(".tab-content-title").text(`REKAP LAPORAN TRANSAKSI PER JENIS PERIODE ${explodeDateHarian[2]} ${getMonth(explodeDateHarian[1])} ${explodeDateHarian[0]}`)

                    let result = `
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="">
                                <thead>
                                    <tr class="border-dark" style="border:1px solid #555255">
                                        <th class="text-center border-dark" style="border:1px solid #555255">No</th>
                                        <th class="text-center border-dark" style="border:1px solid #555255">Halte/Bis</th>
                                        <th class="text-center border-dark" style="border:1px solid #555255">Shift</th>
                                        <th class="text-center border-dark" style="border:1px solid #555255">Imei</th>
                                        <th class="text-center border-dark" style="border:1px solid #555255">Jalur</th>
                                        <th class="text-center border-dark" style="border:1px solid #555255">Cash</th>
                                        <th class="text-center border-dark" style="border:1px solid #555255">Cashless</th>
                                        <th class="text-center border-dark" style="border:1px solid #555255">Total Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `

                    let cash = 0
                    let isCashless = 0
                    let ttl = 0
                    $.each(rs.data.result, function(i, val) {
                        result += `
                            <tr class="border-dark" style="border:1px solid #555255">
                                <td class="text-center border-dark" style="border:1px solid #555255">${i + 1}</td>
                                <td class="text-center border-dark" style="border:1px solid #555255">${val.haltebis}</td>
                                <td class="text-center border-dark" style="border:1px solid #555255">${val.shift}</td>
                                <td class="text-center border-dark" style="border:1px solid #555255">${val.device_id}</td>
                                <td class="text-center border-dark" style="border:1px solid #555255">${val.jalur}</td>
                                <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(val.cash)}</td>
                                <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(val.is_cashless)}</td>
                                <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(val.ttl)}</td>
                            </tr>
                        `

                        cash += parseInt(val.cash)
                        isCashless += parseInt(val.is_cashless)
                        ttl += parseInt(val.ttl)
                    })

                    result += `</tbody>
                                <tfoot>
                                    <td colspan="5" class="text-right font-weight-bold border-dark" style="border:1px solid #555255">Total</td>
                                    <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(cash)}</td>
                                    <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(isCashless)}</td>
                                    <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(ttl)}</td>
                                </tfoot>
                            </table>
                        </div>
                    `

                    $('#statistik-rekap').append(result)

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

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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="true"><i class="fa fa-calendar" aria-hidden="true"></i> Laporan Rekonsiliasi</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="form-group row">
                                <div class="input-group mb-3 col-md-4">
                                    <select class="custom-select select2" name="bank_id" id="bank_id" required></select>
                                </div>
                                <div class="input-group mb-3 col-lg-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-md date" name="date" id="date" placeholder="Masukkan Bulan" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="input-group mb-3 col-md-2">
                                    <button type="submit" class="btn btn-success" id="process" style="display: none">Lihat Transaksi</button>
                                </div>
                                <div class="mb-2 col-md-2">
                                    <div class="btn-group-export" style="display: none;">
                                        <button class="btn btn-white">Export</button>
                                        <button class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(93px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" id="download-data-pdf">
                                                PDF
                                            </a>    
                                            <!-- <a class="dropdown-item">
                                                Excel
                                            </a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-content-header my-3" style="display: block;">    
                                <h6 class="tab-content-title text-center font-weight-bold"></h6>
                            </div>

                            <div class="tab-content-body" style="display: block;">        
                            </div>
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
    const url_pdf = '<?= base_url() . "/" . uri_segment(0) . "/pdf/exportLapRekon" . "" ?>';

    let dataStart = 0;
    let coreEvents;

    // init select2
    const select2Array = [
        {
            id: 'bank_id',
            url: '/bank_id_select_get',
            placeholder: 'Pilih Bank',
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
            coreEvents.select2Init('#' + x.id, x.url, x.placeholder, x.params);
        });

        coreEvents.datepickermonthly('#date', 'yyyy-mm')

        $('#download-data-pdf').on('click', function(e) {
            let date = $('#date').val()
            let bank = $('#bank_id').find(":selected").text()

            $(this).attr("href", url_pdf + bank + '?date=' + date + '-01' + '&bank=' + bank);
            $(this).attr("target", "_blank");
        });

        // coreEvents.load(null, [0, 'asc'], null);

    });

    $(document)
    .on("change", "#bank_id", function() {
        if($("#date-laprekon").val()) {
            $("#process").css("display", "block")
        }
    })
    .on("change", "#date", function() {
        if($("#bank_id").val()) {
            $("#process").css("display", "block")
        }
    })
    .on("click", "#process", function() {
        if($("#bank_id").val() && $("#date").val()) {
            let bank = $('#bank_id').find(":selected").text()
            let date = $("#date").val() + '-' + "01"

            loadLapRekon(date, bank)
        }
    })

    function loadLapRekon(date, bank){
        loaderStart()

        let dateExplode = date.split('-')

        let bankAlias
        switch(bank) {
            case "BCA":
                bankAlias = "FLAZZ"
                break;
            case "BNI":
                bankAlias = "TAPCASH"
                break;
            case "BRI":
                bankAlias = "BRIZZI"
                break;
            case "Mandiri":
                bankAlias = "E-MONEY"
                break;
            default:
                bankAlias = "SERVER ERROR"
        }

        $.ajax({
            url : url + "_load_" + bank + "LapRekon",
            method: 'post',
            dataType : 'json',
            data : {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                date: date
            },
            success : function (rs) {
                if(rs.success == true) {
                    loaderEnd()

                    $('.btn-group-export').css('display', 'block')

                    $(".tab-content-body").html("")
                    $(".tab-content-title").text("")

                    $(".tab-content-title").text(`REKAP LAPORAN TRANSAKSI ${bankAlias} PERIODE ${getMonth(dateExplode[1])} ${dateExplode[0]}`)

                    let result = `<div class="table-responsive">
                                        <table class="table" id="exceltable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Tanggal Transaksi</th>
                                                    <th scope="col">Tanggal Pembayaran</th>
                                                    <th scope="col">Jumlah Transaksi</th>
                                                    <th scope="col">Nominal Transaksi</th>
                                                    <th scope="col">Nominal Dibayarkan</th>
                                                    <th scope="col">Selisih</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody">`

                    $.each(rs.data.result, function(i, val) {
                        result += `
                                <tr>
                                    <th scope="row" class="text-center">${i + 1}</th>
                                    <td class="text-center">${val['date_trx']}</td>
                                    <td class="text-center">${val['date_paid'] ? val['date_paid'] : '-'}</td>
                                    <td class="text-right">${val['ttl_trx'] ?  numberWithCommas(val['ttl_trx']) : numberWithCommas(0) }</td>
                                    <td class="text-right">${val['jml_trx'] ? numberWithCommas(val['jml_trx']) : numberWithCommas(0)}</td>
                                    <td class="text-right">${val['jml_trx_paid'] ? numberWithCommas(val['jml_trx_paid']) : numberWithCommas(0)}</td>
                                `

                        if(val['difference_trx'] > 0) {
                            result += `<td class="text-right text-success">${val['difference_trx'] ? '+' + numberWithCommas(val['difference_trx']) : numberWithCommas(0)}</td>`
                        } else if(val['difference_trx'] < 0) {
                            result += `<td class="text-right text-danger">${val['difference_trx'] ? '-' + numberWithCommas(val['difference_trx']) : numberWithCommas(0)}</td>`
                        } else {
                            result += `<td class="text-right">${val['difference_trx'] ? numberWithCommas(val['difference_trx']) : numberWithCommas(0)}</td>`
                        }

                        result += `</tr>`
                    })             

                    result += `
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right font-weight-bold">Total</td>
                                    <td class="text-right font-weight-bold">${numberWithCommas(rs.data.ttl_trx)}</td>
                                    <td class="text-right font-weight-bold">${numberWithCommas(rs.data.jml_trx)}</td>
                                    <td class="text-right font-weight-bold">${numberWithCommas(rs.data.jml_trx_paid)}</td>
                                    <td class="text-right font-weight-bold">${numberWithCommas(rs.data.difference_trx)}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>`

                    $(".tab-content-body").append(result)
                } else {
                    swal.close();

                    Swal.fire('Error','Terjadi kesalahan pada server', 'error');
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

    function errorServer() {
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan template',
            text: 'Silahkan hub customer service!'
        })
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

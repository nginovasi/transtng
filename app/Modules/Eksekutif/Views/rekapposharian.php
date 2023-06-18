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
                                <div class="input-group mb-3 col-md-3">
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

                            <hr>

                            <div id="statistik-rekap-data"></div>
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
    const url_pdf_jalur = '<?= base_url() . "/" . uri_segment(0) . "/pdf/exportTrxPerPos" . "" ?>';

    var dataStart = 0;
    var coreEvents;

    // init select2
    const select2Array = [];

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
        
        // coreEvents.load(null, [0, 'asc'], null);

        coreEvents.daterangepicker('#date', 'yyyy-mm-dd')

        $('#download-data-pdf').on('click', function(e) {
            let date = $('#date').val()

            $(this).attr("href", url_pdf_jalur + '?date=' + date);
            $(this).attr("target", "_blank");
        });

    });

    $('#btn-transaction').on('click', function() {
        let date = $('#date').val()

        $.ajax({
            method: "post",
            dataType : "json",
            url: url_ajax + "/getTrxPerPos",
            data:{
                <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                "date": date
            },
            success : function (rs) {

                console.info(rs)

                if(rs.success){
                    $('#statistik-rekap-data').html('')

                    $('.btn-group-export').css('display', 'block')

                    let result = `
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="">
                                <thead>
                                    <tr class="border-dark" style="border:1px solid #555255">
                                        <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">No</th>
                                        <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">POS</th>
                                        <th colspan="3" class="text-center border-dark" style="border:1px solid #555255">Shift Pagi</th>
                                        <th colspan="3" class="text-center border-dark" style="border:1px solid #555255">Shift Malam</th>
                                        <th rowspan="2" class="text-center border-dark" style="border:1px solid #555255">Jumlah</th>
                                    </tr>
                                    <tr class="border-dark" style="border:1px solid #555255">
                                        <th class="text-center border-dark" style="border:1px solid #555255">Cash</th>
                                        <th class="text-center border-dark" style="border:1px solid #555255">Cashless</th>
                                        <th class="text-center border-dark" style="border:1px solid #555255">Jumlah</th>
                                        <th class="text-center border-dark" style="border:1px solid #555255">Cash</th>
                                        <th class="text-center border-dark" style="border:1px solid #555255">Cashless</th>
                                        <th class="text-center border-dark" style="border:1px solid #555255">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `

                    let ttlTrxCashShiftPagi = 0
                    let ttlTrxCashlessShiftPagi = 0
                    let ttlTrxJmlShiftPagi = 0
                    let ttlTrxCashShiftMalam = 0
                    let ttlTrxCashlessShiftMalam = 0
                    let ttlTrxJmlShiftMalam = 0
                    let ttlTrxJml = 0
                    $.each(rs.data.result, function(i, val) {
                        result += `
                            <tr class="border-dark" style="border:1px solid #555255">
                                <td class="text-center border-dark" style="border:1px solid #555255">${i + 1}</td>
                                <td class="text-center border-dark" style="border:1px solid #555255">${val.name}</td>
                                <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(val.cash_shift_pagi)}</td>
                                <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(val.cashless_shift_pagi)}</td>
                                <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(val.jml_shift_pagi)}</td>
                                <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(val.cash_shift_malam)}</td>
                                <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(val.cashless_shift_malam)}</td>
                                <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(val.jml_shift_malam)}</td>
                                <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(val.jml)}</td>
                            </tr>
                        `

                        ttlTrxCashShiftPagi += parseInt(val.cash_shift_pagi)
                        ttlTrxCashlessShiftPagi += parseInt(val.cashless_shift_pagi)
                        ttlTrxJmlShiftPagi += parseInt(val.jml_shift_pagi)
                        ttlTrxCashShiftMalam += parseInt(val.cash_shift_malam)
                        ttlTrxCashlessShiftMalam += parseInt(val.cashless_shift_malam)
                        ttlTrxJmlShiftMalam += parseInt(val.jml_shift_malam)
                        ttlTrxJml += parseInt(val.jml)

                    })

                    result += `</tbody>
                                <tfoot>
                                    <td colspan="2" class="text-right font-weight-bold border-dark" style="border:1px solid #555255">Total</td>
                                    <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(ttlTrxCashShiftPagi)}</td>
                                    <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(ttlTrxCashlessShiftPagi)}</td>
                                    <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(ttlTrxJmlShiftPagi)}</td>
                                    <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(ttlTrxCashShiftMalam)}</td>
                                    <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(ttlTrxCashlessShiftMalam)}</td>
                                    <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(ttlTrxJmlShiftMalam)}</td>
                                    <td class="text-right border-dark" style="border:1px solid #555255">${numberWithCommas(ttlTrxJml)}</td>
                                </tfoot>
                            </table>
                        </div>
                    `

                    $('#statistik-rekap-data').append(result)

                }

            }
        })
    })

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

</script>
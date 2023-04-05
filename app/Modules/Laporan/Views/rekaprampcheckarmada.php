<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
.select2-container {
    width: 100% !important;
}

#reportrange {
    background: #fff;
    cursor: pointer;
    padding: 5px 10px;
    border: 1px solid #ccc;
    width: 100%;
}
</style>
<div>
    <div class="page-hero page-container " id="page-hero">
        <div class="padding d-flex">
            <div class="page-title">
                <h2 class="text-md text-highlight"><?= $page_title ?></h2>
            </div>
            <div class="flex"></div>
        </div>
    </div>
    <div class="page-content page-container" id="page-content">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills no-border" id="tab">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab"
                            aria-controls="tab-data" aria-selected="false">Laporan Rekap Rampcheck</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>BPTD</label>
                                    <select class="form-control select2Bptd" id="bptd" name="bptd" required></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal Rampcheck</label>
                                    <!-- daterangepicker -->
                                    <input type="text" class="form-control" id="reportrange" name="reportrange"
                                        value="" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Download Laporan</label>
                                <select class="form-control select2Download" id="downloadType"
                                    name="downloadType"></select>
                            </div>
                            <!-- add clear button -->
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary btn-block mt-4 resetFilter"
                                    id="resetFilter">Clear</button>
                            </div>
                        </div>
                        <table class="table table-theme table-row v-middle" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>BPTD</th>
                                    <th>Nomor Kendaraan</th>
                                    <th>Nomor Rampcheck</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Jenis Lokasi</th>
                                    <th>Nama Lokasi</th>
                                    <th>Nama PO</th>
                                    <th>Nomor STUK</th>
                                    <th>Jenis Angkutan</th>
                                    <th>Trayek</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const url_ajax = '<?=base_url() . "/" . uri_segment(0) . "/ajax"?>';

// document ready function
$(document).ready(function() {
    $('.select2Bptd').select2({
        placeholder: 'Pilih BPTD',
        ajax: {
            url: url_ajax + '/getBptd',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('.select2Download').select2({
        placeholder: 'Pilih Jenis Download',
        data: [{
            id: '',
            text: 'Pilih Jenis Download'
        },
        {
                id: 'rampPerArmada',
                text: 'Rekap Rampcheck Per Armada'
            },
            {
                id: 'rampDetail',
                text: 'Rekap Rampcheck Detail'
            }
        ],
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust()
    });

    $('#bptd').on('select2:select', function(e) {
        var data = e.params.data;
        var bptd = data.id;
        $('#reportrange').val('Pilih Tanggal');
        table.ajax.url(url_ajax + "/ajaxLoadDataRekapRampcheck?bptd=" + bptd).load();
    });

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        var bptd = $('#bptd').val();
        table.ajax.url(url_ajax + "/ajaxLoadDataRekapRampcheck?startDate=" + startDate + "&endDate=" + endDate +
            "&bptd=" + bptd).load();
    });

    $('.resetFilter').on('click', function() {
        $('#bptd').val(null).trigger('change');
        $('#reportrange').val('Pilih Tanggal');
        $('#downloadType').val(null).trigger('change');
        table.ajax.url(url_ajax + "/ajaxLoadDataRekapRampcheck").load();
    });

    var table = $('#datatable').DataTable({
        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],
        pageLength: 10,
        bProcessing: true,
        serverSide: true,
        scrollY: "500px",
        scrollX: true,
        responsive: true,
        scrollCollapse: true,
        ajax: {
            url: url_ajax + "/ajaxLoadDataRekapRampcheck",
            type: "post",
            data: {
                "<?=csrf_token()?>": "<?=csrf_hash()?>",
            }
        },
        columns: [

            {
                "data": null,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: "rampcheck_bptd",
                width: "250px"
            },
            {
                data: "rampcheck_noken",
                width: "100px"
            },
            {
                data: "rampcheck_no",
                width: "200px"
            },
            {
                data: "rampcheck_kesimpulan_status",
                render: function(data, type, row, meta) {
                    if (data === "0") {
                        return '<div class="alert alert-success" role="alert">Diijinkan Operasional</div>';
                    }
                    if (data === "1") {
                        return '<div class="alert alert-success" role="alert">Peringatan/Perbaiki</div>';
                    }
                    if (data === "2") {
                        return '<div class="alert alert-danger" role="alert">Tilang dan Dilarang Operasional</div>';
                    }
                    if (data === "3") {
                        return '<div class="alert alert-danger" role="alert">Dilarang Operasional</div>';
                    }
                },
                width: "250px"
            },
            {
                data: "rampcheck_date",
                width: "150px"
            },
            {
                data: "jenis_lokasi_name",
                width: "100px"
            },
            {
                data: "terminal_name",
                width: "300px"
            },
            {
                data: "rampcheck_po_name",
                width: "200px"
            },
            {
                data: "rampcheck_stuk"
            },
            {
                data: "jenis_angkutan_name"
            },
            {
                data: "trayek_name",
                width: "300px"
            }
        ],
        columnDefs: [{
            searchable: true,
            orderable: true,
            sortable: true,
            targets: 0
        }],
        fixedColumns: true,
        bFilter: true,
    });

    $('#downloadType').on('select2:select', function(e) {
        var data = e.params.data;
        var downloadType = data.id;
        var bptd = $('#bptd').val();
        
        // get reportrange value
        var startDate = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
        var endDate = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');

        if (startDate === 'Invalid date') {
            startDate = '';
        } else {
            startDate = startDate;
        }

        if (endDate === 'Invalid date') {
            endDate = '';
        } else {
            endDate = endDate;
        }

        if (downloadType === 'rampPerArmada') {
            window.location.href = url_ajax + "/downloadRekapRampcheckPerArmada?bptd=" + bptd + "&startDate=" + startDate + "&endDate=" + endDate;
        }
        if (downloadType === 'rampDetail') {
            window.location.href = url_ajax + "/downloadRekapRampcheckDetail?bptd=" + bptd + "&startDate=" + startDate + "&endDate=" + endDate;
        }
    });

});

$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                .endOf('month')
            ]
        }
    }, cb);

    cb(start, end);

    $('#reportrange').val('Pilih Tanggal');

});
</script>

<!-- style internal -->
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<div>
    <div class="page-hero page-container" id="page-hero">
        <div class="padding d-flex">
            <div class="page-title">
                <h2 class="text-md text-highlight">
                    <?= $page_title ?> Berdasarkan Jadwal/Armada Mudik
                </h2>
            </div>
            <div class="flex"></div>
        </div>
    </div>
    <div class="page-content page-container" id="page-content">
        <div class="card">
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Unduh Semua Data</span>
                                </div>
                                <select class="custom-select" id="unduhSemuaArus">
                                    <option selected disabled>Arus Mudik/Balik</option>
                                    <option value="mudik">Penumpang Arus Mudik</option>
                                    <option value="balik">Penumpang Arus Balik</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Unduh</button>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(379px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item" id="dnSemuaArusExcel" href="#"><i class="fa fa-file-excel-o"></i> Unduh XLS</a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="datatable" class="table table-theme table-row v-middle dataTable no-footer" role="grid" aria-describedby="datatable_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="No">
                                                            <span class="text-muted">No</span>
                                                        </th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Nama Armada">
                                                            <span class="text-muted">Nama Armada</span>
                                                        </th>
                                                        <th class="sorting_disabled" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Kode Armada">
                                                            <span class="text-muted">Kode Armada</span>
                                                        </th>
                                                        <th class="sorting" rowspan="1" colspan="1" aria-label="Jadwal Berangkat">
                                                            <span class="text-muted d-none d-sm-block">Jadwal Berangkat</span>
                                                        </th>
                                                        <th class="sorting" rowspan="1" colspan="1" aria-label="Jadwal Pulang">
                                                            <span class="text-muted d-none d-sm-block">Jadwal Pulang</span>
                                                        </th>
                                                        <th class="sorting" rowspan="1" colspan="1" aria-label="Tipe Jadwal">
                                                            <span class="text-muted d-none d-sm-block">Tipe Jadwal</span>
                                                        </th>
                                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 16px;"></th>
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
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetail" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetail">Detail Penumpang dalam Jadwal dan Armada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dtableDetail" class="table table-theme table-row v-middle dataTable no-footer" role="grid" aria-describedby="datatable_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="No">
                                        <span class="text-muted">No</span>
                                    </th>
                                    <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Nama Penumpang">
                                        <span class="text-muted">Nama Penumpang</span>
                                    </th>
                                    <th class="sorting_disabled" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="NIK">
                                        <span class="text-muted">NIK</span>
                                    </th>
                                    <th class="sorting" rowspan="1" colspan="1" aria-label="Baris & Nomor bangku">
                                        <span class="text-muted d-none d-sm-block">Baris & Nomor Bangku</span>
                                    </th>
                                    <th class="sorting" rowspan="1" colspan="1" aria-label="Status">
                                        <span class="text-muted d-none d-sm-block">Status</span>
                                    </th>
                                    <th class="sorting" rowspan="1" colspan="1" aria-label="LOG">
                                        <span class="text-muted d-none d-sm-block">LOG</span>
                                    </th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Validator">
                                        <span class="text-muted d-none d-sm-block">Validator</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Download
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" id="btnDownloadPdfPnp"><i class="fa fa-file-pdf-o" style="color:red"></i> Download PDF</a>
                        <a class="dropdown-item" href="#" id="btnDownloadExcelPnp"><i class="fa fa-file-excel-o" style="color:green"></i> Download Excel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- script internal -->
<script type="text/javascript">
    // authorization
    const auth_insert = "<?= $rules->i ?>";
    const auth_edit = "<?= $rules->e ?>";
    const auth_delete = "<?= $rules->d ?>";
    const auth_otorisasi = "<?= $rules->o ?>";

    // url
    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';
    const url_pdf_pnp = '<?= base_url() . "/" . uri_segment(0) . "/action/pdfcekdatapnp/" . uri_segment(1) . "" ?>';
    const url_excel_pnp = '<?= base_url() . "/" . uri_segment(0) . "/action/excel/" . uri_segment(1) . "" ?>';

    var dataStart = 0;
    var coreEvents;

    $(document).ready(function() {
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
        };
        coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder: "",
            afterAction: function(result) {},
        };

        coreEvents.editHandler = {
            placeholder: "",
            afterAction: function(result) {},
        };

        coreEvents.deleteHandler = {
            placeholder: "",
            afterAction: function() {},
        };

        coreEvents.resetHandler = {
            action: function() {},
        };

        $('#modalDetail').on('hidden.bs.modal', function() {
            // coreEvents.table.ajax.reload();
            $('#dtableDetail').DataTable().destroy();
        });



        $('#unduhSemuaArus').on('change', function() {
            let id = $(this).val();
            if (id == 1) {
                $('#dnSemuaArusPdf').attr('href', url_pdf_pnp + "/p?o=l&search=" + btoa(id));
                $('#dnSemuaArusPdf').attr('target', '_blank');
                $('#dnSemuaArusExcel').attr('href', url_excel_pnp + "/p?jadwal_type=" + btoa(id));
                $('#dnSemuaArusExcel').attr('target', '_blank');
            } else {
                $('#dnSemuaArusPdf').attr('href', url_pdf_pnp + "/p?o=l&search=" + btoa(id));
                $('#dnSemuaArusPdf').attr('target', '_blank');
                $('#dnSemuaArusExcel').attr('href', url_excel_pnp + "/p?jadwal_type=" + btoa(id));
                $('#dnSemuaArusExcel').attr('target', '_blank');
            }
        });

        coreEvents.load();
    });

    function detailData(id, jadwal_type) {
        var btnpdf = $('#btnDownloadPdfPnp').attr('href', '#');
        var btnexcel = $('#btnDownloadExcelPnp').attr('href', '#');
        btnpdf = btnpdf.attr('href', url_pdf_pnp + "/p?o=l&search=" + id + "." + jadwal_type);
        btnpdf = btnpdf.attr('target', '_blank');
        btnexcel = btnexcel.attr('href', url_excel_pnp + "/p?jadwal_mudik_id=" + id + "&jadwal=" + jadwal_type);
        btnexcel = btnexcel.attr('target', '_blank');
        $('#dtableDetail').attr('width', '100%');
        $.ajax({
            url: url_ajax + "/bus_seats_get",
            type: "POST",
            data: {
                id: id,
                jadwal_type: jadwal_type,
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
            },
            dataType: "json",
            beforeSend: function() {
                Swal.fire({
                    title: 'Mohon tunggu...',
                    html: 'Proses sedang berlangsung',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    },
                });
            },
            success: function(result) {
                Swal.close();
                $('#dtableDetail').DataTable().destroy();
                if (result.success) {
                    var table = $('#dtableDetail').DataTable({
                        data: result.data,
                        columns: [{
                                data: 'id',
                                render: function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {
                                data: 'transaction_booking_name'
                            },
                            {
                                data: 'nik'
                            },
                            {
                                data: 'seat_group_baris',
                                render: function(data, type, row, meta) {
                                    return data + " (" + row.seat_map_detail_name + ")";
                                }
                            },
                            {
                                data: 'status_expired',
                                render: function(data, type, row, meta) {
                                    if (data == 1) {
                                        span = '<span class="badge badge-success">Tervalidasi</span>';
                                        // if (row.status_expired == 0) {
                                        //     span += '<br><span class="badge badge-success">Berlaku</span>';
                                        // } else {
                                        //     span += '<br><span class="badge badge-danger">Tidak Berlaku</span>';
                                        // }
                                    } else if (data == 0) {
                                        span = '<span class="badge badge-danger">Belum Tervalidasi</span>';
                                        if (row.status_expired == 0) {
                                            span += '<br><span class="badge badge-success">Berlaku</span>';
                                        } else {
                                            span += '<br><span class="badge badge-danger">Tidak Berlaku</span>';
                                        }
                                    } else {
                                        span = '';
                                    }
                                    return span;
                                }
                            },
                            {
                                data: 'verified_at'
                            },
                            {
                                data: 'user_web_name'
                            },
                        ],
                        "lengthMenu": [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, "All"]
                        ],
                        "columnDefs": [{
                                "targets": 1,
                                "className": "text-left"
                            },
                            {
                                "targets": 2,
                                "className": "text-left"
                            },
                            {
                                "targets": 3,
                                "className": "text-left"
                            },
                            {
                                "targets": 4,
                                "className": "text-center"
                            }
                        ],
                        "pageLength": 5,
                        "bLengthChange": true,
                        "bInfo": true,
                        "bFilter": false,
                        "bPaginate": true,
                    });
                } else {
                    $('#modalDetail').modal('hide');
                    Swal.fire({
                        title: "Peringatan",
                        text: result.message,
                        icon: "Warning",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK",
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: "Error",
                    text: "Terjadi kesalahan, silahkan coba lagi",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "OK",
                });
            }
        });
    }

    function datatableColumn() {
        let columns = [{
                data: "id",
                orderable: false,
                width: 100,
                render: function(a, type, data, index) {
                    return dataStart + index.row + 1
                }
            },
            {
                data: "armada_name",
                orderable: true,
            },
            {
                data: "armada_code",
                orderable: true
            },
            {
                data: "datetime_depart",
                orderable: true
            },
            {
                data: "datetime_arrived",
                orderable: true
            },
            {
                data: "jadwal_type",
                orderable: true,
                render: function(a, type, data, index) {
                    if (data.jadwal_type == "1") {
                        return "Arus Mudik";
                    } else {
                        return "Arus Balik";
                    }
                }
            },
            {
                data: "id",
                orderable: false,
                render: function(a, type, data, index) {
                    let button_item = ``;

                    if (auth_edit == "1") {
                        button_item += `<a class="dropdown-item" title="Detail" data-toggle="modal" data-target="#modalDetail" onclick="detailData('${btoa(data.id)}', '${btoa(data.jadwal_type)}')"><i class="fa fa-eye" style="color:blue"></i> See detail</a><div class="dropdown-divider"></div>`;
                    }

                    if (auth_edit == "1") {
                        button_item += `<a class="dropdown-item download" id="d-pdf" href="${url_pdf_pnp}/p?o=l&search=${btoa(data.id)}.${btoa(data.jadwal_type)}" target="_blank">
											<i class="fa fa-file-pdf-o" style="color:red"></i> Download PDF
										</a>`;
                    }

                    if (auth_edit == "1") {
                        button_item += `<a class="dropdown-item download" id="d-excel" href="${url_excel_pnp}/p?jadwal_mudik_id=${btoa(data.id)}&jadwal=${btoa(data.jadwal_type)}" target="_blank">
											<i class="fa fa-file-excel-o" style="color:green"></i> Download XLS
										</a>`;
                    }

                    let button = `<div class="item-action dropdown">
										<a href="#" data-toggle="dropdown" class="text-muted" title="Aksi">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
												<circle cx="12" cy="12" r="1"></circle>
												<circle cx="12" cy="5" r="1"></circle>
												<circle cx="12" cy="19" r="1"></circle>
											</svg>
										</a>
										<div class="dropdown-menu dropdown-menu-right bg-white text-dark" role="menu">
											${button_item}
										</div>
									</div>`;
                    button_item += (button_item == '') ? "<b>Tidak ada aksi</b>" : ""
                    return button;
                }
            }
        ];
        return columns;
    }
</script>
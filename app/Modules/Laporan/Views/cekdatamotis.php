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
                    <?= $page_title ?>
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
                                    <option selected disabled>Armada Motis Arus Mudik/Balik</option>
                                    <option value="mudik">Armada Motis Arus Mudik</option>
                                    <option value="balik">Armada Motis Arus Balik</option>
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
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="">Route</th>
                                                        <th class="text-center" style="width: 150px">Armada</th>
                                                        <th class="text-center">Jadwal Keberangkatan</th>
                                                        <th class="text-center">Jadwal Kedatangan</th>
                                                        <th class="text-center">Kuota Public</th>
                                                        <th class="text-center">Kuota Paguyuban</th>
                                                        <th class="text-center">Kuota Max</th>
                                                        <th class="">Tipe Jadwal</th>
                                                        <th class="text-center">Persentase</th>
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
                        <div id="accordionArmada" class="mb-4"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Download
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" id="btnDownloadPdfPnp"><i class="fa fa-file-pdf-o" style="color:red"></i> Download PDF</a>
                        <a class="dropdown-item" href="#" id="btnDownloadExcelPnp"><i class="fa fa-file-excel-o" style="color:green"></i> Download Excel</a>
                    </div>
                </div> -->
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
    const url_pdf_pnp = '<?= base_url() . "/" . uri_segment(0) . "/action/pdfcekdatamotis/" . uri_segment(1) . "" ?>';
    const url_excel_pnp = '<?= base_url() . "/" . uri_segment(0) . "/action/".uri_segment(1)."_excel/" . uri_segment(1) . "" ?>';

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

        // $('#modalDetail').on('hidden.bs.modal', function() {
        //     // coreEvents.table.ajax.reload();
        //     $('#dtableDetail').DataTable().destroy();
        // });

        $('#unduhSemuaArus').on('change', function() {
            let id = $(this).val();
            if (id == 1) {
                // $('#dnSemuaArusPdf').attr('href', url_pdf_pnp + "/p?o=l&search=" + btoa(id));
                // $('#dnSemuaArusPdf').attr('target', '_blank');
                $('#dnSemuaArusExcel').attr('href', url_excel_pnp + "/p?jadwal=" + btoa(id));
                $('#dnSemuaArusExcel').attr('target', '_blank');
            } else {
                // $('#dnSemuaArusPdf').attr('href', url_pdf_pnp + "/p?o=l&search=" + btoa(id));
                // $('#dnSemuaArusPdf').attr('target', '_blank');
                $('#dnSemuaArusExcel').attr('href', url_excel_pnp + "/p?jadwal=" + btoa(id));
                $('#dnSemuaArusExcel').attr('target', '_blank');
            }
        });

        coreEvents.load();
    });

    function detailData(id, jadwal_type) {
        var btnpdf = $('#btnDownloadPdfPnp').attr('href', '#');
        var btnexcel = $('#btnDownloadExcelPnp').attr('href', '#');
        $('#accordionArmada').html('');
        $('#dtableDetail').attr('width', '100%');
        $.ajax({
            url: url_ajax + "/get_armada_modal",
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
                if (result.success) {
                    var html = '';
                    var i = 0;
                    $.each(result.data, function(key, value) {
                        get_each_armada_detail(value.id);
                        html += '<div class="card mb-3">';
                        html += '<div class="card-body">';
                        html += '<h5 class="card-title">Rincian Armada ' + value.armada_name + '</h5>';
                        html += '<div class="btn-group pull-right">';
                        html += '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Download</button>';
                        html += '<div class="dropdown-menu">';
                        html += '<a class="dropdown-item" href="' + url_pdf_pnp + '/p?o=l&search=' + btoa(value.id) + '.' + btoa(value.jadwal_type) + '" id="btnDownloadPdfPnp" target="_blank"><i class="fa fa-file-pdf-o" style="color:red"></i> Download PDF</a>';
                        html += '<a class="dropdown-item" href="' + url_excel_pnp + '/p?jadwal_mudik_id=' + btoa(value.id) + '&jadwal=' + btoa(value.jadwal_type) + '" id="btnDownloadExcelPnp" target="_blank"><i class="fa fa-file-excel-o" style="color:green"></i> Download Excel</a>';
                        html += '</div></div>';
                        html += '<table class="table table-bordered table-striped table-hover" id="dtableDetail' + value.id + '">';
                        html += '<thead>';
                        html += '<tr>';
                        html += '<th>No</th>';
                        html += '<th>Nama Pendaftar</th>';
                        html += '<th>Jadwal Keberangkatan</th>';
                        html += '<th>Jadwal Kedatangan</th>';
                        html += '<th>Arus</th>';
                        html += '<th>Rute</th>';
                        html += '</tr>';
                        html += '</thead>';
                        html += '<tbody>';
                        html += '</tbody>';
                        html += '</table>';
                        html += '</div>';
                        html += '</div>';
                        i++;
                    });
                    $('#accordionArmada').append(html);
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

    function get_each_armada_detail(armada_id) {
        $.ajax({
            type: "POST",
            url: url_ajax + "/get_each_armada_detail",
            data: {
                id: armada_id,
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
            },
            dataType: "JSON",
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
            success: function(rs) {
                // console.log(rs);
                Swal.close();
                if (rs.success) {
                    var dataStart = 1;
                    $('#dtableDetail' + armada_id).DataTable().destroy();
                    var table = $('#dtableDetail' + armada_id).DataTable({
                        data: rs.data,
                        columns: [{
                                data: 'id',
                                render: function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {
                                data: 'user_mobile_name',
                                render: function(data, type, row, meta) {
                                    // uppercase
                                    var str = data;
                                    var res = str.toUpperCase();
                                    return res;
                                }
                            },
                            {
                                data: 'jadwal_datetime_depart'
                            },
                            {
                                data: 'jadwal_datetime_arrived'
                            },
                            {
                                data: 'jadwal_type',
                                render: function(data, type, row, meta) {
                                    if (data == '1') {
                                        return 'Mudik';
                                    } else {
                                        return 'Balik';
                                    }
                                }
                            },
                            {
                                data: 'route_name'
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
                        // "bLengthChange": true,
                        "bInfo": true,
                        "bFilter": false,
                        "bPaginate": true,
                    });
                } else {
                    $('#dtableDetail' + armada_id).html('');
                    $('#dtableDetail' + armada_id).html('<tr><td colspan="6" class="text-center"><i class="fa fa-exclamation-triangle"></i> Tidak ada data</td></tr>');
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
                data: "route_name",
                orderable: true,
            },
            {
                data: "armada",
                render: function(a, type, data, index) {
                    let button = `<ul>`
                    var map_detail = JSON.parse(data.armada)
                    for (i = 0; i < map_detail.length; i++) {
                        button += `<li><p style= width:150px>` + map_detail[i].armada_name + `</p></li>`
                    }
                    button += `</ul>`
                    return button;
                }
            },
            {
                data: 'jadwal_datetime_depart'
            },
            {
                data: 'jadwal_datetime_arrived'
            },
            {
                data: "quota_public",
                orderable: true
            },
            {
                data: "quota_paguyuban",
                orderable: true
            },
            {
                data: "quota_max",
                orderable: true
            },
            {
                data: "jadwal_type",
                orderable: true,
                render: function(a, type, data, index) {
                    if (data.jadwal_type == 1) {
                        return "Arus Mudik";
                    } else {
                        return "Arus Balik";
                    }
                }
            },
            {
                data: 'seat_filled',
                render: function(a, type, data, index) {
                    let button = ''

                    button += `<small>Status : 
                                    <strong class="text-primary">${data.percentage_fully}%</strong>
                                </small>
                                <div class="progress my-3 circle" style="height:6px;">
                                    <div class="progress-bar circle gd-primary" data-toggle="tooltip" title="${data.percentage_fully}%" style="width: ${data.percentage_fully}%"></div>
                                </div>`

                    return button;
                }
            },
            {
                data: "id",
                orderable: false,
                render: function(a, type, data, index) {
                    let button_item = ``;

                    if (auth_edit == "1") {
                        button_item += `<a class="dropdown-item" title="Detail" data-toggle="modal" data-target="#modalDetail" onclick="detailData('${btoa(data.id)}', '${btoa(data.jadwal_type)}')"><i class="fa fa-eye" style="color:blue"></i> See detail</a>`;
                    }

                    if (auth_edit == "1") {
                        // button_item += `<a class="dropdown-item download" id="d-pdf" href="${url_pdf_pnp}/p?o=l&search=${btoa(data.id)}.${btoa(data.jadwal_type)}" target="_blank">
						// 					<i class="fa fa-file-pdf-o" style="color:red"></i> Download PDF
						// 				</a>`;
                    }

                    if (auth_edit == "1") {
                        // button_item += `<a class="dropdown-item download" id="d-excel" href="${url_excel_pnp}/p?jadwal_mudik_id=${btoa(data.id)}&jadwal=${btoa(data.jadwal_type)}" target="_blank">
						// 					<i class="fa fa-file-excel-o" style="color:green"></i> Download XLS
						// 				</a>`;
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
                    button_item += (button_item == '') ? "<b>Tidak ada aksi</b>" : "<b>Tidak ada aksi</b>"
                    return button;
                }
            }
        ];
        return columns;
    }
</script>
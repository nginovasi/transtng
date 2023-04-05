<style>
    #sig-canvas,
    #sig-canvas-manager {
        border: 2px dotted #CCCCCC;
        border-radius: 15px;
        cursor: crosshair;
    }

    .select2-container {
        width: 100% !important;
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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="false">Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-form" role="tab" aria-controls="tab-form" aria-selected="false">Form</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                            <form data-plugin="parsley" data-option="{}" id="form">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?= csrf_field(); ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kategori Angkutan</label>
                                            <select class="form-control select2-container" id="kategori_angkutan_id" name="kategori_angkutan_id" required aria-required="true"></select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Trayek</label>
                                            <select class="form-control select2-container" id="trayek_id" name="trayek_id" required aria-required="true"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Hari / Tanggal</label>
                                    <input type="date" class="form-control" name="tgl_spda" id="tgl_spda" required="true">
                                </div>
                                <div class="form-group">
                                    <label>Pengemudi</label>
                                    <select class="form-control select2_id_driver" id="nama_pengemudi" name="driver_spda" required aria-required="true"></select>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Kode Bus</label>
                                            <select class="form-control select2_armada_code" id="armada_code" name="kd_bus_spda" required aria-required="true"></select>
                                        </div>

                                        <div class="form-group">
                                            <label>Konsumsi BBM (Liter)</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="bbm_spda" name="bbm_spda" maxlength="4" required autocomplete="off" placeholder="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Liter</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Ritase</label>
                                            <input type="number" class="form-control" id="ritase_spda" name="ritase_spda" required autocomplete="off" placeholder="Cth: 2" min="0" max="99">
                                        </div>
                                        <div class="form-group">
                                            <label>Waktu Tempuh</label>
                                            <input type="text" class="form-control" id="wkt_tempuh_spda" name="wkt_tempuh_spda" maxlength="15" required autocomplete="off" placeholder="Waktu Tempuh">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Jarak (Km)</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="jrk_tempuh_spda" name="jrk_tempuh_spda" maxlength="15" required autocomplete="off" placeholder="Cth: 9.46">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Kapasitas Bus</label>
                                            <select class="form-control select2_armada_kapasitas" id="armada_kapasitas" name="kapsts_bus_spda" required aria-required="true"></select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Total Penumpang</label>
                                            <input type="text" class="form-control" id="ttl_penumpang_spda" name="ttl_penumpang_spda" maxlength="15" required autocomplete="off" placeholder="Total Penumpang">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Total Pendapatan</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="text" class="form-control" id="ttl_pdptan_spda" name="ttl_pdptan_spda" maxlength="15" required autocomplete="off" placeholder="Total Pendapatan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <p><b>Penjual Karcis / Pengemudi</b></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <canvas id="sig-canvas" name="form_spda_ttd_pengemudi"></canvas>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <div class="btn btn-info btn-sm" id="sig-submitBtn">Simpan Tanda Tangan</div>
                                                <div class="btn btn-default btn-sm" id="sig-clearBtn">Clear</div>
                                            </div>
                                        </div>
                                        <div hidden>
                                            <div class="col-md-12">
                                                <textarea id="sig-dataUrl" class="form-control" rows="5">Data URL for your signature will go here!</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <p><b>General Manager / Manager Usaha</b></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <canvas id="sig-canvas-manager" name="form_spda_nama_manager"></canvas>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <div class="btn btn-info btn-sm" id="sig-submitBtn-manager">Simpan Tanda Tangan</div>
                                                <div class="btn btn-default btn-sm" id="sig-clearBtn-manager">Clear</div>
                                            </div>
                                        </div>
                                        <div hidden>
                                            <div class="col-md-12">
                                                <textarea id="sig-dataUrl-manager" class="form-control" rows="5">Data URL for your signature will go here!</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <!-- <input type="text" class="form-control" name="form_spda_nama_pengemudi" id="form_spda_nama_pengemudi" placeholder="Nama Pengemudi / Penjual Karcis"> -->
                                    </div>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="form_spda_nama_manager" id="form_spda_nama_manager" placeholder="Nama General Manager / Manager Usaha">
                                    </div>
                                </div>
                                <br><br>
                                <div class="text-center">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                                <br><br>
                                <h6 class="text-center">Catatan : Mohon cek kembali setiap data yang telah di
                                    input<br>Karena data bersifat tidak dapat di edit!</h6>
                            </form>
                        </div>
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Tanggal</span></th>
                                            <th><span>No. SPDA</span></th>
                                            <th><span>Kategori</span></th>
                                            <th><span>Trayek</span></th>
                                            <th><span>Nama Pengemudi</span></th>
                                            <th><span>Kode Bus</span></th>
                                            <th><span>Ritase</span></th>
                                            <th><span>Jarak (Km)</span></th>
                                            <th><span>Waktu Tempuh</span></th>
                                            <th><span>Konsumsi BBM (Liter)</span></th>
                                            <th><span>Kapasitas Bus</span></th>
                                            <th><span>Total Penumpang</span></th>
                                            <th><span>Total Pendapatan</span></th>
                                            <th class="column-2action"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    const auth_insert = '<?= $rules->i ?>';
    const auth_edit = '<?= $rules->e ?>';
    const auth_delete = '<?= $rules->d ?>';
    const auth_otorisasi = '<?= $rules->o ?>';

    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';
    const url_pdf_spda = '<?= base_url() . "/" . uri_segment(0) . "/action/pdf/spda" ?>';

    var dataStart = 0;
    var coreEvents;

    const select2Array = [{
            id: 'kategori_angkutan_id',
            url: '/kategori_angkutan_id_select_get',
            placeholder: 'Pilih Kategori Angkutan',
            params: null
        },
        {
            id: 'trayek_id',
            url: '/trayek_id_select_get',
            placeholder: 'Pilih Trayek',
            params: {
                kategori_angkutan_id: function() {
                    return $('#kategori_angkutan_id').val()
                }
            }
        },
        {
            id: 'armada_code',
            url: '/armada_id_select_get',
            placeholder: 'Pilih Armada',
            params: null
        },
        {
            id: 'armada_kapasitas',
            url: '/armada_kapasitas_select_get',
            placeholder: 'Pilih Kapasitas',
            params: {
                armada_code: function() {
                    return $('#armada_code').val()
                }
            }
        },
        {
            id: 'nama_pengemudi',
            url: '/driver_id_select_get',
            placeholder: 'Pilih Petugas Lapangan',
            params: null
        }
    ];


    $(document).ready(function() {
        ////////////////////////////////
        // Set Default Date Formating
        ////////////////////////////////
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);

        $('#tgl_spda').val(today);

        $('#kategori_angkutan_id').on('change', function() {
            $('#trayek_id').val(null).trigger('change');
        });

        $('#trayek_id').on('select2:select', function(e) {
            var data = e.params.data;

            $.ajax({
                url: url_ajax + '/route_distance_select_get',
                type: 'GET',
                dataType: 'json',
                data: {
                    id: data.id,
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
                success: function(result) {
                    $('#jrk_tempuh_spda').val(result[0].route_distance);
                    $('#wkt_tempuh_spda').val(result[0].route_time);
                }
            });
        });

        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };
        coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder: 'Berhasil menyimpan data petugas lapangan',
            afterAction: function(result) {
                // window.location.reload();
            }
        }
        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {}
        }
        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus data form SPDA',
            afterAction: function() {
                // window.location.reload();
            }
        }
        coreEvents.resetHandler = {
            action: function() {}
        }

        coreEvents.load();

        select2Array.forEach(function(x) {
            select2Init('#' + x.id, x.url, x.placeholder, x.params);
        });

        $(document).on('submit', '#form', function(e) {
            var sigText = document.getElementById("sig-dataUrl").value;
            // var sigTextPengemudi = document.getElementById("sig-dataUrl-pengemudi").value;
            var sigTextManager = document.getElementById("sig-dataUrl-manager").value;

            e.preventDefault();
            Swal.fire({
                title: "Simpan data ?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Simpan",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    Swal.fire({
                        title: "",
                        icon: "info",
                        text: "Proses menyimpan data, mohon ditunggu...",
                        didOpen: function() {
                            Swal.showLoading()
                        }
                    });
                    $.ajax({
                        url: url + "_save",
                        type: 'post',
                        data: $('#form').serialize() + "&form_spda_ttd_pengemudi=" +
                            sigText + "&form_spda_ttd_manager=" + sigTextManager,
                        dataType: 'json',
                        success: function(result) {
                            Swal.close();
                            if (result.success) {
                                console.log(result);
                                Swal.fire('Sukses', result.message, 'success');
                                window.location.reload();
                            } else {
                                Swal.fire('Error', result.message, 'error');
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            Swal.close();
                            Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                            console.log(xhr);
                        }
                    });
                    console.log(result);
                }
            });
        });

    });

    function select2Init(id, url, placeholder, parameter) {
        $(id).select2({
            id: function(e) {
                return e.id
            },
            placeholder: placeholder,
            multiple: false,
            ajax: {
                url: url_ajax + url,
                dataType: 'json',
                quietMillis: 500,
                delay: 500,
                data: function(param) {
                    var def_param = {
                        keyword: param.term, //search term
                        perpage: 5, // page size
                        page: param.page || 0, // page number
                    };

                    return Object.assign({}, def_param, parameter);
                },
                processResults: function(data, params) {
                    params.page = params.page || 0

                    return {
                        results: data.rows,
                        pagination: {
                            more: false
                        }
                    }
                }
            },
            templateResult: function(data) {
                return data.text;
            },
            templateSelection: function(data) {
                if (data.id === '') {
                    return placeholder;
                }

                return data.text;
            },
            escapeMarkup: function(m) {
                return m;
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
                data: "tgl_spda",
                orderable: true
            },
            {
                data: "no_spda",
                orderable: true
            },
            {
                data: "kategori_angkutan_name",
                orderable: true,
                render: function(a, type, data, index) {
                    let html = '';

                    if (data.kategori_angkutan_name == null || data.kategori_angkutan_name == '') {
                        html = '<span class="badge badge-danger">Belum ada data</span>';
                    } else {
                        html = data.kategori_angkutan_name;
                    }

                    return html;
                }
            },
            {
                data: "route_name",
                orderable: true,
                render: function(a, type, data, index) {
                    let html = '';

                    if (data.route_name == null || data.route_name == '') {
                        html = '<span class="badge badge-danger">Belum ada data</span>';
                    } else {
                        html = data.route_name;
                    }

                    return html;
                }
            },
            {
                data: "nama_pengemudi",
                orderable: true
            },
            {
                data: "armada_code",
                orderable: true
            },
            {
                data: "ritase_spda",
                orderable: true
            },
            {
                data: "jrk_tempuh_spda",
                orderable: true
            },
            {
                data: "wkt_tempuh_spda",
                orderable: true
            },
            {
                data: "bbm_spda",
                orderable: true
            },
            {
                data: "kapsts_bus_spda",
                orderable: true
            },
            {
                data: "ttl_penumpang_spda",
                orderable: true
            },
            {
                data: "ttl_pdptan_spda",
                orderable: true
            },
            {
                data: "id",
                orderable: false,
                render: function(a, type, data, index) {
                    let button = ''

                    if (auth_edit == "1") {
                        button += ' <a href="' + url_pdf_spda + '/p?o=p&search=' + btoa(data['no_spda']) + '.' + btoa(data['id']) + '" target="_blank">\
                                    <button class="btn btn-sm btn-outline-success" title="Print"><i class="fa fa-print"></i></button>\
                                </a>';
                    }

                    if (auth_delete == "1") {
                        button += '<button class="btn btn-sm btn-outline-danger delete" data-id="' + data.id + '" title="Delete">\
                                    <i class="fa fa-trash-o"></i>\
                                </button></div>';
                    }


                    button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

                    return button;
                }
            }
        ];

        return columns;
    }

    ////////////////////////////////
    // Action
    ////////////////////////////////
</script>
<!-- JS tanda tangan driver -->
<script src="<?= base_url(); ?>/assets/js/canvas-driver.js"></script>
<!-- JS tanda tangan manager -->
<script src="<?= base_url(); ?>/assets/js/canvas-manager.js"></script>
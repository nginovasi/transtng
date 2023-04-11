<style>
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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="false"><i class="fa fa-table"></i> Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-form" role="tab" aria-controls="tab-form" aria-selected="false"><i class="fa fa-plus"></i> Form</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-hover no-wrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>PO</span></th>
                                            <th><span>Agent</span></th>
                                            <th><span>Provinsi</span></th>
                                            <th><span>KSPN</span></th>
                                            <th><span>Trayek</span></th>
                                            <th><span>Class</span></th>
                                            <th><span>Nama Armada</span></th>
                                            <th><span>No. Kendaraan</span></th>
                                            <th><span>GPS ID</span></th>
                                            <th><span>Warna</span></th>
                                            <th><span>Merk</span></th>
                                            <th class="column-2action"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                            <form data-plugin="parsley" data-option="{}" id="form">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?= csrf_field(); ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>PO</label>
                                            <select class="form-control sel2" id="po_id" name="po_id" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>PO Agent</label>
                                            <select class="form-control sel2" id="po_agent_id" name="po_agent_id" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Armada</label>
                                            <input type="text" class="form-control" id="armada_name" name="armada_name" maxlength="300" required autocomplete="off" placeholder="Tentukan Nama Armada">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kode Armada</label>
                                            <input type="text" class="form-control" id="armada_code" name="armada_code" maxlength="300" required autocomplete="off" placeholder="Tentukan Kode Armada Armada">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nomor STNK</label>
                                            <input type="text" class="form-control" id="armada_stnk_number" name="armada_stnk_number" maxlength="30" required autocomplete="off" placeholder="Tentukan Nomor STNK Armada">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tanggal Berlaku STNK</label>
                                            <input type="date" class="form-control" id="armada_stnk_active_date" name="armada_stnk_active_date" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Tahun Armada</label>
                                            <input type="number" class="form-control" id="armada_year" name="armada_year" maxlength="4" required autocomplete="off" placeholder="Tentukan Tahun Armada">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Nomor KIR</label>
                                            <input type="text" class="form-control" id="armada_kir_number" name="armada_kir_number" maxlength="30" required autocomplete="off" placeholder="Tentukan Nomor KIR Armada">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Tanggal Berlaku KIR</label>
                                            <input type="date" class="form-control" id="armada_kir_active_date" name="armada_kir_active_date" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Trayek</label>
                                            <select class="form-control sel2" id="trayek_id" name="trayek_id" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Class</label>
                                            <select class="form-control sel2" id="class_id" name="class_id" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Nomor Kendaraan</label>
                                            <input type="text" class="form-control" id="armada_plat_number" name="armada_plat_number" maxlength="300" required autocomplete="off" placeholder="Nomor Kendaraan Armada">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Warna Armada</label>
                                            <input type="color" class="form-control" id="armada_color" name="armada_color">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Merk Armada</label>
                                            <input type="text" class="form-control" id="armada_merk" name="armada_merk" maxlength="300" autocomplete="off" placeholder="Tentukan Merk Armada">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>GPS ID</label>
                                            <input type="number" class="form-control" id="armada_gps_id" name="armada_gps_id" maxlength="300" autocomplete="off" placeholder="Tentukan GPS ID">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
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

    var dataStart = 0;
    var coreEvents;

    const select2Array = [{
            id: 'po_id',
            url: '/po_id_select_get',
            placeholder: 'Pilih PO Armada',
            params: null
        },
        {
            id: 'po_agent_id',
            url: '/po_agent_id_select_get',
            placeholder: 'Pilih Agent PO',
            params: {
                po_id: function() {
                    return $('#po_id').val()
                }
            }
        },
        {
            id: 'trayek_id',
            url: '/trayek_id_select_get',
            placeholder: 'Pilih Trayek Armada',
            params: null
        }, {
            id: 'class_id',
            url: '/class_id_select_get',
            placeholder: 'Pilih Class Armada',
            params: null
        }
    ];

    $(document).ready(function() {
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };
        coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder: 'Berhasil menyimpan data armada',
            afterAction: function(result) {}
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
                if (result.data.po_id != null && result.data.po_agent_id != null && result.data.trayek_id !=
                    null && result.data.class_id != null) {
                    $('#po_id').html('<option value = "' + result.data.po_id + '" selected >' + result.data
                        .po_name + '</option>');
                    $('#po_agent_id').html('<option value = "' + result.data.po_agent_id + '" selected >' +
                        result.data.po_agent_name + '</option>');
                    $('#trayek_id').html('<option value = "' + result.data.trayek_id + '" selected >' +
                        result.data.trayek_name + '</option>');
                    $('#class_id').html('<option value = "' + result.data.class_id + '" selected >' + result
                        .data.class_name + '</option>');
                } else {
                    $('#po_id').html('<option value = "" selected >Pilih PO Armada</option>');
                    $('#po_agent_id').html('<option value = "" selected >Pilih Agent PO</option>');
                    $('#trayek_id').html('<option value = "" selected >Pilih Trayek Armada</option>');
                    $('#class_id').html('<option value = "" selected >Pilih Class Armada</option>');
                }
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus data armada',
            afterAction: function() {

            }
        }

        coreEvents.resetHandler = {
            action: function() {

            }
        }

        coreEvents.load();

        select2Array.forEach(function(x) {
            select2Init('#' + x.id, x.url, x.placeholder, x.params);
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
                data: "po_name",
                orderable: true
            },
            {
                data: "po_agent_name",
                orderable: true
            },
            {
                data: "provinsi",
                orderable: true
            },
            {
                data: "kspn",
                orderable: true
            },
            {
                data: "trayek",
                orderable: true
            },
            {
                data: "class_name",
                orderable: true
            },
            {
                data: "armada_name",
                orderable: true
            },
            {
                data: "armada_plat_number",
                orderable: true
            },
            {
                data: "armada_gps_id",
                orderable: true
            },
            {
                data: "armada_color",
                orderable: false,
                render: function(a, type, data, index) {
                    return '<div style="border: 1px solid black; width: 50px; height: 25px; background-color: ' +
                        data.armada_color + '"></div>'
                }
            },
            {
                data: "armada_merk",
                orderable: true
            },
            {
                data: "id",
                orderable: false,
                render: function(a, type, data, index) {
                    let button = ''

                    if (auth_edit == "1") {
                        button += '<button class="btn btn-sm btn-outline-primary edit" data-id="' + data.id + '" title="Edit">\
                                    <i class="fa fa-edit"></i>\
                                </button>\
                                ';
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
</script>
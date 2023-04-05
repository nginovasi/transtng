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
                <h2 class="text-md text-highlight"><?=$page_title?></h2>
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
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-hover no-wrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Name</span></th>
                                            <th><span>PO</span></th>
                                            <th><span>Merk</span></th>
                                            <th><span>Kode</span></th>
                                            <th><span>Plat Number</span></th>
                                            <th><span>Kapasitas</span></th>
                                            <th><span>Warna</span></th>
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
                                <?=csrf_field();?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Armada</label>
                                            <input type="text" class="form-control" id="armada_name" name="armada_name" required autocomplete="off" placeholder="Tentukan Nama Armada">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>PO</label>
                                            <select class="form-control sel2" id="po_id" name="po_id" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Armada Label</label>
                                            <input type="text" class="form-control" id="armada_label" name="armada_label" autocomplete="off" placeholder="Tentukan Armada label">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kode Armada</label>
                                            <input type="text" class="form-control" id="armada_code" name="armada_code" required autocomplete="off" placeholder="Tentukan Kode Armada Armada">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>GPS ID</label>
                                            <input type="number" class="form-control" id="armada_gps_id" name="armada_gps_id" autocomplete="off" placeholder="Tentukan GPS ID">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Plat Number</label>
                                            <input type="text" class="form-control" id="armada_plat_number" name="armada_plat_number" required autocomplete="off" placeholder="Tentukan Plat Number Armada">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nomor STNK</label>
                                            <input type="text" class="form-control" id="armada_stnk_number" name="armada_stnk_number" required autocomplete="off" placeholder="Tentukan Nomor STNK Armada">
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
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Merk</label>
                                            <input type="text" class="form-control" id="armada_merk" name="armada_merk" maxlength="30" required autocomplete="off" placeholder="Tentukan Merk Armada">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tahun Armada</label>
                                            <input type="number" class="form-control" id="armada_year" name="armada_year" maxlength="4" required autocomplete="off" placeholder="Tentukan Tahun Armada">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nomor KIR</label>
                                            <input type="text" class="form-control" id="armada_kir_number" name="armada_kir_number" maxlength="30" required autocomplete="off" placeholder="Tentukan Nomor KIR Armada">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tanggal Berlaku KIR</label>
                                            <input type="date" class="form-control" id="armada_kir_active_date" name="armada_kir_active_date" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jadwal Motis</label>
                                            <select class="form-control sel2" id="jadwal_motis_mudik_id" name="jadwal_motis_mudik_id">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Warna Armada</label>
                                            <input type="color" class="form-control" id="armada_color" name="armada_color">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kapasitas</label>
                                            <input type="text" class="form-control" id="armada_capacity" name="armada_capacity" required autocomplete="off" placeholder="Tentukan Kapasitas">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tracking URL</label>
                                            <input type="text" class="form-control" id="armada_tracking_url" name="armada_tracking_url" autocomplete="off" placeholder="Tentukan URL Tracking">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status Armada Tracking</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="armada_tracking_status" id="armada_tracking_status1" value="1">
                                        <label class="form-check-label" for="armada_tracking_status1">Aktif</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="armada_tracking_status" id="armada_tracking_status0" value="0">
                                        <label class="form-check-label" for="armada_tracking_status0">Tidak aktif</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Gambar</label>
                                            <input type="file" class="form-control" id="foto_upload" name="file" >

                                            <input type="hidden" name="armada_image" id="armada_image" />
                                            <div id="foto_progres" style="display: inline;"></div>
                                            <div id="foto_error" style="display: inline;"></div><br>
                                            <div class="files" id="files" style="display: inline-block; width: 200px;"></div>
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

<!-- script internal -->
<script type="text/javascript">
    const auth_insert = '<?=$rules->i?>';
    const auth_edit = '<?=$rules->e?>';
    const auth_delete = '<?=$rules->d?>';
    const auth_otorisasi = '<?=$rules->o?>';

    const url_ori = '<?= base_url() . "/" ?>';
    const url = '<?=base_url()."/".uri_segment(0)."/action/".uri_segment(1)?>';
    const url_ajax = '<?=base_url()."/".uri_segment(0)."/ajax"?>';

    var dataStart = 0;
    var coreEvents;

    const select2Array = [
        {
            id: 'po_id',
            url: '/po_id_select_get',
            placeholder: 'Pilih PO Armada',
            params: null
        },
        {
            id: 'jadwal_motis_mudik_id',
            url: '/jadwal_motis_mudik_id_select_get',
            placeholder: 'Pilih jadwal motis',
            params: null
        },
    ];

    $(document).ready(function() {
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?=csrf_token()?>": "<?=csrf_hash()?>"
        };
        coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder: 'Berhasil menyimpan data armada motor gratis',
            afterAction: function(result) {
                $(".sel2").val(null).trigger('change');
                $( ".checkbox" ).prop( "checked", false );
                $("#files").html('');
            }
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
                setTimeout(function() {
                    select2Array.forEach(function(x) {
                        $('#' + x.id).select2('trigger', 'select', {
                            data: {
                                id: result.data[x.id] ? result.data[x.id] : 0,
                                text: result.data[x.id.replace('id', 'nama')] ? result.data[x.id.replace('id', 'nama')] : null
                            }
                        });
                    });
                }, 100);

                if (result.data.armada_tracking_status == '0') {
                    $('#armada_tracking_status0').prop('checked', true);
                } else if (result.data.armada_tracking_status == '1') {
                    $('#armada_tracking_status1').prop('checked', true);
                } else {
                    $('#armada_tracking_status0').prop('checked', false);
                    $('#armada_tracking_status1').prop('checked', false);
                }

                $("#files").html('<div style="display: inline-block; padding: 5px;"><img style="height: 150px; border: 1px solid #000" src="' + url_ori + result.data.armada_image+'" /></div>');
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus data armada motor gratis',
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

    $("#foto_upload").fileupload({
        url: url+'_upload',
        dataType: 'json',
        formData:{ "<?=csrf_token()?>": "<?=csrf_hash()?>" },
        autoUpload: false
    }).on('fileuploadadd', function (e, data) {
        var fileTypeAllowed = /.\.(gif|jpg|png|jpeg|bmp|svg)$/i;
        var fileName = data.originalFiles[0]['name'];
        var fileSize = data.originalFiles[0]['size'];

            $("#foto_error").html("");

        if (!fileTypeAllowed.test(fileName))
            $("#foto_error").html('Only images are allowed!');
        else if (fileSize > 10000000)
            $("#foto_error").html('Your file is too big! Max allowed size is: 1Mb');
        else {
            $("#foto_error").html("");
            data.submit();
        }
    }).on('fileuploaddone', function(e, data) {
        var status = data.jqXHR.responseJSON.status;
        var msg = data.jqXHR.responseJSON.msg;

        if (status == 1) {
            var path = data.jqXHR.responseJSON.path;
            $("#files").html('<div style="display: inline-block; padding: 5px;"><img style="height: 150px; border: 1px solid #000" src="' + url_ori + path + '" /></div>');
            $("#armada_image").val(path);

        } else {
            $("#foto_error").html(msg);
        }
    }).on('fileuploadprogressall', function(e,data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $("#foto_progres").html("Proses: " + progress + "%");
        if (progress==100) {
            $("#foto_progres").html("");
        }
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
                data: "armada_name",
                orderable: true
            },
            {
                data: "po_name",
                orderable: true
            },
            {
                data: "armada_merk",
                orderable: true
            },
            {
                data: "armada_code",
                orderable: true
            },
            {
                data: "armada_plat_number",
                orderable: true
            },
            {
                data: "armada_capacity",
                orderable: true
            },
            {
                data: "armada_color",
                orderable: false,
                render: function(a, type, data, index) {
                    return `<div style="border: 1px solid black; 
                                        width: 50px; 
                                        height: 25px; 
                                        background-color: ${data.armada_color} "></div>`
                }
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

<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<div>
    <div class="page-hero page-container " id="page-hero">
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
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills no-border" id="tab">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab"
                            aria-controls="tab-data" aria-selected="false">Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-form" role="tab" aria-controls="tab-form"
                            aria-selected="false">Form</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Tanggal Tugas</span></th>
                                            <th><span>Nama Posko</span></th>
                                            <th><span>Petugas Posko</span></th>
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
                                <div class="form-group">
                                    <label>Tanggal Tugas</label>
                                    <input type="date" class="form-control date" id="tgl_tugas"
                                        name="tgl_tugas" maxlength="10" required autocomplete="off"
                                        placeholder="Tanggal Posko">
                                </div>
                                <div class="form-group">
                                    <label>Lokasi Posko</label>
                                    <select class="form-control sel2" id="posko_id" name="posko_id" required>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Petugas Posko</label>
                                            <select class="form-control sel2" id="user_id" name="user_id"
                                                required>
                                            </select>
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
    //alert(url);

    var dataStart = 0;
    var coreEvents;

    const select2Array = [
    {
        id: 'posko_id',
        url: '/posko_id_select_get',
        placeholder: 'Pilih Posko',
        params: null
    },
    {
        id: 'user_id',
        url: '/user_id_select_get',
        placeholder: 'Pilih Petugas',
        params: null
    }
    ];


    $(document).ready(function () {
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };
        coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder: 'Berhasil menyimpan data Lokasi Posko',
            afterAction: function (result) {
                map.eachLayer(function (layer) {
                    if (layer instanceof L.Marker) {
                        map.removeLayer(layer);
                    }
                    if (layer instanceof L.Polyline) {
                        map.removeLayer(layer);
                        map.setView([-6.966667, 110.416664], 13);
                    }
                });
                // reload window
                window.location.reload();
            }
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function (result) {
                
                $('#id').val(result.data.id);
                $('#posko_id').html('<option value = "' + result.data.posko_id + '" selected >' + result
                    .data.posko_mudik_name + '</option>');
                $('#user_id').html('<option value = "' + result.data.user_id + '" selected >' + result
                    .data.username + '</option>');
                $('#tgl_tugas').val(result.data.tgl_tugas);

            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus data Jadwal Petugas Posko',
            afterAction: function () {

            }
        }

        coreEvents.resetHandler = {
            action: function () {

            }
        }

        coreEvents.load();

        select2Array.forEach(function (x) {
            coreEvents.select2Init('#' + x.id, x.url, x.placeholder, x.params, null);
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
            render: function (a, type, data, index) {
                return dataStart + index.row + 1
            }
        },
        {
            data: "tgl_tugas",
            orderable: true
        },
        {
            data: "posko_mudik_name",
            orderable: true
        },
        {
            data: "petugasposko",
            orderable: true
        },
        {
            data: "id",
            orderable: false,
            render: function (a, type, data, index) {
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
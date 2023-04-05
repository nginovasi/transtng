<!-- style internal -->
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">

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
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Nama Armada</span></th>
                                            <th><span>Tanggal Kedatangan</span></th>
                                            <th><span>Waktu Kedatangan</span></th>
                                            <th><span>Tanggal Sampai</span></th>
                                            <th><span>Waktu Sampai</span></th>
                                            <th><span>Rute</span></th>
                                            <th class="column-2action">Status</th>
                                            <th class="column-2action">Arus</th>
                                            <th><span>Aksi</span></th>
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
                                    <label>Nama Armada Mudik</label>
                                    <select class="form-control sel2" id="jadwal_armada_id" name="jadwal_armada_id" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Keberangkatan Bis</label>
                                    <input type="text" class="form-control form-control-md date" name="jadwal_date_depart" id="jadwal_date_depart" placeholder="Tanggal Kedatangan Bis" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Waktu Keberangkatan Bis</label>
                                    <input type="time" class="form-control form-control-md date" name="jadwal_time_depart" id="jadwal_time_depart" placeholder="Waktu Kedatangan Bis" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Kedatangan Bis</label>
                                    <input type="text" class="form-control form-control-md date" name="jadwal_date_arrived" id="jadwal_date_arrived" placeholder="Tanggal Sampai Bis" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Waktu Kedatangan Bis</label>
                                    <input type="time" class="form-control form-control-md date" name="jadwal_time_arrived" id="jadwal_time_arrived" placeholder="Waktu Sampai Bis" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Rute</label>
                                    <select class="form-control sel2" id="jadwal_route_id" name="jadwal_route_id" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Arus</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jadwal_type" id="jadwal_type1" value="1">
                                        <label class="form-check-label" for="jadwal_type1">Mudik</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jadwal_type" id="jadwal_type2" value="2">
                                        <label class="form-check-label" for="jadwal_type2">Balik</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status Jadwal</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="open" id="open1" value="1">
                                        <label class="form-check-label" for="open1">Open</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="open" id="open0" value="0">
                                        <label class="form-check-label" for="open0">Closed</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="open_at">Waktu Tayang :</label>
                                    <div class="input-group date" id="open_at1">
                                        <input type="text" name="open_at" id="open_at" class="form-control" required/>
                                        <div class="input-group-addon input-group-append">
                                            <div class="input-group-text">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                            </div>
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
    const auth_insert = '<?= $rules->i ?>';
    const auth_edit = '<?= $rules->e ?>';
    const auth_delete = '<?= $rules->d ?>';
    const auth_otorisasi = '<?= $rules->o ?>';

    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';

    var dataStart = 0;
    var coreEvents;

    const select2Array = [{
            id: 'jadwal_armada_id',
            url: '/idarmadamudik_select_get',
            placeholder: 'Pilih Armada Mudik',
            params: null
        },
        {
            id: 'jadwal_route_id',
            url: '/idrute_select_get',
            placeholder: 'Pilih Rute',
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
            placeholder: 'Berhasil menyimpan data jadwal mudik',
            afterAction: function(result) {
                $(".sel2").val(null).trigger('change');
            }
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
                setTimeout(function() {
                    select2Array.forEach(function(x) {
                        $('#' + x.id).select2('trigger', 'select', {
                            data: {
                                id: result.data[x.id],
                                text: result.data[x.id.replace('id', 'nama')]
                            }
                        });
                    });
                }, 100);

                $('#jadwal_armada_id').select2("enable", false) // because armada not change

                if (result.data.open == '0') {
                    $('#open0').prop('checked', true);
                } else if (result.data.open == '1') {
                    $('#open1').prop('checked', true);
                } else {
                    $('#open0').prop('checked', false);
                    $('#open1').prop('checked', false);
                }

                if (result.data.jadwal_type == '1') {
                    $('#jadwal_type1').prop('checked', true);
                } else if (result.data.jadwal_type == '2') {
                    $('#jadwal_type2').prop('checked', true);
                } else {
                    $('#jadwal_type1').prop('checked', false);
                    $('#jadwal_type2').prop('checked', false);
                }
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus data jadwal mudik',
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

        coreEvents.load(coreEvents.filter);

        coreEvents.datetimepickerDate('#jadwal_date_depart')
        coreEvents.datetimepickerDate('#jadwal_date_arrived')
	coreEvents.datetimepickerDateTime('#open_at')
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
                data: "jadwal_date_depart",
                orderable: true
            },
            {
                data: "jadwal_time_depart",
                orderable: true
            },
            {
                data: "jadwal_date_arrived",
                orderable: true
            },
            {
                data: "jadwal_time_arrived",
                orderable: true
            },
            {
                data: "route_name",
                orderable: true
            },
            {
                data: "open_at",
                orderable: true,
                render: function(a, type, data, index) {
                    let button = ''

                    if (data.open == "0") {
                        button += `<div class="text-center"><button class="btn btn-sm btn-outline-danger closed" title="Closed">
                                            Closed
                                        </button></div>`
                    } else {
                        button += `<div class="text-center"><button class="btn btn-sm btn-outline-success open" title="open">
                                            Open at
                                        </button>
                                    </div>
                                    <div class="text-center"><small>`+data.open_at+`</small></div>`
                    }

                    return button;
                }
            },
            {
                data: "jadwal_type",
                orderable: true,
                render: function(a, type, data, index) {
                    let button = ''

                    if (data.jadwal_type == "1") {
                        button += `<button class="btn btn-sm btn-outline-success closed" title="Closed">
                                            Mudik
                                        </button>`
                    } else {
                        button += `<button class="btn btn-sm btn-outline-primary open" title="open">
                                            Balik
                                        </button>`
                    }

                    return button;
                }
            },
            {
                data: "id",
                orderable: false,
                render: function(a, type, data, index) {
                    let button = ''

                    if(auth_edit == "1"){
                        button += '<button class="btn btn-sm btn-outline-primary edit" data-id="'+data.id+'" title="Edit">\
                                <i class="fa fa-edit"></i>\
                            </button>\
                            ';
                    }

                    if(auth_delete == "1"){
                        button += '<button class="btn btn-sm btn-outline-danger delete" data-id="'+data.id+'" title="Delete">\
                                    <i class="fa fa-trash-o"></i>\
                                </button></div>';
                    }

                    return button;
                }
            }
        ];

        return columns;
    }
</script>

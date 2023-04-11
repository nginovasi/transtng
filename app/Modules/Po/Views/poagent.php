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
                                <table id="datatable" class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Nama PO</span></th>
                                            <th><span>Nama Agent</span></th>
                                            <th><span>Alamat</span></th>
                                            <th><span>Provinsi</span></th>
                                            <th><span>Kab / Kota</span></th>
                                            <th><span>Email</span></th>
                                            <th><span>No. Telp</span></th>
                                            <th><span>Jam Buka</span></th>
                                            <th><span>Jam Tutup</span></th>
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
                                            <label>Nama PO</label>
                                            <select class="form-control sel2" id="po_id" name="po_id" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Agent</label>
                                            <input type="text" class="form-control" id="po_agent_name" name="po_agent_name" maxlength="150" required autocomplete="off" placeholder="Tentukan nama agent">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Provinsi</label>
                                            <select class="form-control sel2" id="lokprov_id" name="lokprov_id" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kab / Kota</label>
                                            <select class="form-control sel2" id="idkabkota" name="idkabkota" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" id="po_agent_address" name="po_agent_address" maxlength="255" required autocomplete="off" placeholder="Tentukan alamat agent"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Telepon</label>
                                            <input type=" text" class="form-control" id="po_agent_phone" name="po_agent_phone" maxlength="20" required autocomplete="off" placeholder="Tentukan telepon agent">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" id="po_agent_email" name="po_agent_email" maxlength="150" required autocomplete="off" placeholder="Tentukan email agent">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jam Buka</label>
                                            <input type="time" class="form-control" id="po_agent_open" name="po_agent_open" maxlength="20" required autocomplete="off" placeholder="Tentukan jam buka">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jam Tutup</label>
                                            <input type="time" class="form-control" id="po_agent_close" name="po_agent_close" maxlength="150" required autocomplete="off" placeholder="Tentukan jam tutup">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Latitude</label>
                                            <input type="text" class="form-control" name="po_agent_lat" id="po_agent_lat" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Longitude</label>
                                            <input type="text" class="form-control" name="po_agent_long" id="po_agent_long" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div style="height: 500px;" id="map"></div>
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
            placeholder: 'Pilih Nama PO',
            params: null
        },
        {
            id: 'lokprov_id',
            url: '/lokprov_id_select_get',
            placeholder: 'Pilih Provinsi',
            params: null
        },
        {
            id: 'idkabkota',
            url: '/idkabkota_select_get',
            placeholder: 'Pilih Kab / Kota',
            params: {
                idprov: function() {
                    return $('#lokprov_id').val()
                }
            }
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

        var map = L.map('map', {
            fullscreenControl: true
        }).setView([-6.966667, 110.416664], 13);
        $('ul#tab li a').on('shown.bs.tab', function(e) {
            map.invalidateSize();
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        map.on('click', function(e) {
            map.eachLayer(function(layer) {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });
            L.marker(e.latlng).on('click', function(e) {}).addTo(map);

            console.log(e.latlng);
            $('#po_agent_lat').val(e.latlng.lat);
            $('#po_agent_long').val(e.latlng.lng);
        });

        coreEvents.insertHandler = {
            placeholder: 'Berhasil menyimpan data kecamatan',
            afterAction: function(result) {
                $(".sel2").val(null).trigger('change');
            }
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
                if (result.data.po_agent_lat != null && result.data.po_agent_long != null) {
                    var customPopup = result.data.po_agent_name + "<br>" + result.data.po_agent_address +
                        "<br>" +
                        result.data.po_agent_phone + "<br>" + result.data.po_agent_email + "<br>" +
                        result.data.po_agent_open + " - " + result.data.po_agent_jam_close;
                    var customOptions = {
                        'maxWidth': '300',
                        'className': 'custom'
                    }
                    var lat = result.data.po_agent_lat;
                    var long = result.data.po_agent_long;
                    var latLong = new L.LatLng(lat, long);
                    map.setView(latLong, 15);
                    L.marker([result.data.po_agent_lat, result.data.po_agent_long]).bindPopup(customPopup,
                        customOptions).on('click', function(e) {}).addTo(map);
                }

                $('#lokprov_id').html('<option value = "' + result.data.lokprov_id + '" selected >' + result.data.provinsi + '</option>');
                $('#idkabkota').html('<option value = "' + result.data.idkabkota + '" selected >' + result.data.kabkota + '</option>');
                $('#po_id').html('<option value = "' + result.data.po_id + '" selected >' + result.data.po_name + '</option>');
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus data kecamatan',
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
                data: "po_agent_address",
                orderable: true
            },
            {
                data: "provinsi",
                orderable: true
            },
            {
                data: "kabkota",
                orderable: true
            },
            {
                data: "po_agent_email",
                orderable: true
            },
            {
                data: "po_agent_phone",
                orderable: true
            },
            {
                data: "po_agent_open",
                orderable: true
            },
            {
                data: "po_agent_close",
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
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
                        <a class="nav-link active" id="nav-data" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="false"><i class="fa fa-table"></i> Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-form" data-toggle="tab" href="#tab-form" role="tab" aria-controls="tab-form" aria-selected="false"><i class="fa fa-plus"></i> Form</a>
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
                                            <th><span>Type</span></th>
                                            <th><span>Koridor</span></th>
                                            <th><span>Rute</span></th>
                                            <th><span>Trip A</span></th>
                                            <th><span>Trip B</span></th>
                                            <th><span>Warna Bis</span></th>
                                            <th><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                            <form data-plugin="parsley" data-option="{}" id="form" method="post">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?= csrf_field(); ?>
                                <div class="form-group row">
                                    <label for="type_bis_id" class="col-2">Jenis Bis</label>
                                    <div class="col-10">
                                        <select class="form-control sel2" id="type_bis_id" name="type_bis_id" placeholder="Pilih jenis bis" required></select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="koridor" class="col-2">Jalur</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Jalur menggunakan romawi huruf besar" id="koridor" name="koridor" autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="rute" class="col-2">Rute</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Contoh: Terminal Poris Plawad - Jl. Gatot Subroto" id="rute" name="rute" autocomplete="off" required/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="origin" class="col-2">Trip A</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Posisi Awal" id="origin" name="origin" autocomplete="off" required/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="toward" class="col-2">Trip B</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Posisi Akhir" id="toward" name="toward" autocomplete="off" required/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="color" class="col-sm-2">Warna Marker</label>
                                    <div class="col-10">
                                        <input type="color" class="form-control" id="color" name="color" placeholder="#000000" required/>
                                    </div>
                                </div>
                                <hr class="mt-3">
                                <div class="text-left mt-3 offset-2">
                                    <button type="button" class="btn btn-secondary w-sm" id="batal">Batal</button>
                                    &nbsp;
                                    <button type="submit" class="btn btn-primary w-sm" id="simpan">Simpan</button>
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

    const base_url = '<?= base_url() ?>';
    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';

    var dataStart = 0;
    var coreEvents;

    // init select2
    const select2Array = [{
        id: 'type_bis_id',
        url: '/type_bis_id_select_get',
        placeholder: 'Pilih Type Bis',
        params: null
    }];

    $(document).ready(function() {
        // init core event
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };

        // datatable load
        coreEvents.tableColumn = datatableColumn();

        // insert
        coreEvents.insertHandler = {
            placeholder: 'Data jalur berhasil ditambahkan',
            afterAction: function(result) {
                $('#tab-data').addClass('active show');
                $('#tab-form').removeClass('active show');
                $('#nav-data').addClass('active');
                $('#nav-form').removeClass('active');

                $(".sel2").val(null).trigger('change');

                coreEvents.table.ajax.reload();
            }
        }

        // update
        coreEvents.editHandler = {
            placeholder : '',
            afterAction : function(result) {
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
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Data jalur berhasil dihapus',
            afterAction: function() {}
        }

        coreEvents.resetHandler = {
            action: function() {
                // reset form
                $('#form')[0].reset();
                $('#form').parsley().reset();
            }
        }

        select2Array.forEach(function(x) {
            coreEvents.select2Init('#' + x.id, x.url, x.placeholder, x.params);
        });
        
        coreEvents.load(null, [0, 'asc'], null);
    });

    // datatable column
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
                data: "m_type_bis_nama",
                orderable: true
            },
            {
                data: "koridor",
                orderable: true
            },
            {
                data: "rute",
                orderable: true
            },
            {
                data: "origin",
                orderable: true
            },
            {
                data: "toward",
                orderable: true
            },
            {
                data: "color",
                orderable: false,
                render: function(a, type, data, index) {
                    return `<div style="border: 1px solid black; 
                                        width: 50px; 
                                        height: 25px; 
                                        background-color: ${data.color} "></div>`
                }
            },
            {
                data: "id",
                orderable: false,
                width: 100,
                render: function(a, type, data, index) {
                    let button = ''

                    if (auth_edit == "1") {
                        button += '<button class="btn btn-sm btn-outline-primary edit" data-id="' + data.id + '" title="Edit">\
                                    <i class="fa fa-edit"></i></button>';
                    }

                    if (auth_delete == "1") {
                        button += '<button class="btn btn-sm btn-outline-danger delete" data-id="' + data.id + '" title="Delete">\
                                        <i class="fa fa-trash-o"></i></button></div>';
                    }

                    button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

                    return button;
                }
            }
        ];
        return columns;
    }

</script>
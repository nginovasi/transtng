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
                                            <th><span>Kode Bus/Halte</span></th>
                                            <th><span>Nama</span></th>
                                            <th><span>Merk Bus</span></th>
                                            <th><span>Jalur</span></th>
                                            <th><span>Nomor Polisi</span></th>
                                            <th><span>Status</span></th>
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
                                    <label for="jen_pos" class="col-2">Jenis Pos</label>
                                    <div class="col-10">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jen_pos" id="jen_pos0" value="0" checked="checked">
                                            <label class="form-check-label" for="jen_pos0">Bis</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jen_pos" id="jen_pos1" value="1">
                                            <label class="form-check-label" for="jen_pos1">Halte</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-2">Nama</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Name" id="name" name="name" autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kode_haltebis" class="col-2">Kode</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Kode" id="kode_haltebis" name="kode_haltebis" autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jalur_id" class="col-2">Jalur</label>
                                    <div class="col-10">
                                        <select class="form-control sel2" id="jalur_id" name="jalur_id" placeholder="Pilih jenis bis" required></select>
                                    </div>
                                </div>
                                <div class="form-group row change-jen-pos-0">
                                    <label for="merk" class="col-2">Merk</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Merk" id="merk" name="merk" autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="form-group row change-jen-pos-0">
                                    <label for="nopol" class="col-2">Nopol</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Nopol" id="nopol" name="nopol" autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="is_active" class="col-2">Status</label>
                                    <div class="col-10">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_active" id="is_active0" value="0" checked="checked">
                                            <label class="form-check-label" for="is_active0">Aktif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_active" id="is_active1" value="1">
                                            <label class="form-check-label" for="is_active1">Tidak Aktif</label>
                                        </div>
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
        id: 'jalur_id',
        url: '/jalur_id_select_get',
        placeholder: 'Pilih Jalur',
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
            placeholder: 'Data halte/bus berhasil ditambahkan',
            afterAction: function(result) {
                $('#tab-data').addClass('active show');
                $('#tab-form').removeClass('active show');
                $('#nav-data').addClass('active');
                $('#nav-form').removeClass('active');

                $(".sel2").val(null).trigger('change');

                console.info($("input[name='jen_pos']:checked").val())

                if($("input[name='jen_pos']:checked").val() == 0) {

                    $('.change-jen-pos-0').remove();
                    
                    $("input[name='jen_pos']").closest('form').find('.form-group').eq(3).after(`
                        <div class="form-group row change-jen-pos-0">
                            <label for="merk" class="col-2">Merk</label>
                            <div class="col-10">
                                <input class="form-control" type="text" placeholder="Merk" id="merk" name="merk" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group row change-jen-pos-0">
                            <label for="nopol" class="col-2">Nopol</label>
                            <div class="col-10">
                                <input class="form-control" type="text" placeholder="Nopol" id="nopol" name="nopol" autocomplete="off" required />
                            </div>
                        </div>
                    `);
                } else {
                    $('.change-jen-pos-0').remove();
                }

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

                if (result.data.jen_pos == 0) {
                    $("#jen_pos0").click();

                    $("#merk").val(result.data.merk)
                    $("#nopol").val(result.data.nopol)
                } else if (result.data.jen_pos == 1) {
                    $("#jen_pos1").click();
                }

                if (result.data.is_active == 0) {
                    $("#is_active0").click();
                } else if (result.data.is_active == 1) {
                    $("#is_active1").click();
                }
            }
        }

        // delete
        coreEvents.deleteHandler = {
            placeholder: 'Data jalur berhasil dihapus',
            afterAction: function() {}
        }

        // reset
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

    // on change jen pos
    $('input[name="jen_pos"]').on('change', function () {
        if($(this).val() == 0) {
            $(this).closest('form').find('.form-group').eq(3).after(`
                <div class="form-group row change-jen-pos-0">
                    <label for="merk" class="col-2">Merk</label>
                    <div class="col-10">
                        <input class="form-control" type="text" placeholder="Merk" id="merk" name="merk" autocomplete="off" required />
                    </div>
                </div>
                <div class="form-group row change-jen-pos-0">
                    <label for="nopol" class="col-2">Nopol</label>
                    <div class="col-10">
                        <input class="form-control" type="text" placeholder="Nopol" id="nopol" name="nopol" autocomplete="off" required />
                    </div>
                </div>
            `);
        } else {
            $('.change-jen-pos-0').remove();
        }
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
                data: "kode_haltebis",
                orderable: true
            },
            {
                data: "name",
                orderable: true
            },
            {
                data: "merk",
                orderable: true
            },
            {
                data: "jalur_nama",
                orderable: true
            },
            {
                data: "nopol",
                orderable: true
            },
            {
                data: "is_active",
                orderable: true,
                render: function(a, type, data, index) {

                    let badge = ""
                    if(data.is_active == 0) {
                        badge = '<span class="badge badge-success">Aktif</span>'
                    } else {
                        badge = '<span class="badge badge-danger">Non-Aktif</span>'
                    }

                    return badge
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
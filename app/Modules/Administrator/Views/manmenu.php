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
                                <table id="datatable" class="table table-theme table-row v-middle">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Nama Modul</span></th>
                                            <th><span>Nama Menu</span></th>
                                            <th><span>Url Menu</span></th>
                                            <th><span>Parent Menu</span></th>
                                            <th></th>
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
                                    <label>Modul</label>
                                    <select class="form-control" id="module_id" name="module_id" required>
                                        <option></option>
                                        <?php
                                        foreach ($modules as $module) {
                                            echo '<option value="' . $module->id . '">' . $module->module_name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Parent Menu</label>
                                    <select class="form-control" id="menu_id" name="menu_id"></select>
                                </div>
                                <div class="form-group">
                                    <label>Nama Menu</label>
                                    <input type="text" class="form-control" id="menu_name" name="menu_name" required autocomplete="off" placeholder="Tentukan nama menu">
                                </div>
                                <div class="form-group">
                                    <label>Url Menu</label>
                                    <input type="text" class="form-control" id="menu_url" name="menu_url" required autocomplete="off" placeholder="Tentukan nama modul">
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

    const select2Array = [];

    $(document).ready(function() {
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };
        coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder: 'Berhasil menyimpan menu',
            afterAction: function(result) {

            }
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
                setTimeout(function() {
                    $('#module_id').val(result.data.module_id).trigger('change');

                    getListMenu(result.data.module_id, function() {
                        $('#menu_id').val(result.data.menu_id).trigger('change');
                    });
                }, 500);
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus menu',
            afterAction: function() {

            }
        }

        coreEvents.resetHandler = {
            action: function() {
                $('#menu_id').data('select2').destroy();
                $('#menu_id').html('');
                $('#menu_id').select2({
                    placeholder: "Pilih modul terlebih dahulu"
                });
                $('#module_id').val(null).trigger('change');
            }
        }

        coreEvents.load();

        $('#module_id').select2({
            placeholder: "Pilih modul"
        }).on('select2:select', function(e) {
            getListMenu(e.params.data.id, function() {});
        });

        $('#menu_id').select2({
            placeholder: "Pilih modul terlebih dahulu"
        });
    });

    function getListMenu(id, completion) {
        $('#menu_id').data('select2').destroy();

        $.get({
            url: url_ajax + "/menu_select_get/" + id,
            dataType: 'html',
            success: function(result) {
                $('#menu_id').html(result);
                $('#menu_id').select2();
                completion();
            }
        })
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
                data: "module_name",
                orderable: true
            },
            {
                data: "menu_name",
                orderable: true
            },
            {
                data: "menu_url",
                orderable: true
            },
            {
                data: "menu_parent",
                orderable: true,
                render: function(a, type, data, index) {
                    return data.menu_parent || '';
                }
            },
            {
                data: "id",
                orderable: false,
                width: 100,
                render: function(a, type, data, index) {
                    let button = ""

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

                    button += (button == "") ? "<b>Tidak ada aksi</b>" : ""

                    return button;
                }
            }
        ];

        return columns;
    }
</script>
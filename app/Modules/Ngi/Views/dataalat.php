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
                                            <th><span>IMEI</span></th>
                                            <th><span>Kode Alat</span></th>
                                            <th><span>No SIM Card</span></th>
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
                                    <label for="imei" class="col-2">IMEI</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Imei" id="imei" name="imei" autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tool_code" class="col-2">Kode Alat</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Kode Alat" id="tool_code" name="tool_code" autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_telp" class="col-2">Nomor Telp</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Nomor Telp" id="no_telp" name="no_telp" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bni_mid" class="col-2">BNI MID</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="BNI MID" id="bni_mid" name="bni_mid" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bni_tid" class="col-2">BNI TID</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="BNI TID" id="bni_tid" name="bni_tid" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bni_marry_code" class="col-2">BNI Marry Code</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="BNI Marry Code" id="bni_marry_code" name="bni_marry_code" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bri_mid" class="col-2">BRI MID</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="BRI MID" id="bri_mid" name="bri_mid" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bri_tid" class="col-2">BRI TID</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="BRI TID" id="bri_tid" name="bri_tid" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bri_pro_code" class="col-2">BRI Pro Code</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="BRI Pro Code" id="bri_pro_code" name="bri_pro_code" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdr_mid" class="col-2">MANDIRI MID</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="MANDIRI MID" id="mdr_mid" name="mdr_mid" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdr_tid" class="col-2">MANDIRI TID</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="MANDIRI TID" id="mdr_tid" name="mdr_tid" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdr_pin_code" class="col-2">MANDIRI PIN CODE</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="MANDIRI PIN CODE" id="mdr_pin_code" name="mdr_pin_code" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdr_sam_operator" class="col-2">MANDIRI SAM OPERATOR</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="MANDIRI SAM OPERATOR" id="mdr_sam_operator" name="mdr_sam_operator" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdr_sam_uid" class="col-2">MANDIRI SAM UID</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="MANDIRI SAM UID" id="mdr_sam_uid" name="mdr_sam_uid" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bca_mid" class="col-2">BCA MID</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="BCA MID" id="bca_mid" name="bca_mid" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bca_tid" class="col-2">BCA TID</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="BCA TID" id="bca_tid" name="bca_tid" autocomplete="off" />
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
    const select2Array = [];

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
            placeholder: 'Data software license berhasil ditambahkan',
            afterAction: function(result) {
                $('#tab-data').addClass('active show');
                $('#tab-form').removeClass('active show');
                $('#nav-data').addClass('active');
                $('#nav-form').removeClass('active');

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

        // delete
        coreEvents.deleteHandler = {
            placeholder: 'Data software license berhasil dihapus',
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
                data: "imei",
                orderable: true
            },
            {
                data: "tool_code",
                orderable: true
            },
            {
                data: "no_telp",
                orderable: true
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
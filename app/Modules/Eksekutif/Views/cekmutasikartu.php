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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="true"><i class="fa fa-history" aria-hidden="true"></i> Riwayat Mutasi Kartu untuk 60 Hari Terakhir</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <form data-plugin="parsley" data-option="{}" id="form" method="post">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?= csrf_field(); ?>
                                <div class="form-group">
                                    <label class="">Masukkan Nomor Kartu</label>
                                    <select class="form-control select2" name="nomorkartu" id="nomorkartu" required></select>
                                </div>
                            </form>
                            <hr class="mt-3">
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

    const base_url = '<?= base_url() ?>';
    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';

    var dataStart = 0;
    var coreEvents;

    const select2Array = [{
        id: 'nomorkartu',
        url: '/findkartu',
        placeholder: 'Ketik Kartu',
        params: null
    }];

    $(document).ready(function() {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);

        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };
        // coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder: 'Data pegawai berhasil ditambahkan',
            afterAction: function(result) {}
        }

        coreEvents.editHandler = {
            placeholder: 'Data pegawai berhasil diubah',
            afterAction: function(result) {}
        }

        coreEvents.deleteHandler = {
            placeholder: 'Data pegawai berhasil dihapus',
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
        // select2Array.forEach(function(x) {
        //     select2Init('#' + x.id, x.url, x.placeholder, x.params);
        // });

        coreEvents.load(null, [0, 'asc'], null);

        $('#nomorkartu').on('select2:select', function(e) {
            var data = e.params.data;
            console.log(data);
            // your code here...
        });
    });

    // function datatableColumn() {
    //     let columns = [{
    //             data: "id",
    //             orderable: false,
    //             width: 100,
    //             render: function(a, type, data, index) {
    //                 return dataStart + index.row + 1
    //             }
    //         },
    //         {
    //             data: "fullname",
    //             orderable: true
    //         },
    //         {
    //             data: "telp",
    //             orderable: true
    //         },
    //         {
    //             data: "id",
    //             orderable: false,
    //             width: 100,
    //             render: function(a, type, data, index) {
    //                 let button = ''

    //                 if (auth_edit == "1") {
    //                     button += '<button class="btn btn-sm btn-outline-primary edit" data-id="' + data.id + '" title="Edit">\
    //                                 <i class="fa fa-edit"></i></button>';
    //                 }

    //                 if (auth_delete == "1") {
    //                     button += '<button class="btn btn-sm btn-outline-danger delete" data-id="' + data.id + '" title="Delete">\
    //                                     <i class="fa fa-trash-o"></i></button></div>';
    //                 }

    //                 button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

    //                 return button;
    //             }
    //         }
    //     ];
    //     return columns;
    // }
</script>
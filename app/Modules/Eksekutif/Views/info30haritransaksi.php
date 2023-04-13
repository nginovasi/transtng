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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="false"><i class="fa fa-exchange" aria-hidden="true"></i> Transaksi Perjalur</a>
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
                                <div class="form-group row">
                                    <div class="input-group mb-3 col-md-5">
                                        <select class="custom-select select2" name="cekpta" id="cekpta" required></select>
                                    </div>
                                    <div class="input-group mb-3 col-md-5">
                                        <select class="custom-select select2" name="cekpos" id="cekpos" required></select>
                                    </div>
                                </div>
                                <div class="btn-group pull-right mt-3" id="cekpta_group" hidden>
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                            <i class="fa fa-download" aria-hidden="true"></i> Export
                                        </button>
                                        <ul class="dropdown-menu cekpta-menu" x-placement="bottom-start">
                                            <li class="dropdown-item">
                                                <a id="dncekptaExcel" href="#"><i class="fa fa-file-excel-o" style="color: #1e7e34;"></i> Unduh Excel</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a id="dncekptaPdf" href="#"><i class="fa fa-file-pdf-o" style="color: #dc3545;"></i> Unduh PDF</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                            <hr>
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
            id: 'cekpta',
            url: '/findpetugas',
            placeholder: 'Pilih Petugas',
            params: null
        },
        {
            id: 'cekpos',
            url: '/findpos',
            placeholder: 'Pilih Pos',
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
        // coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder: 'Berhasil menyimpan jenis user',
            afterAction: function(result) {
                $('#tab-data').addClass('active show');
                $('#tab-form').removeClass('active show');
                coreEvents.table.ajax.reload();
            }
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {}
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus jenis user',
            afterAction: function() {}
        }

        coreEvents.resetHandler = {
            action: function() {
                // reset form
                $('#form')[0].reset();
                $('#form').parsley().reset();
            }
        }

        $('#nama_tenant').on('change', function() {
            var id = $(this).val();
            if (id == '8') {
                $('#is_cashless').html('<option value="0" selected>Cash</option>');
            } else {
                $('#is_cashless').html('<option value="1" selected>Cashless</option>');
            }
        });

        select2Array.forEach(function(x) {
            coreEvents.select2Init('#' + x.id, x.url, x.placeholder, x.params);
        });

        coreEvents.load();
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
    //             data: "jenis",
    //             orderable: true
    //         },
    //         {
    //             data: "tenant_name",
    //             orderable: true
    //         },
    //         {
    //             data: "tarif",
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
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
                                            <th><span>Jalur</span></th>
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
                                    <label for="koridor" class="col-2">Jalur</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Jalur menggunakan romawi huruf besar" id="koridor" name="koridor" required="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="rute" class="col-2">Rute</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Contoh: Tangerang-Semarang" id="rute" name="rute" required/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="trip_a" class="col-2">Trip A</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Posisi Awal" id="trip_a" name="trip_a" required/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="trip_b" class="col-2">Trip B</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Posisi Akhir" id="trip_b" name="trip_b" required/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="color" class="col-sm-2">Warna Marker</label>
                                    <div class="col-10">
                                        <input type="color" class="form-control" id="color" name="color" placeholder="#000000" required/>
                                    </div>
                                </div>
                            </form>
                            <hr class="mt-3">
                            <div class="text-left mt-3 offset-2">
                                <button type="button" class="btn btn-secondary w-sm" id="batal">Batal</button>
                                &nbsp;
                                <button type="submit" class="btn btn-primary w-sm" id="simpan">Simpan</button>
                            </div>
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
        id: 'cekpos',
        url: '/findkelompokpos',
        placeholder: 'Pilih Pos',
        params: null
    }];

    $(document).ready(function() {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);
        console.log(today);
        $('#dob').val(today);
        $('#dob').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            endDate: today,
            startView: 2,
            orientation: "bottom auto",
        });

        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };
        // coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder: 'Data pegawai berhasil ditambahkan',
            afterAction: function(result) {
                // $('#tab-data').addClass('active show');
                // $('#tab-form').removeClass('active show');
                // coreEvents.table.ajax.reload();
            }
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
<style>
    #sig-canvas {
        border: 2px dotted #CCCCCC;
        border-radius: 15px;
        cursor: crosshair;
        /* disable scroll when touch */
        touch-action: none;
    }

    .select2-container {
        width: 100% !important;
    }

    ul.list-unstyled {
        margin: 0 !important;
        padding: 0;
    }

    /* set nav-item responsive on mobile view */
    @media (max-width: 767px) {
        .nav-item {
            width: 50%;
        }
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
                            <form data-plugin="parsley" data-option="{}" id="form">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?= csrf_field(); ?>
                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <label for="jenis" class="col-form-label">Nomor IMEI</label>
                                        <select class=" custom-select select2" id="findimeialat" name="findimeialat" required></select>
                                        <!-- <select class="form-control select2" id="findimeialat" name="findimeialat" required></select> -->
                                    </div>

                                    <div class="col-md-12">
                                        <label for="jenis" class="col-form-label">Username PTA</label>
                                        <select class=" custom-select select2" id="username" name="username" required></select>
                                        <!-- <select class="form-control select2" id="findimeialat" name="findimeialat" required></select> -->
                                    </div>

                                    <div class="col-md-12">
                                        <label for="jenis" class="col-form-label">Kode Bus/Halte</label>
                                        <select class=" custom-select select2" id="bis" name="bis" required></select>
                                        <!-- <select class="form-control select2" id="findimeialat" name="findimeialat" required></select> -->
                                    </div>

                                    <div class="col-md-12">
                                        <label for="jenis" class="col-form-label">Koridor</label>
                                            <select class="custom-select" name="koridor" id="koridor" required="">
                                                <option value="" selected="">-- Pilih Jalur --</option>
                                                <option value="1A">Jalur 1A</option>
                                                <option value="1B">Jalur 1B</option>
                                                <option value="2A">Jalur 2A</option>
                                                <option value="2B">Jalur 2B</option>
                                                <option value="3A">Jalur 3A</option>
                                                <option value="3B">Jalur 3B</option>
                                                <option value="4A">Jalur 4A</option>
                                                <option value="4B">Jalur 4B</option>
                                                <option value="5A">Jalur 5A</option>
                                                <option value="5B">Jalur 5B</option>
                                                <option value="6A">Jalur 6A</option>
                                                <option value="6B">Jalur 6B</option>
                                                <option value="7">Jalur 7</option>
                                                <option value="8">Jalur 8</option>
                                                <option value="9">Jalur 9</option>
                                                <option value="10">Jalur 10</option>
                                                <option value="11">Jalur 11</option>
                                                <option value="CAD1">Jalur CAD1</option>
                                                <option value="CAD2">Jalur CAD2</option>
                                                <option value="13">Jalur 13</option>
                                                <option value="14">Jalur 14</option>
                                                <option value="15">Jalur 15</option>
                                            </select>
                                    </div>
                                    
                               
                                    <div class="col-md-12">
                                        <label for="kerusakan" class="col-form-label">Kerusakan</label>
                                        <textarea class="form-control" type="text" placeholder="Keterangan Kerusakan Alat" id="kerusakan" name="kerusakan" required ></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="penanganan" class="col-form-label">Penanganan</label>
                                        <textarea class="form-control" type="text" placeholder="Deskripsi Penanganan yang akan dilakukan" id="kerusakan" name="kerusakan" required ></textarea>
                                    </div>
        
                                    <div class="col-md-12">
                                        <label for="foto" class="col-form-label">Upload Foto Alat<br><small>(Allowed file types: png, jpg, jpeg.)</small></label>
                                            <div class="input-group mb-3">
                                                <input type="file" class="foto_upload" id="foto_upload" name="file">
                                                <div id="foto_progres" style="display: inline;"></div>
                                                <div id="foto_error" style="display: inline;"></div><br>
                                                <div class="files" id="files" style="display: inline-block; width: 200px;"></div>
                                                <input type="hidden" name="">
                                            </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <!-- //test signature -->
                                                <!-- Content -->
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <p><b>Tanda Tangan</b></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <canvas id="sig-canvas" name="rampcheck_kesimpulan_ttd_pengemudi"></canvas>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="btn btn-info btn-sm" id="sig-submitBtn">
                                                            Simpan Tanda Tangan</div>
                                                        <div class="btn btn-default btn-sm" id="sig-clearBtn">
                                                            Clear</div>
                                                        <!-- icon checked if signature is saved -->
                                                        <i class="fa fa-check" id="sig-check" style="display:none;"> Tanda Tangan Pengemudi
                                                            Tersimpan</i>
                                                    </div>
                                                </div>
                                                <div hidden>
                                                    <div class="col-md-12">
                                                        <textarea id="sig-dataUrl" class="form-control" rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <!-- //test signature -->
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
        id: 'findimeialat',
        url: '/findimeialat',
        placeholder: 'Ketik/Cari IMEI Alat',
        params: null,
    }, {
        id: 'username',
        url: '/username',
        placeholder: 'Ketik/Cari Username PTA',
        params: null
    }, {
        id: 'bis',
        url: '/bis',
        placeholder: 'Ketik/Cari Kode Bis/Halte',
        params: null
    }];

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

        select2Array.forEach(function(x) {
            coreEvents.select2Init('#' + x.id, x.url, x.placeholder, x.params);
        });

        $('#nama_tenant').on('change', function() {
            var id = $(this).val();
            console.log(id);
        });

        coreEvents.load();
    });


    $("#foto_upload").fileupload({
        url: url + '_upload',
        dataType: 'json',
        formData: {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        },
        autoUpload: false
    }).on('fileuploadadd', function(e, data) {
        var fileTypeAllowed = /.\.(gif|jpg|png|jpeg|bmp|svg)$/i;
        var fileName = data.originalFiles[0]['name'];
        var fileSize = data.originalFiles[0]['size'];

        $("#foto_error").html("");

        if (!fileTypeAllowed.test(fileName))
            $("#foto_error").html('Only images are allowed!');
        else if (fileSize > 10000000)
            $("#foto_error").html('Your file is too big! Max allowed size is: 1Mb');
        else {
            $("#foto_error").html("");
            data.submit();
        }
    }).on('fileuploaddone', function(e, data) {
        var status = data.jqXHR.responseJSON.status;
        var msg = data.jqXHR.responseJSON.msg;

        if (status == 1) {
            var path = data.jqXHR.responseJSON.path;
            $("#files").html('<div style="display: inline-block; padding: 5px;"><img style="height: 150px; border: 1px solid #000" src="' + base_url + path + '" /></div>');
            $("#banner_link").val(path);
        } else {
            $("#foto_error").html(msg);
        }
    }).on('fileuploadprogressall', function(e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $("#foto_progres").html("Proses: " + progress + "%");
        if (progress == 100) {
            $("#foto_progres").html("");
        }
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
    //         // {
    //         //     data: "fullname",
    //         //     orderable: true
    //         // },
    //         // {
    //         //     data: "telp",
    //         //     orderable: true
    //         // },
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
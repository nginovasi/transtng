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
                                            <th><span>Nama Lengkap</span></th>
                                            <th><span>Nomor Telepon</span></th>
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
                                <div class="kt-portlet__body" id="form_body">
                                    <div class="form-group row">
                                        <label for="fullname" class="col-2 col-form-label">Nama Lengkap</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" placeholder="Nama Lengkap" name="fullname" id="fullname" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="username" class="col-2 col-form-label">Username</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" placeholder="Username" name="username" id="username" required>
                                            <span class="form-text text-muted">Digunakan untuk login sistem.</span>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-2 col-form-label">Password</label>
                                        <div class="col-10">
                                            <input class="form-control ro" type="password" placeholder="Password" name="password" id="password" required>
                                            <span class="form-text text-muted">Untuk reset password hubungi administrator.</span>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Jenis Jabatan</label>
                                        <div class="col-4">
                                            <select class="custom-select form-control" name="idjab" id="idjab" required>
                                                <option value="" selected>-Pilih Jabatan-</option>
                                                <option value="5">PTA</option>
                                                <option value="4">PTS</option>
                                                <option value="3">PTA &amp; PTS</option>
                                            </select>
                                        </div>
                                        <label class="col-2 col-form-label d-flex justify-content-end">Posisi Jabatan</label>
                                        <div class="col-4">
                                            <select class="custom-select form-control" name="jabtext" id="jabtext" required>
                                                <option value="" selected>-Pilih Posisi-</option>
                                                <option value="PRAMUGARA">Pramugara</option>
                                                <option value="PRAMUGARI">Pramugari</option>
                                                <option value="TGA">TGA (Halte)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-2 col-form-label">Email</label>
                                        <div class="col-10">
                                            <input class="form-control" type="email" placeholder="Email Aktif" name="email" id="email" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="noktp" class="col-2 col-form-label">No. KTP</label>
                                        <div class="col-4">
                                            <input class="form-control" type="text" placeholder="Nomor KTP" name="noktp" id="noktp" required>
                                        </div>
                                        <label for="phone" class="col-2 col-form-label d-flex justify-content-end">No. Handphone</label>
                                        <div class="col-4">
                                            <input class="form-control" type="tel" placeholder="Nomor Handphone Aktif" name="phone" id="phone" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cob" class="col-2 col-form-label">Tempat Lahir</label>
                                        <div class="col-4">
                                            <input type="text" class="form-control" placeholder="Kota Tempat Lahir" name="cob" id="cob" required>
                                        </div>
                                        <label for="dob" class="col-2 col-form-label d-flex justify-content-end">Tanggal Lahir</label>
                                        <div class="col-4">
                                            <input type="text" class="form-control" placeholder="Tanggal Lahir" name="dob" id="dob" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="addr" class="col-2 col-form-label">Alamat</label>
                                        <div class="col-10">
                                            <textarea class="form-control" name="addr" id="addr" placeholder="Alamat Pegawai" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label>Icon</label>
                                        <input type="file" class="form-control" id="foto_upload" name="file">

                                        <input type="hidden" name="banner_link" id="banner_link" />
                                        <div id="foto_progres" style="display: inline;"></div>
                                        <div id="foto_error" style="display: inline;"></div><br>
                                        <div class="files" id="files" style="display: inline-block; width: 200px;"></div>
                                    </div> -->
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Upload Foto Profil<br><small>(Allowed file types: png, jpg, jpeg.)</small></label>
                                        <div class="col-10 d-flex align-items-center">
                                            <div class="input-group mb-3">
                                                <input type="file" class="foto_upload" id="foto_upload">
                                                <div id="foto_progres" style="display: inline;"></div>
                                                <div id="foto_error" style="display: inline;"></div><br>
                                                <div class="files" id="files" style="display: inline-block; width: 200px;"></div>
                                                <div id="banner_link"></div>
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
                $("#files").html('<div style="display: inline-block; padding: 5px;"><img style="height: 150px; border: 1px solid #000" src="' + url_ori + path + '" /></div>');
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

        coreEvents.load();
    });

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
                data: "jenis",
                orderable: true
            },
            {
                data: "tenant_name",
                orderable: true
            },
            {
                data: "tarif",
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
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
                                            <th><span>Nomor Kartu</span></th>
                                            <th><span>Jenis</span></th>
                                            <th><span>Nama</span></th>
                                            <th><span>Nomor Telepon</span></th>
                                            <th><span>Diperbaharui</span></th>
                                            <th><span>Tanggal</span></th>
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
                                    <label for="noKartu" class="col-2 col-form-label">Nomor Kartu</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Nomor Kartu" name="noKartu" id="noKartu" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jenis" class="col-2 col-form-label">Jenis Kartu</label>
                                    <div class="col-10">
                                        <select class="custom-select form-control" name="jenis" id="jenis" required>
                                            <option value="" selected="">-Pilih Jenis-</option>
                                            <option value="Regular">Regular</option>
                                            <option value="Pelajar">Pelajar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-2 col-form-label">Nama</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" placeholder="Nama" name="nama" id="nama" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tempatLahir" class="col-2 col-form-label">Tempat Lahir</label>
                                    <div class="col-4">
                                        <input type="text" class="form-control" placeholder="Kota Tempat Lahir" name="tempatLahir" id="tempatLahir" required>
                                    </div>
                                    <label for="tanggalLahir" class="col-2 col-form-label text-right">Tanggal Lahir</label>
                                    <div class="col-4">
                                        <input type="text" class="form-control" placeholder="Tanggal Lahir" name="tanggalLahir" id="tanggalLahir" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jenisKelamin" class="col-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-4">
                                        <select class="custom-select form-control" name="jenisKelamin" id="jenisKelamin" required>
                                            <option value="" selected="">-Pilih Jenis Kelamin-</option>
                                            <option value="Regular">Laki-laki</option>
                                            <option value="Pelajar">Perempuan</option>
                                        </select>
                                    </div>
                                    <label for="identitas" class="col-2 col-form-label text-right">Pekerjaan</label>
                                    <div class="col-4">
                                        <input class="form-control" type="text" placeholder="Pekerjaan" name="pekerjaan" id="pekerjaan" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="identitas" class="col-2 col-form-label">No. Identitas</label>
                                    <div class="col-4">
                                        <input class="form-control" type="text" placeholder="Nomor KTP/NIS" name="identitas" id="identitas" required>
                                    </div>
                                    <label for="noTelp" class="col-2 col-form-label text-right">No. Handphone</label>
                                    <div class="col-4">
                                        <input class="form-control" type="tel" placeholder="Nomor Handphone Aktif" name="noTelp" id="noTelp" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="namaPerusahaan" class="col-2 col-form-label">NamaInstansi</label>
                                    <div class="col-4">
                                        <input class="form-control" type="text" placeholder="Instansi/Sekolah" name="namaPerusahaan" id="namaPerusahaan" required>
                                    </div>
                                    <label for="keterangan" class="col-2 col-form-label text-right">Keterangan</label>
                                    <div class="col-4">
                                        <input class="form-control" type="tel" placeholder="Keterangan" name="keterangan" id="keterangan" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="alamat" class="col-2 col-form-label">Alamat</label>
                                    <div class="col-10">
                                        <textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat" rows="3"></textarea>
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

    // const select2Array = [{
    //     id: 'cekpos',
    //     url: '/findkelompokpos',
    //     placeholder: 'Pilih Pos',
    //     params: null
    // }];

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
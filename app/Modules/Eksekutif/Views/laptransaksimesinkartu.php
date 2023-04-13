<style>
    .select2-container {
        width: 100% !important;
    }

    .ui-datepicker-calendar {
        display: none;
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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data-harian" role="tab" aria-controls="tab-data-harian" aria-selected="true"><i class="fa fa-calendar" aria-hidden="true"></i> Harian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-data-bulan" role="tab" aria-controls="tab-data-bulan" aria-selected="false"><i class="fa fa-calendar-o" aria-hidden="true"></i> Bulanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-data-tahun" role="tab" aria-controls="tab-data-tahun" aria-selected="false"><i class="fa fa-calendar-o" aria-hidden="true"></i> Tahunan</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data-harian" role="tabpanel" aria-labelledby="tab-data-harian">
                            <form data-plugin="parsley" data-option="{}" id="form" method="post">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?= csrf_field(); ?>
                                <div class="form-group row d-flex">
                                    <div class="col-md-4">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="pilihtanggal" name="pilihtanggal" placeholder="Pilih Tanggal" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="form-group row ">
                                            <label class="col-sm-10 col-form-label text-right">Tampilkan Transaksi Test</label>
                                            <div class="col-sm-2">
                                                <label class="ui-switch ui-switch-lg dark mt-1 mr-2">
                                                    <input type="checkbox" id="isTestHarian" name="isTest" value="true">
                                                    <i></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr class="mt-3">
                        </div>
                        <div class="tab-pane fade" id="tab-data-bulan" role="tabpanel" aria-labelledby="tab-data-bulan">
                            <form data-plugin="parsley" data-option="{}" id="form" method="post">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?= csrf_field(); ?>
                                <div class="form-group row d-flex">
                                    <div class="col-md-4">
                                        <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="pilihbulan" name="pilihbulan" placeholder="Pilih bulan" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="form-group row ">
                                            <label class="col-sm-10 col-form-label text-right">Tampilkan Transaksi Test</label>
                                            <div class="col-sm-2">
                                                <label class="ui-switch ui-switch-lg dark mt-1 mr-2">
                                                    <input type="checkbox" id="isTestHarian" name="isTest" value="true">
                                                    <i></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr class="mt-3">
                        </div>
                        <div class="tab-pane fade" id="tab-data-tahun" role="tabpanel" aria-labelledby="tab-data-tahun">
                            <form data-plugin="parsley" data-option="{}" id="form" method="post">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?= csrf_field(); ?>
                                <div class="form-group row d-flex">
                                    <div class="col-md-4">
                                        <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="pilihtahun" name="pilihtahun" placeholder="Pilih Tahun" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="form-group row ">
                                            <label class="col-sm-10 col-form-label text-right">Tampilkan Transaksi Test</label>
                                            <div class="col-sm-2">
                                                <label class="ui-switch ui-switch-lg dark mt-1 mr-2">
                                                    <input type="checkbox" id="isTestHarian" name="isTest" value="true">
                                                    <i></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
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
    const url_pdf_pnp = '<?= base_url() . "/" . uri_segment(0) . "/action/pdf/" . uri_segment(1) . "" ?>';
    const url_excel_pnp = '<?= base_url() . "/" . uri_segment(0) . "/action/excel/" . uri_segment(1) . "" ?>';

    var dataStart = 0;
    var coreEvents;

    $(document).ready(function() {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);
        
        $('#pilihtanggal').datepicker({
            format: 'DD dd',
            autoclose: true,
            todayHighlight: true,
            endDate: today,
            minViewMode: 0,
            orientation: "bottom auto",
        }).on('changeDate', function(e) {
            const tanggal = e.format('yyyy-mm-dd');
            // your code here...
        });

        $('#pilihbulan').datepicker({
            format: 'MM',
            autoclose: true,
            todayHighlight: true,
            endDate: today,
            minViewMode: 1,
            orientation: "bottom auto",
        }).on('changeDate', function(e) {
            const bulan = e.format('mm');
            // your code here...
        });

        $('#pilihtahun').datepicker({
            format: 'yyyy',
            autoclose: true,
            todayHighlight: true,
            endDate: today,
            minViewMode: 2,
            orientation: "bottom auto",
        }).on('changeDate', function(e) {
            const tahun = e.format('yyyy');
            // your code here...
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

        coreEvents.load(null, [0, 'asc'], null);
    });
</script>
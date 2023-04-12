<style>
    .select2-container {
        width: 100% !important;
    }

    .cekpta-menu {
        position: absolute;
        transform: translate3d(-60px, 34px, 0px) !important;
        top: -107px !important;
        left: 0px;
        will-change: transform;
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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="true"><i class="fa fa-exchange" aria-hidden="true"></i> Transaksi Harian PTA</a>
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
                                    <div class="input-group input-daterange mb-3 col-md-10">
                                        <input type="text" class="form-control" name="start" id="startDate" placeholder="Pilih Tanggal Awal" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="end" id="endDate" placeholder="Pilih Tanggal Akhir" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-sm" id="simpan"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
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
        $('#startDate').val(today);
        $('#endDate').val(today);

        $('#input-daterange').each(function() {
            $(this).datepicker('clearDates');
        });

        $('#startDate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startView: 0,
            endDate: today,
            orientation: "bottom auto",
        }).on('changeDate', function(e) {
            const tanggal = e.format('yyyy-mm-dd');
            console.log(tanggal);
            $('span.input-group-text').html('<i class="fa fa-arrows-h" aria-hidden="true"></i>');
            // your code here...
        }).on('click', function(e) {
            $('span.input-group-text').html('<i class="fa fa-long-arrow-left" aria-hidden="true"></i>');
        })

        $('#endDate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startView: 0,
            endDate: today,
            orientation: "bottom auto",
        }).on('changeDate', function(e) {
            const tanggal = e.format('yyyy-mm-dd');
            console.log(tanggal);
            $('span.input-group-text').html('<i class="fa fa-arrows-h" aria-hidden="true"></i>');
            // your code here...
        }).on('click', function(e) {
            $('span.input-group-text').html('<i class="fa fa-long-arrow-right" aria-hidden="true"></i>');
        })

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
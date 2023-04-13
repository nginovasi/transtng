<style>
    .select2-container {
        /* width: 100% !important; */
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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="true"><i class="fa fa-exchange" aria-hidden="true"></i> Transaksi Penumpang Perjam Jalur</a>
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
                                    <div class="input-group input-daterange mb-3 col-md-5">
                                        <input type="text" class="form-control" name="start" id="startDate" placeholder="Pilih Tanggal Awal" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="end" id="endDate" placeholder="Pilih Tanggal Akhir" required>
                                    </div>
                                    <div class="input-group mb-3 col-md-5">
                                        <select class="custom-select form-control" name="koridor" id="koridor" required="">
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

        select2Array.forEach(function(x) {
            coreEvents.select2Init('#' + x.id, x.url, x.placeholder, x.params);
        });

        coreEvents.load(null, [0, 'asc'], null);
    });
</script>
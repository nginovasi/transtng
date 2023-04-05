<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    .select2-container {
        width: 100% !important;
    }

    #reportrange {
        background: #fff;
        cursor: pointer;
        padding: 5px 10px;
        border: 1px solid #ccc;
        width: 100%;
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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="false">Laporan Data Harian</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                        <div class="card-body">
                            <form data-plugin="parsley" data-option="{}" id="form-print" name="form-print" action="<?= base_url() . "/" . uri_segment(0) . "/action/pdf/lapspda/p?o=p" ?>" target="_blank" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <div class="form-group">
                                    <label for="category_id">Jenis Laporan</label>
                                    <select class="form-control" name="opsi" id="opsi" required>
                                        <option value="0">Pilih Jenis Laporan</option>
                                        <option value="1">Laporan Harian</option>
                                        <option value="2">Laporan Bulanan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Kategori Angkutan</label>
                                    <select class="form-control" id="kategori_angkutan_id" name="kategori_angkutan_id" required></select>
                                </div>
                                <div class="form-group">
                                    <label for="trayek_id">Trayek</label>
                                    <select class="form-control" id="trayek_id" name="trayek_id" required></select>
                                </div>
                                <div class="form-group" style="display:none" id="date_search">
                                    <label for="spda_date">Tanggal</label>
                                    <input type="date" name="spda_date" id="spda_date" class="form-control">
                                </div>
                                <div class="row" style="display:none" id="month_search">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="spda_month">Bulan</label>
                                            <select class="form-control" id="spda_month" name="spda_month">
                                                <option value="">Pilih Bulan</option>
                                                <option value="01">Januari</option>
                                                <option value="02">Februari</option>
                                                <option value="03">Maret</option>
                                                <option value="04">April</option>
                                                <option value="05">Mei</option>
                                                <option value="06">Juni</option>
                                                <option value="07">Juli</option>
                                                <option value="08">Agustus</option>
                                                <option value="09">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="spda_year">Tahun</label>
                                            <select class="form-control" id="spda_year" name="spda_year">
                                                <option value="">Pilih Tahun</option>
                                                <?php for ($i = 2022; $i <= date('Y'); $i++) { ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="text-right">
                                    <button class="btn btn-primary download" title="download">Lihat Laporan</button>
                                    <button class="btn btn-sm btn-outline-success download" title="download"><i class="fa fa-print"></i></button></a>
                                </div> -->
                            </form>
                            <a href="#" class="view-pdf btn btn-primary pull-right"><i class="fa fa-eye"></i> Lihat Laporan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- .modal -->
<div class="modal fade" id="modal_lapspda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" id="modal_body_lapspda">
                <!-- create table -->
                <table class="table table-bordered table-hover table-checkable" id="table_lapspda" style="margin-top: 13px !important">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori Angkutan</th>
                            <th>Plat Armada</th>
                            <th>Nama Armada</th>
                            <th>Kapasitas Armada</th>
                            <th>Nama Rute</th>
                            <th>Tanggal SPDA</th>
                            <th>Jumlah Bus</th>
                            <th>Jumlah Rit Bus</th>
                            <th>Total Penumpang</th>
                            <th>Load Factor</th>
                        </tr>
                    </thead>
                    <tbody id="table_lapspda_body">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <a href="#" class="exp-pdf btn btn-primary pull-right"><i class="fa fa-file-pdf-o"></i>&nbsp;Download Laporan </a>
            </div>
        </div>
    </div>
</div>
<!-- / .modal -->

<script type="text/javascript">
    const auth_insert = '<?= $rules->i ?>';
    const auth_edit = '<?= $rules->e ?>';
    const auth_delete = '<?= $rules->d ?>';
    const auth_otorisasi = '<?= $rules->o ?>';

    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';
    console.log(url_ajax);
    const url_pdf_lapspda = '<?= base_url() . "/" . uri_segment(0) . "/action/pdf/lapspda" ?>';
    var url_pdf;

    var dataStart = 0;
    var coreEvents;

    const select2Array = [{
            id: 'kategori_angkutan_id',
            url: '/kategori_angkutan_id_select_get',
            placeholder: 'Pilih Kategori Angkutan',
            params: null
        },
        {
            id: 'trayek_id',
            url: '/trayek_id_select_get',
            placeholder: 'Pilih Trayek',
            params: {
                kategori_angkutan_id: function() {
                    return $('#kategori_angkutan_id').val()
                }
            }
        }
    ];

    $(document).ready(function() {
        $('.bulanan').hide();

        $('#kategori_angkutan_id').on('change', function() {
            $('#trayek_id').val(null).trigger('change');
        });

        $('#trayek_id').on('select2:select', function(e) {
            var data = e.params.data;

            $.ajax({
                url: url_ajax + '/route_distance_select_get',
                type: 'GET',
                dataType: 'json',
                data: {
                    id: data.id,
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
                success: function(result) {
                    $('#jrk_tempuh_spda').val(result[0].route_distance);
                    $('#wkt_tempuh_spda').val(result[0].route_time);
                }
            });
        });

        $('#opsi').on('change', function() {
            if (this.value == '1') {
                $('#date_search').show();
                $('#date_search').find('input').attr('required', true);
                $('#month_search').hide();
                $('#month_search').find('select').attr('required', false);
                $('#spda_year').attr('required', false);
            } else if (this.value == '2') {
                $('#date_search').hide();
                $('#date_search').find('input').attr('required', false);
                $('#month_search').show();
                $('#month_search').find('select').attr('required', true);
                $('#spda_year').attr('required', true);
            }
        });

        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };

        coreEvents.insertHandler = {
            placeholder: 'Berhasil menyimpan data petugas lapangan',
            afterAction: function(result) {
                window.location.reload();
            }
        }
        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {}
        }
        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus data form SPDA',
            afterAction: function() {
                window.location.reload();
            }
        }
        coreEvents.resetHandler = {
            action: function() {}
        }

        coreEvents.load();

        select2Array.forEach(function(x) {
            select2Init('#' + x.id, x.url, x.placeholder, x.params);
        });

        $(document).on('click', 'a.view-pdf', function() {
            Swal.fire({
                title: "Lihat data ?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Lihat",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    // $('#form-print').submit();
                    console.log($('#form-print').serialize());
                    // die();
                    $.ajax({
                        url: url + '_save',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#form-print').serialize(),
                        success: function(result) {
                            if (result.success) {
                                console.log(result);
                                $('#modal_lapspda').modal('show');
                                for (var i = 0; i < result.data.length; i++) {
                                    var $no = 1;
                                    $('#table_lapspda_body').append(`
                                        <tr>
                                            <td>${$no++}</td>
                                            <td>${result.data[i].kategori_angkutan_name}</td>
                                            <td>${result.data[i].armada_plat_number}</td>
                                            <td>${result.data[i].armada_name}</td>
                                            <td>${result.data[i].armada_kapasitas}</td>
                                            <td>${result.data[i].route_name}</td>
                                            <td>${result.data[i].tgl_spda}</td>
                                            <td>${result.data[i].jml_bus}</td>
                                            <td>${result.data[i].ritase_spda}</td>
                                            <td>${result.data[i].ttl_penumpang_spda}</td>
                                            <td>${result.data[i].load_factor}</td>
                                        </tr>
                                    `);
                                }
                            } else {
                                Swal.fire({
                                    title: "Gagal",
                                    icon: "error",
                                    text: "Gagal menampilkan data",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Batal",
                        icon: "error",
                        text: "Batal menampilkan data",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return false;
                }
            })
        });

        $(document).on('click', 'a.exp-pdf', function() {
            Swal.fire({
                title: "Download data ?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Download",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $('#form-print').submit();
                } else {
                    Swal.fire({
                        title: "Batal",
                        icon: "error",
                        text: "Download data dibatalkan",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return false;
                }
            })
        });

        // $(document).on('submit', '#form', function(e) {
        //     e.preventDefault();
        //     Swal.fire({
        //         title: "Simpan data ?",
        //         icon: "question",
        //         showCancelButton: true,
        //         confirmButtonText: "Simpan",
        //         cancelButtonText: "Batal",
        //         reverseButtons: true
        //     }).then(function(result) {
        //         if (result.value) {
        //             Swal.fire({
        //                 title: "",
        //                 icon: "info",
        //                 text: "Proses menyimpan data, mohon ditunggu...",
        //                 didOpen: function() {
        //                     Swal.showLoading()
        //                 }
        //             });
        //             $.ajax({
        //                 url: url + "_save",
        //                 type: 'post',
        //                 data: $('#form').serialize() + "&form_spda_ttd_pengemudi=" +
        //                     sigText + "&form_spda_ttd_manager=" + sigTextManager,
        //                 dataType: 'json',
        //                 success: function(result) {
        //                     Swal.close();
        //                     if (result.success) {
        //                         Swal.fire('Sukses', result.message, 'success');
        //                         window.location.reload();
        //                     } else {
        //                         Swal.fire('Error', result.message, 'error');
        //                     }
        //                 },
        //                 error: function() {
        //                     Swal.close();
        //                     Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
        //                     window.location.reload();
        //                 }
        //             });
        //             console.log(result);
        //         }
        //     });
        // });

        $('#spda_date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            minYear: 2000,
            maxYear: parseInt(moment().format('YYYY'), 10)
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });
    });

    function select2Init(id, url, placeholder, parameter) {
        $(id).select2({
            id: function(e) {
                return e.id
            },
            placeholder: placeholder,
            multiple: false,
            ajax: {
                url: url_ajax + url,
                dataType: 'json',
                quietMillis: 500,
                delay: 500,
                data: function(param) {
                    var def_param = {
                        keyword: param.term, //search term
                        perpage: 5, // page size
                        page: param.page || 0, // page number
                    };

                    return Object.assign({}, def_param, parameter);
                },
                processResults: function(data, params) {
                    params.page = params.page || 0

                    return {
                        results: data.rows,
                        pagination: {
                            more: false
                        }
                    }
                }
            },
            templateResult: function(data) {
                return data.text;
            },
            templateSelection: function(data) {
                if (data.id === '') {
                    return placeholder;
                }

                return data.text;
            },
            escapeMarkup: function(m) {
                return m;
            }
        });
    }
</script>
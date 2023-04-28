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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="false">Laporan Rekonsiliasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-form" role="tab" aria-controls="tab-form" aria-selected="false">Rekap Rekonsiliasi</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <!-- <label>Cek File Settlement Dari</label> -->
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2">
                                                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control form-control-md date" name="date-start" id="date-start" placeholder="Pilih Tanggal Awal" required autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <!-- <label>Pilih Bank</label> -->
                                                        <select class=" custom-select select2" id="laprekon" name="laprekon" required></select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <!-- <label>&nbsp;</label> -->
                                                        <div class="input-group">
                                                            <a href="#" id="cetaklaporan" class="btn btn-primary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer mx-2">
                                                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                                                    <rect x="6" y="14" width="12" height="8"></rect>
                                                                </svg>
                                                                Lihat Summary
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                            <form data-plugin="parsley" data-option="{}" id="form">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?= csrf_field() ?>
                                <div class="table-responsive">
                                <div class="row">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <!-- <label>Cek File Settlement Dari</label> -->
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2">
                                                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control form-control-md date" name="rekap-date-start" id="rekap-date-start" placeholder="Pilih Tanggal Awal" required autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <!-- <label>Pilih Bank</label> -->
                                                        <select class=" custom-select select2" id="rekaprekon" name="rekaprekon" required></select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <!-- <label>&nbsp;</label> -->
                                                        <div class="input-group">
                                                            <a href="#" id="cetaklaporan" class="btn btn-primary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer mx-2">
                                                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                                                    <rect x="6" y="14" width="12" height="8"></rect>
                                                                </svg>
                                                                Lihat Rekap
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

    const url = '<?=base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1)?>';
    const url_ajax = '<?=base_url() . "/" . uri_segment(0) . "/ajax"?>';

    var dataStart = 0;
    var coreEvents;

    const select2Array = [{
        id: 'laprekon',
        url: '/laprekon',
        placeholder: 'Pilih Bank',
        params: null
    },{
        id: 'rekaprekon',
        url: '/rekaprekon',
        placeholder: 'Pilih Bank',
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

        $('#date-start').each(function() {}).on('changeDate', function() {
            dateParamStart = $(this).val();
            console.log(dateParamStart);
            coreEvents.filter = [$('#date-start').val()];
            // $('#cetaklaporan').attr('href', url_pdf_cetak + '/p?o=p&search=' + btoa(dateParam));
           
            $(this).datepicker('hide');
        });

        $('#rekap-date-start').each(function() {}).on('changeDate', function() {
            dateParamStart = $(this).val();
            console.log(dateParamStart);
            coreEvents.filter = [$('#rekap-date-start').val()];
            // $('#cetaklaporan').attr('href', url_pdf_cetak + '/p?o=p&search=' + btoa(dateParam));
           
            $(this).datepicker('hide');
        });

        coreEvents.datepicker('#date-start', 'yyyy-mm-dd')
        coreEvents.datepicker('#rekap-date-start', 'yyyy-mm-dd')


        coreEvents.load();
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
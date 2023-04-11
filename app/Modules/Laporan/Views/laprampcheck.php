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
                                            <th><span>Bulan</span></th>
                                            <th><span>Tahun</span></th>
                                            <th><span>Total Rampcheck</span></th>
                                            <th class="column-2action"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
            placeholder: 'Berhasil menyimpan data kspn',
            afterAction: function(result) {}
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
                $('#idprov').html('<option value = "' + result.data.lokprov_id + '" selected >' + result
                    .data.prov + '</option>');
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus data kspn',
            afterAction: function() {

            }
        }

        coreEvents.resetHandler = {
            action: function() {

            }
        }

        coreEvents.load();

        select2Array.forEach(function(x) {
            select2Init('#' + x.id, x.url, x.placeholder, x.params);
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


    function datatableColumn() {
        let columns = [{
                data: "rampcheck_month + ' ' + rampcheck_year",
                orderable: false,
                width: 100,
                render: function(a, type, data, index) {
                    return dataStart + index.row + 1
                }
            },
            {
                data: "rampcheck_month",
                orderable: true,
                render: function(a, type, data, index) {
                    let month = data.rampcheck_month;
                    let monthName = '';

                    switch (month) {
                        case '1':
                            monthName = 'Januari';
                            break;
                        case '2':
                            monthName = 'Februari';
                            break;
                        case '3':
                            monthName = 'Maret';
                            break;
                        case '4':
                            monthName = 'April';
                            break;
                        case '5':
                            monthName = 'Mei';
                            break;
                        case '6':
                            monthName = 'Juni';
                            break;
                        case '7':
                            monthName = 'Juli';
                            break;
                        case '8':
                            monthName = 'Agustus';
                            break;
                        case '9':
                            monthName = 'September';
                            break;
                        case '10':
                            monthName = 'Oktober';
                            break;
                        case '11':
                            monthName = 'November';
                            break;
                        case '12':
                            monthName = 'Desember';
                            break;
                    }

                    return monthName;
                }
            },
            {
                data: "rampcheck_year",
                orderable: true
            },
            {
                data: "ttl_rampcheck",
                orderable: true
            },
            {
                data: "rampcheck_month + ' ' + rampcheck_year",
                orderable: false,
                render: function(a, type, data, index) {
                    let button = ''

                    if (auth_edit == "1") {
                        button += '<a href="<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>_download/' + data.rampcheck_month + '/' + data.rampcheck_year + '" target="_blank" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Download PDF">\
                                    <i class="fa fa-file-pdf-o"></i>\
                                </a>'
                                
                    }

                    button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

                    return button;
                }
            }
        ];

        return columns;
    }

    // onclick button download
    $(document).on('click', '.download', function() {
        let param = $(this).data('id');
        var rampcheckMonth = param.split('%')[0];
        var rampcheckYear = param.split('%')[1];
        
        
        $.ajax({
            url: url + '_download',
            type: 'POST',
            data: {
                rampcheckMonth: rampcheckMonth,
                rampcheckYear: rampcheckYear,
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            },
            success: function(result) {
                console.log(result);
            }
        });
    });
    
</script>
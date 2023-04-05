<!-- style internal -->
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
                                            <th><span>Email</span></th>
                                            <th><span>Nama</span></th>
                                            <th><span>No Telp</span></th>
                                            <th><span></span></th>
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
                                <div class="form-group">
                                    <label>Nama Armada Mudik</label>
                                    <select class="form-control sel2" id="jadwal_armada_id" name="jadwal_armada_id" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Keberangkatan Bis</label>
                                    <input type="text" class="form-control form-control-md date" name="jadwal_date_depart" id="jadwal_date_depart" placeholder="Tanggal Kedatangan Bis" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Waktu Keberangkatan Bis</label>
                                    <input type="time" class="form-control form-control-md date" name="jadwal_time_depart" id="jadwal_time_depart" placeholder="Waktu Kedatangan Bis" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Kedatangan Bis</label>
                                    <input type="text" class="form-control form-control-md date" name="jadwal_date_arrived" id="jadwal_date_arrived" placeholder="Tanggal Sampai Bis" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Waktu Kedatangan Bis</label>
                                    <input type="time" class="form-control form-control-md date" name="jadwal_time_arrived" id="jadwal_time_arrived" placeholder="Waktu Sampai Bis" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Rute</label>
                                    <select class="form-control sel2" id="jadwal_route_id" name="jadwal_route_id" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Arus</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jadwal_type" id="jadwal_type1" value="1">
                                        <label class="form-check-label" for="jadwal_type1">Mudik</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jadwal_type" id="jadwal_type2" value="2">
                                        <label class="form-check-label" for="jadwal_type2">Balik</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status Jadwal</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="open" id="open1" value="1">
                                        <label class="form-check-label" for="open1">Open</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="open" id="open0" value="0">
                                        <label class="form-check-label" for="open0">Closed</label>
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


<!-- modal -->
<div class="modal fade" id="modal_blue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLabel">List File</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" id="modal_body_blue">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->

<!-- script internal -->
<script type="text/javascript">
    const auth_insert = '<?= $rules->i ?>';
    const auth_edit = '<?= $rules->e ?>';
    const auth_delete = '<?= $rules->d ?>';
    const auth_otorisasi = '<?= $rules->o ?>';

    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';

    var dataStart = 0;
    var coreEvents;

    const select2Array = [
    ];

    $(document).ready(function() {
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };
        coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder: 'Berhasil menyimpan data ...',
            afterAction: function(result) {
            }
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus data ...',
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
                data: "id",
                orderable: false,
                width: 100,
                render: function(a, type, data, index) {
                    return dataStart + index.row + 1
                }
            },
            {
                data: "user_mobile_name",
                orderable: true
            },
            {
                data: "user_mobile_email",
                orderable: true
            },
            {
                data: "user_mobile_phone",
                orderable: true,
                render: function(a, type, data, index) {
                    let button = ''

                    if (data.user_mobile_phone) {
                        button += data.user_mobile_phone
                    } else {
                        button += "-"
                    }

                    return button;
                }
            },
            {
                data: "id",
                orderable: false,
                render: function(a, type, data, index) {
                    let button = ''

                    button += '<button class="btn btn-sm btn-outline-primary mr-2 show-detail" data-id="'+data.id+'" data-toggle="tooltip" data-placement="top" title="show">\
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye mx-2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>\
                        </button>\
                        ';

                    return button;
                }
            }
        ];

        return columns;
    }
</script>
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
                                <table id="datatable" class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Instansi Detail Name</span></th>
                                            <th class="column-2action"></th>
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
                                    <label>Nama Profile Instansi</label>
                                    <input type="text" class="form-control" id="instansi_detail_name" name="instansi_detail_name" required autocomplete="off" placeholder="Nama profile instansi">
                                </div>
                                <div class="code-dinamic">
                                    <div class="form-group code code0">
                                        <label>Satuan Kerja Tingkat 1</label>
                                        <select class="form-control codeselect sel2" id="code0" name="code[]">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control sel2" id="user_web_role" name="user_web_role" required>
                                    </select>
                                </div>
                                <div class="text-right">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
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

    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';

    var dataStart = 0;
    var coreEvents;

    const select2Array = [
        {
            id: 'code0',
            url: '/parent_1_id_select_get',
            placeholder: 'Pilih Satuan Kerja',
            params: null
        },
        {
            id: 'user_web_role',
            url: '/user_web_role_id_select_get',
            placeholder: 'Pilih User Role',
            params: null
        },
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
            placeholder: 'Berhasil menyimpan data instansi',
            afterAction: function(result) {
                window.location.reload();
            }
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
                $('.code-dinamic').html('')

                let resultKode = result.data.kode.split('.')
                let codeTemporary = ""
                for(let i = 0; i < resultKode.length; i++) {
                    if(i == 0) {
                        $(".code-dinamic").append(`
                            <div class="form-group code code0">
                                <label>Satuan Kerja Tingkat 1</label>
                                <select class="form-control codeselect sel2" id="code0" name="code[]">
                                </select>
                            </div>
                        `)

                        select2Init('#code0', '/parent_1_id_select_get', 'Pilih Satuan Kerja', null)
                    } else {
                        if(i == 1) {
                            codeTemporary += resultKode[i]
                        } else {
                            codeTemporary += '.' + resultKode[i]
                        }
                        
                        $(".code-dinamic").append(`
                            <div class="form-group code code${i}">
                                <label>Satuan Kerja Tingkat ${i + 1}</label>
                                <select class="form-control codeselect sel2" id="code${i}" name="code[]">
                                </select>
                            </div>
                        `)

                        select2Init('#code' + i, '/parent_est_id_select_get', 'Pilih Satuan Kerja', {id_parent:  codeTemporary})
                    }

                    var csrf = {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    };

                    var data = {
                        id: resultKode[i]
                    }

                    $.extend(data, csrf);

                    $.ajax({
                        url: url_ajax + "/selected_append_instansi_detail",
                        type: 'post',
                        data: data,
                        dataType: 'json',
                        success: function(result) {
                            $('#code' + i).select2('trigger', 'select', {
                                data: {
                                    id: result.id,
                                    text: result.instansi_detail_name
                                }
                            });
                        },
                        async: false
                    });

                    $(".code" + i).css("pointer-events","none");

                    if(i == resultKode.length - 1) {
                        $('.code' + (i + 1)).remove()              
                    }
                }

                $('#user_web_role').select2('trigger', 'select', {
                    data: {
                        id: result.data.user_web_role_id,
                        text: result.data.user_web_role_name
                    }
                });
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus data instansi',
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

        let kode = ""
        $(".code-dinamic").on("change", '.codeselect', function() {  
            let parent_id = $('.codeselect').last().val() != null ? $('.codeselect').last().val() : $('#code0').val()
            let countClass = $('.codeselect').length

            if(kode == "" ) {
                kode += parent_id
            } else {
                kode += '.' + parent_id
            }

            // let kodeAfterTemporary = ""
            if($('#code0').val() != kode.split('.').map(Number).filter(Number)[0]) {
                for(let x = 0; x < kode.split('.').map(Number).filter(Number).length; x++ ) {
                    if($('#code0').val() == kode.split('.').map(Number).filter(Number)[x]) {
                        kode = kode.split('.').map(Number).filter(Number).slice(x)
                        kode = kode.join(",")
                        break
                    }
                }
            }

            if((countClass - 1) != parseInt($(this).attr('id').match(/\d+$/)[0])) {
                let getAllKode = kode.split('.').map(Number).filter(Number)

                let kodeTemporary = ""
                let idNow = parseInt($(this).attr('id').match(/\d+$/)[0])

                let cekKode = $.each(getAllKode, function(index, value) {
                    if(index < idNow && index == 0) {
                        kodeTemporary += value
                    } else if(index < idNow && index > 0) (
                        kodeTemporary += "." + value
                    )
                })

                if(kodeTemporary.length == 0) {
                    kodeTemporary += $('#code' + idNow).val()
                } else {
                    kodeTemporary += "." + $('#code' + idNow).val()
                }

                $('.' + $(this).attr('id')).nextAll('.code').remove();   

                $(".code-dinamic").append(`
                    <div class="form-group code code${(parseInt($(this).attr('id').match(/\d+$/)[0]) + 1)}">
                        <label>Satuan Kerja Tingkat ${(parseInt($(this).attr('id').match(/\d+$/)[0]) + 2)}</label>
                        <select class="form-control codeselect sel2" id="code${(parseInt($(this).attr('id').match(/\d+$/)[0]) + 1)}" name="code[]">
                        </select>
                    </div>
                `)

                select2Init('#' + 'code' + (parseInt($(this).attr('id').match(/\d+$/)[0]) + 1), '/parent_est_id_select_get', 'Pilih Satuan Kerja', {id_parent: kodeTemporary})
            } else {
                $(".code-dinamic").append(`
                    <div class="form-group code code${countClass}">
                        <label>Satuan Kerja Tingkat ${countClass + 1}</label>
                        <select class="form-control codeselect sel2" id="code${countClass}" name="code[]">
                        </select>
                    </div>
                `)

                select2Init('#' + 'code' + countClass, '/parent_est_id_select_get', 'Pilih Satuan Kerja', {id_parent:  kode})
            }
        })
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
                data: "instansi_detail_name",
                orderable: true
            },
            {
                data: "id",
                orderable: false,
                render: function(a, type, data, index) {
                    let button = ''
                    if (auth_edit == "1") {
                        button += '<button class="btn btn-sm btn-outline-primary edit" data-id="' + data.id + '" title="Edit">\
                                    <i class="fa fa-edit"></i>\
                                </button>\
                                ';
                    }

                    if (auth_delete == "1") {
                        button += '<button class="btn btn-sm btn-outline-danger delete" data-id="' + data.id + '" title="Delete">\
                                        <i class="fa fa-trash-o"></i>\
                                    </button></div>';
                    }


                    button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

                    return button;
                }
            }
        ];

        return columns;
    }
</script>
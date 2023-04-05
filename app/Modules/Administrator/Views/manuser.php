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
                                            <th><span>Nama User</span></th>
                                            <th><span>Email User</span></th>
                                            <th><span>Username</span></th>
                                            <th><span>Jenis User</span></th>
                                            <th><span>Instansi</span></th>
                                            <th><span>NIP</span></th>
                                            <th><span>Foto</span></th>
                                            <th></th>
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
                                    <label>Nama</label>
                                    <input type="text" class="form-control" id="user_web_name" name="user_web_name" required autocomplete="off" placeholder="Nama lengkap user" maxlength="50">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" id="user_web_email" name="user_web_email" required autocomplete="off" placeholder="email user" maxlength="50">
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" id="user_web_username" name="user_web_username" required autocomplete="off" placeholder="username user untuk login" maxlength="30">
                                </div>
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" class="form-control" id="user_web_nik" name="user_web_nik" autocomplete="off" placeholder="nik user" maxlength="25">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="user_web_password" name="user_web_password" required autocomplete="off" placeholder="password user untuk login" maxlength="32">
                                </div>
                                <?php
                                    if($user->instansi_detail_id == null) {
                                ?>
                                    <div class="form-group">
                                        <label>Jenis User</label>
                                        <select class="form-control" id="user_web_role_id" name="user_web_role_id" required>
                                            <option></option>
                                            <?php
                                                foreach ($jenisusers as $jenisuser) {
                                                    echo '<option value="' . $jenisuser->id . '">' . $jenisuser->user_web_role_name . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                <?php
                                    } else {
                                ?>
                                     <div class="form-group">
                                        <label>Instansi</label>
                                        <select class="form-control sel2 instansi_detail_id_not_role" id="instansi_detail_id_not_role" name="instansi_detail_id_not_role">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                <?php
                                    }
                                ?>
                                <div class="code-dinamic">

                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-reset">Batal</button>
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
            id: 'instansi_detail_id_not_role',
            url: '/instansi_detail_id_select_get',
            placeholder: 'Pilih Instansi',
            params: null
        }
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
            placeholder: 'Berhasil menyimpan user',
            afterAction: function(result) {

            }
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
                //$('#user_web_role_id').val(result.data.user_web_role_id).trigger('change');
                setTimeout(function() {
                    select2Array.forEach(function(x) {
                        console.log(x.id);
                        console.log(x.id.replace('id', 'nama'));
                        //console.log(result.data);
                        //console.log(result.data[x.id]);
                        $('#' + x.id).select2('trigger', 'select', {
                            data: {
                                id: result.data[x.id],
                                text: result.data[x.id.replace('id', 'nama')]
                            }
                        });
                    });
                }, 100);
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus user',
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

        $('#user_web_role_id').select2({
            placeholder: "Pilih jenis user"
        });

        $('#user_web_username').keypress(function (e) {
            var txt = String.fromCharCode(e.which);
            if (!txt.match(/[a-z0-9_]/)) {
                return false;
            }
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
                data: "user_web_name",
                orderable: true
            },
            {
                data: "user_web_email",
                orderable: true
            },
            {
                data: "user_web_username",
                orderable: true
            },
            {
                data: "user_web_role_name",
                orderable: true
            },
            {
                data: "instansi_detail_name",
                orderable: true,
                render: function(a, type, data, index) {
                    if(data.instansi_detail_name == null) {
                        return "-"
                    } else {
                        return data.instansi_detail_name
                    }
                }
            },
            {
                data: "user_web_nik",
                orderable: true,
                render: function(a, type, data, index) {
                    if(data.user_web_nik == null || data.user_web_nik == "") {
                        return "<span class='badge badge-danger'>NIP Belum Diinput / Diupdate</span>"
                    } else {
                        return "<span class='badge badge-success'>"+data.user_web_nik+"</span>"
                    }
                }
            },
            {
                data: "user_web_photo",
                orderable: true,
                render: function(a, type, data, index) {
                    if(data.user_web_photo == null || data.user_web_photo == "-") {
                        return "<span class='badge badge-danger'>Foto Tidak Ditemukan</span>"
                    } else {
                        return "<img src='"+data.user_web_photo+"' style='width: 50px; height: 50px; border-radius: 50%;'>"
                    }
                }
            },
            {
                data: "id",
                orderable: false,
                width: 100,
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

                    if(data.instansi_detail_id != null && data.user_mobile_role != 2) {
                        button += '<button class="btn btn-sm btn-outline-success sync" data-id="' + data.id + '" title="Delete">\
                                        SYNC\
                                    </button></div>';
                    }

                    button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

                    return button;
                }
            }
        ];

        return columns;
    }

    $("#user_web_role_id").on("change", function() {
        let id = $(this).val()

        $(".code-dinamic").html(`
            <div class="form-group">
                <label>Instansi</label>
                <select class="form-control sel2 instansi_detail_id" id="instansi_detail_id" name="instansi_detail_id">
                </select>
            </div>
        `)

        select2Init('#' + 'instansi_detail_id', '/instansi_detail_id_select_by_role_get', 'Pilih Instansi', { user_web_role_id: function() { return id }})
    })
</script>
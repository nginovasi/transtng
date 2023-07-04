<!-- style internal -->
<style>
    .select2-container {
        width: 100% !important;
    }
</style>

<!-- content -->
<div>
    <!-- title -->
    <div class="page-hero page-container" id="page-hero">
        <div class="padding d-flex">
            <div class="page-title">
                <h2 class="text-md text-highlight"><?= $page_title ?></h2>
            </div>
            <div class="flex"></div>
        </div>
    </div>
    
    <!-- body -->
    <div class="container page-content page-container" id="page-content">
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
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Nama Lengkap</th>
                                            <th>Email User</th>
                                            <th>Jenis User</th>
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
                                    <label>Username</label>
                                    <input type="text" class="form-control" id="user_web_username" name="user_web_username" required autocomplete="off" placeholder="username user untuk login" maxlength="30">
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" id="user_web_name" name="user_web_name" required autocomplete="off" placeholder="Nama lengkap user" maxlength="50">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" id="user_web_email" name="user_web_email" required autocomplete="off" placeholder="email user" maxlength="50">
                                </div>
                                <div class="form-group" id="group_pass">
                                    <label>Password</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" id="user_web_password" name="user_web_password" required autocomplete="off" placeholder="password user untuk login" maxlength="32">
                                        <div class="input-group-append" id="div_show_pass">
                                            <span class="input-group-text">
                                                <i class="fa fa-eye-slash" id="show_password" onclick="showPassword()"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Jenis User</label>
                                    <select class="form-control" id="user_web_role_id" name="user_web_role_id" placeholder="Pilih jenis user" required></select>
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

    const select2Array = [{
        id: 'user_web_role_id',
        url: '/web_role_get',
        placeholder: 'Pilih Jenis User',
        params: null
    }];

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
            afterAction: function(result) {}
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
                $('#user_web_password').attr('disabled', true);
                $('#user_web_role_id').val(result.data.user_web_role_id).trigger('change');
                $('#user_web_password').attr('maxlength', 100);
                $('#div_show_pass').hide();
                $('#group_pass').html('');
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus user',
            afterAction: function() {}
        }

        coreEvents.resetHandler = {
            action: function() {
                $('#div_show_pass').show();
                $('#user_web_password').attr('maxlength', 32);
                $('#group_pass').html(`<label>Password</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" id="user_web_password" name="user_web_password" required autocomplete="off" placeholder="password user untuk login" maxlength="32">
                                        <input type="hidden" id="pass_hidden" name="user_web_password" value="">
                                        <div class="input-group-append" id="div_show_pass">
                                            <span class="input-group-text">
                                                <i class="fa fa-eye-slash" id="show_password" onclick="showPassword()"></i>
                                            </span>
                                        </div>
                                    </div>`);
            }
        }

        select2Array.forEach(function(x) {
            coreEvents.select2Init('#' + x.id, x.url, x.placeholder, x.params);
        });

        coreEvents.load();

        // $('#user_web_role_id').select2({
        //     placeholder: "Pilih jenis user"
        // });
        
        $('#div_show_pass').show();
        $('#user_web_password').attr('maxlength', 32);
        $('#user_web_username').keypress(function(e) {
            var txt = String.fromCharCode(e.which);
            if (!txt.match(/[a-z0-9_]/)) {
                return false;
            }
        });
    });

    function showPassword() {
        var x = document.getElementById("user_web_password");
        if (x.type === "password") {
            x.type = "text";
            $('#show_password').removeClass('fa-eye-slash');
            $('#show_password').addClass('fa-eye');
        } else {
            x.type = "password";
            $('#show_password').removeClass('fa-eye');
            $('#show_password').addClass('fa-eye-slash');
        }
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
                data: "user_web_username",
                orderable: true
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
                data: "user_web_role_name",
                orderable: true
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

                    button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

                    return button;
                }
            }
        ];
        return columns;
    }
</script>
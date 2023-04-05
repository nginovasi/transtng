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
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <!-- filter select2 -->
                                <div class="form-group">
                                    <label for="filter">Filter</label>
                                    <select class="form-control" id="filter">
                                        <option value="">Semua</option>
                                        <option value="1">Belum dijawab</option>
                                        <option value="2">Sudah dijawab</option>
                                    </select>
                                </div>
                                <table id="datatable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Email Pengguna</span></th>
                                            <th><span>Judul</span></th>
                                            <th><span>Detail</span></th>
                                            <th><span>Jawaban</span></th>
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

    $.ajax({
        url: url + '_load',
        type: "GET",
        dataType: "json",
        success: function(data) {
            var table = $('#datatable').DataTable({
                data: data,
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'aduan_email'
                    },
                    {
                        data: 'aduan_judul',
                        width: "30%"
                    },
                    {
                        data: 'aduan_detail',
                        width: "40%"
                    },
                    {
                        data: 'aduan_reply',
                        width: "40%"
                    },
                    {
                        data: 'id',
                        render: function(a, type, data, index) {
                            let button = ''
                            if (auth_edit == "1") {
                                // show modal on click to reply aduan
                                button += '<div class="btn-group">\
                                                <button class="btn btn-sm btn-outline-success reply" data-id="' + data.id + '" title="Reply">\
                                                    <i class="fa fa-reply"></i>\
                                                </button>';
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
                ],
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "columnDefs": [{
                    "targets": 0,
                    "className": "text-center"
                }, {
                    "targets": 3,
                    "className": "text-right"
                }],
                "pageLength": 5,
                "scrollX": true,
            });
        },
        error: function(data) {
            console.log(data);
        }
    });

    // onclick reply, show sweetalert
    $(document).on('click', '.reply', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Jawab Aduan',
            input: 'textarea',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Submit',
            showLoaderOnConfirm: true,
            preConfirm: (reply) => {
                // parse with ajax
                return $.ajax({
                        url: url + '_edit',
                        type: "POST",
                        data: {
                            id: id,
                            reply: reply,
                            '<?=csrf_token()?>': '<?=csrf_hash()?>'
                        },
                        dataType: "json",
                    })
                    .then(response => {
                        // if (!response.ok) {
                        //     throw new Error(response.statusText)
                        // }
                        // return response.json()
                        console.log(response);
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                        )
                    })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Anda Berhasil Menjawab Aduan',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        location.reload();
                    }
                })
            }
        })
    });
    // on change select id filter, reload table with filter as parameter
    $(document).on('change', '#filter', function() {
        let filter = $(this).val();
        
        $.ajax({
            url: url + '_load',
            type: "GET",
            data: {
                filter: filter
            },
            dataType: "json",
            success: function(data) {
                // reinitialize datatable
                $('#datatable').DataTable().destroy();
                var table = $('#datatable').DataTable({
                    data: data,
                    columns: [{
                            data: 'id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        }, {
                            data: 'aduan_email'
                        },
                        {
                            data: 'aduan_judul',
                            width: "30%"
                        },
                        {
                            data: 'aduan_detail',
                            width: "40%"
                        },
                        {
                            data: 'aduan_reply',
                            width: "40%"
                        },
                        {
                            data: 'id',
                            render: function(a, type, data, index) {
                                let button = ''
                                if (auth_edit == "1") {
                                    // show modal on click to reply aduan
                                    button += '<div class="btn-group">\
                                                    <button class="btn btn-sm btn-outline-success reply" data-id="' + data.id + '" title="Reply">\
                                                        <i class="fa fa-reply"></i>\
                                                    </button>';
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
                    ],
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],
                    "columnDefs": [{
                        "targets": 0,
                        "className": "text-center"
                    }, {
                        "targets": 3,
                        "className": "text-right"
                    }],
                    "pageLength": 5,
                    "scrollX": true,
                });
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
</script>
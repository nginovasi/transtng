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
                <h2 class="text-md text-highlight"><?=$page_title?></h2>
            </div>
            <div class="flex"></div>
        </div>
    </div>
    <div class="page-content page-container" id="page-content">
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div class="alert bg-primary mb-5 py-4" role="alert">
                        <div class="d-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-check-circle">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <div class="px-3">
                                <h5 class="alert-heading">Perhatian!</h5>
                                <p></p>
                                <br>
                                <div class="list list-row">
                                    <div class="list-item" style="margin-top: -40px;">
                                        <div>
                                            <span class="badge badge-circle text-warning"></span>
                                        </div>
                                        <div class="flex">
                                            <p>Jika kolom email tidak valid dengan email yang terftar di aplikasi mitra darat, maka data akan gagal dimasukkan</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="btn text-white" data-dismiss="alert" aria-label="Close">Close</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                            <form data-plugin="parsley" data-option="{}" id="form">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?=csrf_field();?>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="open" id="open1" value="1">
                                        <label class="form-check-label" for="open">1 Paguyuban</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="open" id="open0" value="0">
                                        <label class="form-check-label" for="open">Paguyuban Campuran</label>
                                    </div>
                                </div>
                                <div class="form-group form-paguyubanmudik">
                                    <label>Nama Paguyuban</label>
                                    <select class="form-control sel2" id="paguyuban_mudik_id" name="paguyuban_mudik_id">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jadwal</label>
                                    <select class="form-control sel2" id="jadwal_mudik_id" name="jadwal_mudik_id" required>
                                    </select>
                                </div>
                                <div class="btn-group btn-export-excel" style="margin: 2px 2px 0 14px; display: none">
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download mx-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg> Download
                                        </button>
                                        <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <li class="dropdown-item" >
                                                <a id="d-excel"><div style="width : 100%; padding: 0.25rem 1.25rem; ">Excel</div></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="bus_seats" style="display: none; overflow-x: auto;">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Peserta</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="min-width: 100px;">Kursi</th>
                                                    <th scope="col" style="min-width: 230px;">Nama</th>
                                                    <th scope="col" style="min-width: 230px;">Email (wajib akun mitra darat)</th>
                                                    <th scope="col" style="min-width: 230px;">No WA</th>
                                                    <th scope="col" style="min-width: 230px;">Nik</th>
                                                    <th scope="col" style="min-width: 230px;">No KK</th>
                                                    <th scope="col" style="min-width: 230px; display: none" class="th-paguyuban">Paguyuban</th>
                                                </tr>
                                            </thead>
                                            <tbody id="seats">
                                            </tbody>
                                        </table>
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

<!-- script internal -->
<script type="text/javascript">
    // authorization
    const auth_insert = '<?=$rules->i?>';
    const auth_edit = '<?=$rules->e?>';
    const auth_delete = '<?=$rules->d?>';
    const auth_otorisasi = '<?=$rules->o?>';

    // url
    const url = '<?=base_url()."/".uri_segment(0)."/action/".uri_segment(1)?>';
    const url_ajax = '<?=base_url()."/".uri_segment(0)."/ajax"?>';
    const url_excel = '<?= base_url() . "/" . uri_segment(0) . "/action/excel/" . uri_segment(1) . "" ?>';
    const url_excelpaguyubanxlsx = '<?= base_url() . "/" . uri_segment(0) . "/action/excelpaguyubanxlsx/" . uri_segment(1) . "" ?>';

    var dataStart = 0;
    var coreEvents;

    const select2Array = [
        {
            id: 'paguyuban_mudik_id',
            url: '/idpaguyubanmudik_select_get',
            placeholder: 'Pilih Paguyuban Mudik',
            params: null
        },
        {
            id: 'jadwal_mudik_id',
            url: '/idjadwalmudikrute_select_get',
            placeholder: 'Pilih Jadwal Mudik',
            params: null
        },
    ];

    $(document).ready(function(){
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = { "<?=csrf_token()?>": "<?=csrf_hash()?>" };
        coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder : 'Berhasil menyimpan data jadwal mudik',
            afterAction : function(result) {
                $(".sel2").val(null).trigger('change');
                
                $('.form-paguyubanmudik').css("display", "block");
                $('.th-paguyuban').css("display", "none");
                $("#bus_seats").css("display", "none");
            }
        }

        coreEvents.editHandler = {
            placeholder : '',
            afterAction : function(result) {
                setTimeout(function() {
                    select2Array.forEach(function(x) {
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
            placeholder : 'Berhasil menghapus data jadwal mudik',
            afterAction : function() {
                
            }
        }

        coreEvents.resetHandler = {
            action : function() {
                
            }
        }

        coreEvents.load();

        select2Array.forEach(function(x) {
            select2Init('#' + x.id, x.url, x.placeholder, x.params);
        });

        // coreEvents.load(coreEvents.filter);

        $('#d-excel').on('click', function(e) {
            $(this).attr("href", url_excelpaguyubanxlsx + '/p?jadwal_mudik_id=' + $('#jadwal_mudik_id').val() + '&paguyuban_mudik_id=' + $('#paguyuban_mudik_id').val());
            $(this).attr("target", "_blank");
        })

        $('#open1').attr('checked', true);
    });

    $('input[type="radio"]').change(function() {
        if(this.checked){
            if ($(this).val() == 1) {
                $('.form-paguyubanmudik').css("display", "block");
                $('.th-paguyuban').css("display", "none");

                $('#jadwal_mudik_id').val($('#jadwal_mudik_id').val()).trigger('change');
            } else {
                $('.form-paguyubanmudik').css("display", "none");
                $('.th-paguyuban').css("display", "block");

                $('#bus_seats').hide();        
                $('#jadwal_mudik_id').val($('#jadwal_mudik_id').val()).trigger('change');
            } 
        }
    });

    $('#jadwal_mudik_id').change(function(){
         if($('#paguyuban_mudik_id').val() && $("input[name='open']:checked").val() == 1) {
            $('.btn-export-excel').css("display","block")
        } else {
            $('.btn-export-excel').css("display","none")
        }

        let cekChecked = $('input[type="radio"]:checked').val()

        let id = $('#jadwal_mudik_id').val();

        if(id == null) {
            $('#bus_seats').hide();
        } else {
            Swal.fire({
                title: "",
                icon: "info",
                text: "Proses mengambil data, mohon ditunggu...",
                didOpen: function() {
                    Swal.showLoading()
                }
            });

            $('#bus_seats').show();

            $.ajax({
                url : url_ajax + '/bus_seats_get',
                method : 'post',
                dataType: 'json',
                data : {
                    id : id,
                    "<?=csrf_token()?>": "<?=csrf_hash()?>"
                },
                success: function(rs){
                    modules = [];

                    $('#seats').html('')

                    var html = ''
                    var disabled = ''
                    $.each(rs, (k, v) => {
                        if(v.billing_paguyuban_id == 0) {
                            disabled = `<td>
                                                <input type="text" class="form-control" readonly name="paguyuban_name[]" id="paguyuban_name${k}" autocomplete="off" value="${v.transaction_booking_name}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" readonly name="paguyuban_email${k}" id="paguyuban_email${k}" autocomplete="off" value="GENERAL ORDER">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" readonly name="paguyuban_no_wa[]" id="paguyuban_no_wa${k}" autocomplete="off" value="GENERAL ORDER">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" readonly name="paguyuban_no_ktp[]" id="paguyuban_no_ktp${k}" autocomplete="off" value="GENERAL ORDER">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" readonly name="paguyuban_no_kk[]" id="paguyuban_no_kk${k}" autocomplete="off" value="GENERAL ORDER">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" readonly name="paguyuban_mudik_ids${k}" id="paguyuban_mudik_ids${k}" autocomplete="off" value="GENERAL ORDER">
                                            </td>`
                        } else {
                            disabled = `<td>
                                                <input type="text" class="form-control" name="paguyuban_name[]" id="paguyuban_name${k}" autocomplete="off" value="${v.paguyuban_name ? v.paguyuban_name : ""}">
                                            </td>
                                            <td>
                                                <select class="form-control sel2" id="paguyuban_email${k}" name="paguyuban_email${k}">
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="paguyuban_no_wa[]" id="paguyuban_no_wa${k}" autocomplete="off" value="${v.paguyuban_no_wa ? v.paguyuban_no_wa : ""}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="paguyuban_no_ktp[]" id="paguyuban_no_ktp${k}" autocomplete="off" value="${v.paguyuban_no_ktp ? v.paguyuban_no_ktp : ""}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="paguyuban_no_kk[]" id="paguyuban_no_kk${k}" autocomplete="off" value="${v.paguyuban_no_kk ? v.paguyuban_no_kk : ""}">
                                            </td>`

                            if(cekChecked == 0) {
                                disabled += `<td>
                                                <select class="form-control sel2" id="paguyuban_mudik_ids${k}" name="paguyuban_mudik_ids${k}">
                                                </select>
                                            </td>`
                            }
                        }

                        $('#seats').append(`
                            <tr>
                                <td>
                                    <input type="hidden" class="form-control" readonly name="paguyuban_tempat_duduk_id[]" id="paguyuban_tempat_duduk_id${k}" autocomplete="off" value="${v.id}">
                                    <input type="text" class="form-control" readonly name="paguyuban_tempat_duduk[]" id="paguyuban_tempat_duduk${k}" autocomplete="off" value="${v.seat_map_detail_name}">
                                </td>
                                ${disabled}
                            </tr>
                        `)

                        select2Init('#' + 'paguyuban_email' + k, '/email_mobile_public_select_get', 'Pilih Email Mudik', null);

                        select2Init('#' + 'paguyuban_mudik_ids' + k, '/idpaguyubanmudik_select_get', 'Pilih Paguyuban Mudik', null);

                        if(cekChecked == 0 && v.billing_is_paguyuban == 1) {
                            $('#' + 'paguyuban_mudik_ids' + k).select2('trigger', 'select', {
                                data: {
                                    id: v.paguyuban_mudik_id,
                                    text: v.paguyuban_mudik_name
                                },
                                allowClear: true
                            });
                        }

                        $('#' + 'paguyuban_email' + k).select2('trigger', 'select', {
                            data: {
                                id: v.billing_user_id ? v.billing_user_id : 0,
                                text: v.billing_user_nama ? v.billing_user_nama : null
                            },
                            allowClear: true
                        });
                    })
                    
                    Swal.close();
                }
            })
        }
    });

    $('#paguyuban_mudik_id').change(function(){
        if($('#jadwal_mudik_id').val() && $("input[name='open']:checked").val() == 1) {
            $('.btn-export-excel').css("display","block")
        } else {
            $('.btn-export-excel').css("display","none")
        }
    })

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

    function datatableColumn(){
        let columns = [
                {
                    data: "id", orderable: false, width: 100,
                    render: function (a, type, data, index) {
                        return dataStart + index.row + 1
                    }
                },
                {data: "paguyuban_mudik_name", orderable: true},
                // {data: "jadwal_date_depart", orderable: true},
                // {data: "jadwal_time_depart", orderable: true},
                // {data: "jadwal_date_arrived", orderable: true},
                // {data: "jadwal_time_arrived", orderable: true},
                // {data: "route_name", orderable: true},
                // {
                //     data: "id", orderable: false,
                //     render: function (a, type, data, index) {
                //         let button = ''

                //         // if(auth_edit == "1"){
                //         //     button += '<button class="btn btn-sm btn-outline-primary edit" data-id="'+data.id+'" title="Edit">\
                //         //             <i class="fa fa-edit"></i>\
                //         //         </button>\
                //         //         ';
                //         // }

                //         // if(auth_delete == "1"){
                //         //     button += '<button class="btn btn-sm btn-outline-danger delete" data-id="'+data.id+'" title="Delete">\
                //         //                 <i class="fa fa-trash-o"></i>\
                //         //             </button></div>';
                //         // }

                        
                //         // button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

                //         return button;
                //     }
                // }
            ];

        return columns;
    }

    // validate max input jenis no stnk (fix 16)
    $(document).on('keyup','input[id^="paguyuban_no_ktp"]',function(e){
        if(e.target.value.length > 16) {
            $(this).val(e.target.value.substr(0, e.target.value.length - 1))
        } else if(e.target.value.length < 16) {
            $(this).addClass('border border-danger');
        } else {
            $(this).removeClass('border border-danger');
        }
    });

    // validate max input no kk (fix 16)
    $(document).on('keyup','input[id^="paguyuban_no_kk"]',function(e){
        if(e.target.value.length > 16) {
            $(this).val(e.target.value.substr(0, e.target.value.length - 1))
        } else if(e.target.value.length < 16) {
            $(this).addClass('border border-danger');
        } else {
            $(this).removeClass('border border-danger');
        }
    });

    // validate max input no wa (fix 16)
    $(document).on('keyup','input[id^="paguyuban_no_wa"]',function(e){
        if(e.target.value.length > 13) {
            $(this).val(e.target.value.substr(0, e.target.value.length - 1))
        } else if(e.target.value.length < 11) {
            $(this).addClass('border border-danger');
        } else {
            $(this).removeClass('border border-danger');
        }
    });
</script>
<!-- style internal -->
<style>
.select2-container {
    width: 100% !important;
}
</style>

<div>
    <!-- section title -->
    <div class="page-hero page-container " id="page-hero">
        <div class="padding d-flex">
            <div class="page-title">
                <h2 class="text-md text-highlight"><?=$page_title?></h2>
            </div>
            <div class="flex"></div>
        </div>
    </div>

    <!-- section content -->
    <div class="page-content page-container" id="page-content">
        <div class="card">
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                            <form data-plugin="parsley" data-option="{}" id="form">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?=csrf_field();?>
                                <div class="form-group">
                                    <label>Jadwal</label>
                                    <select class="form-control sel2" id="jadwal_mudik_id" name="jadwal_mudik_id" required>
                                    </select>
                                </div>
                                <div id="bus_seats" style="display: none; overflow-x: auto;">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="min-width: 100px;">NO</th>
                                                    <th scope="col" style="min-width: 230px;">Email</th>
                                                    <th scope="col" style="min-width: 230px;">Nama</th>
                                                    <th scope="col" style="min-width: 230px;">No Kendaraan</th>
                                                    <th scope="col" style="min-width: 230px;">Jenis Kendaraan</th>
                                                    <th scope="col" style="min-width: 230px;">No STNK Kendaraan</th>
                                                    <th scope="col" style="min-width: 230px;">NIK Pendaftar Kendaraan</th>
                                                    <th scope="col" style="min-width: 230px;">Foto Kendaraan</th>
                                                    <th scope="col" style="min-width: 230px;">Foto STNK Kendaraan</th>
                                                    <th scope="col" style="min-width: 230px;">Foto KTP</th>
                                                    <th scope="col" style="min-width: 230px;">Armada Mudik</th>
                                                    <th scope="col" style="min-width: 230px;">Armada Balik</th>
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

    // list url
    const url_ori = '<?=base_url() . "/" ?>';
    const url = '<?=base_url()."/".uri_segment(0)."/action/".uri_segment(1)?>';
    const url_ajax = '<?=base_url()."/".uri_segment(0)."/ajax"?>';

    var dataStart = 0;
    var coreEvents;

    // select2 by get jadwal rute motis
    const select2Array = [
        {
            id: 'jadwal_mudik_id',
            url: '/idjadwalmotisrute_select_get',
            placeholder: 'Pilih Jadwal Motis',
            params: null
        }
    ];

    $(document).ready(function(){
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = { "<?=csrf_token()?>": "<?=csrf_hash()?>" };
        // coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder : 'Berhasil menyimpan data jadwal mudik',
            afterAction : function(result) {
                $(".sel2").val(null).trigger('change');

                $('*[id*=filesktp]:visible').each(function() {
                    $(this).html('');
                });
                
                $('*[id*=filesstnk]:visible').each(function() {
                    $(this).html('');
                });
                
                $('*[id*=fileskendaraan]:visible').each(function() {
                    $(this).html('');
                });

                $('#bus_seats').hide();
                $('#seats').html('')
            }
        }

        coreEvents.editHandler = {
            placeholder : '',
            afterAction : function(result) {
                // setTimeout(function() {
                //     select2Array.forEach(function(x) {
                //         $('#' + x.id).select2('trigger', 'select', {
                //             data: {
                //                 id: result.data[x.id],
                //                 text: result.data[x.id.replace('id', 'nama')]
                //             }
                //         });
                //     });
                // }, 100);
            }
        }

        // coreEvents.deleteHandler = {
        //     placeholder : 'Berhasil menghapus data jadwal mudik',
        //     afterAction : function() {
                
        //     }
        // }

        coreEvents.resetHandler = {
            action : function() {
                
            }
        }

        coreEvents.load();

        select2Array.forEach(function(x) {
            select2Init('#' + x.id, x.url, x.placeholder, x.params);
        });

        // coreEvents.load(coreEvents.filter);
    });

    // preview image kendaraan
    $(document).on('change','input[id^="foto_uploadkendaraan"]',function(e){
        var id = $(this).attr('id')
        readURL($(this), id);
    });

    function readURL(input, id) {
        $(function () {
            fotoKendaraanUpload(id)
        })
    }

    function fotoKendaraanUpload(fileInput) {
        var noKe = fileInput.match(/\d+/)[0]

        $('#' + fileInput).fileupload({
            url: url+'_uploadkendaraan',
            dataType: 'json',
            formData:{ "<?=csrf_token()?>": "<?=csrf_hash()?>" },
            autoUpload: false
        }).on('fileuploadadd', function (e, data) {
            var fileTypeAllowed = /.\.(gif|jpg|png|jpeg|bmp|svg)$/i;
            var fileName = data.originalFiles[0]['name'];
            var fileSize = data.originalFiles[0]['size'];

            $("#foto_errorkendaraan" + noKe).html("");

            if (!fileTypeAllowed.test(fileName))
                $("#foto_errorkendaraan" + noKe).html('Only images are allowed!');
            else if (fileSize > 10000000)
                $("#foto_errorkendaraan" + noKe).html('Your file is too big! Max allowed size is: 1Mb');
            else {
                $("#foto_errorkendaraan" + noKe).html("");
                data.submit();
            }
        }).on('fileuploaddone', function(e, data) {
            var status = data.jqXHR.responseJSON.status;
            var msg = data.jqXHR.responseJSON.msg;

            if (status == 1) {
                var path = data.jqXHR.responseJSON.path;
                $("#fileskendaraan" + noKe).html('<div style="display: inline-block; padding: 5px;"><img style="height: 150px; border: 1px solid #000" src="' + url_ori + path + '" /></div>');
                $("#foto_kendaraan" + noKe).val(path);
            } else {
                $("#foto_errorkendaraan" + noKe).html(msg);
            }
        }).on('fileuploadprogressall', function(e,data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $("#foto_progreskendarran" + noKe).html("Proses: " + progress + "%");
            if (progress==100) {
                $("#foto_progreskendarran" + noKe).html("");
            }
        });
    }

    // preview image stnk
    $(document).on('change','input[id^="foto_uploadstnk"]',function(e){
        var id = $(this).attr('id')
        readURLSTNK($(this), id);
    });

    function readURLSTNK(input, id) {
        $(function () {
            fotoSTNKUpload(id)
        })
    }

    function fotoSTNKUpload(fileInput) {
        var noKe = fileInput.match(/\d+/)[0]

        $('#' + fileInput).fileupload({
            url: url+'_uploadstnk',
            dataType: 'json',
            formData:{ "<?=csrf_token()?>": "<?=csrf_hash()?>" },
            autoUpload: false
        }).on('fileuploadadd', function (e, data) {
            var fileTypeAllowed = /.\.(gif|jpg|png|jpeg|bmp|svg)$/i;
            var fileName = data.originalFiles[0]['name'];
            var fileSize = data.originalFiles[0]['size'];

            $("#foto_errorstnk" + noKe).html("");

            if (!fileTypeAllowed.test(fileName))
                $("#foto_errorstnk" + noKe).html('Only images are allowed!');
            else if (fileSize > 10000000)
                $("#foto_errorstnk" + noKe).html('Your file is too big! Max allowed size is: 1Mb');
            else {
                $("#foto_errorstnk" + noKe).html("");
                data.submit();
            }
        }).on('fileuploaddone', function(e, data) {
            var status = data.jqXHR.responseJSON.status;
            var msg = data.jqXHR.responseJSON.msg;

            if (status == 1) {
                var path = data.jqXHR.responseJSON.path;
                $("#filesstnk" + noKe).html('<div style="display: inline-block; padding: 5px;"><img style="height: 150px; border: 1px solid #000" src="' + url_ori + path + '" /></div>');
                $("#foto_stnk" + noKe).val(path);
            } else {
                $("#foto_errorstnk" + noKe).html(msg);
            }
        }).on('fileuploadprogressall', function(e,data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $("#foto_progresstnk" + noKe).html("Proses: " + progress + "%");
            if (progress==100) {
                $("#foto_progresstnk" + noKe).html("");
            }
        });
    }

    // preview image ktp
    $(document).on('change','input[id^="foto_uploadktp"]',function(e){
        var id = $(this).attr('id')
        readURLKTP($(this), id);
    });

    function readURLKTP(input, id) {
        $(function () {
            fotoKTPUpload(id)
        })
    }

    function fotoKTPUpload(fileInput) {
        var noKe = fileInput.match(/\d+/)[0]

        $('#' + fileInput).fileupload({
            url: url+'_uploadktp',
            dataType: 'json',
            formData:{ "<?=csrf_token()?>": "<?=csrf_hash()?>" },
            autoUpload: false
        }).on('fileuploadadd', function (e, data) {
            var fileTypeAllowed = /.\.(gif|jpg|png|jpeg|bmp|svg)$/i;
            var fileName = data.originalFiles[0]['name'];
            var fileSize = data.originalFiles[0]['size'];

            $("#foto_errorktp" + noKe).html("");

            if (!fileTypeAllowed.test(fileName))
                $("#foto_errorktp" + noKe).html('Only images are allowed!');
            else if (fileSize > 10000000)
                $("#foto_errorktp" + noKe).html('Your file is too big! Max allowed size is: 1Mb');
            else {
                $("#foto_errorktp" + noKe).html("");
                data.submit();
            }
        }).on('fileuploaddone', function(e, data) {
            var status = data.jqXHR.responseJSON.status;
            var msg = data.jqXHR.responseJSON.msg;

            if (status == 1) {
                var path = data.jqXHR.responseJSON.path;
                $("#filesktp" + noKe).html('<div style="display: inline-block; padding: 5px;"><img style="height: 150px; border: 1px solid #000" src="' + url_ori + path + '" /></div>');
                $("#foto_ktp" + noKe).val(path);
            } else {
                $("#foto_errorktp" + noKe).html(msg);
            }
        }).on('fileuploadprogressall', function(e,data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $("#foto_progresktp" + noKe).html("Proses: " + progress + "%");
            if (progress==100) {
                $("#foto_progresktp" + noKe).html("");
            }
        });
    }
    
    // choose jadwal motis
    // jadwal motis must status closed
    $('#jadwal_mudik_id').change(function(){
        let id = $('#jadwal_mudik_id').val();
        
        if(id) {
            Swal.fire({
                title: "",
                icon: "info",
                text: "Proses mengambil data, mohon ditunggu...",
                didOpen: function() {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url : url_ajax + '/truck_seats_get',
                method : 'post',
                dataType: 'json',
                data : {
                    id : id,
                    "<?=csrf_token()?>": "<?=csrf_hash()?>"
                },
                success: function(rs){
                    modules = [];

                    $('#bus_seats').show();
                    $('#seats').html('')

                    var html = ''
                    var disabled = ''
                    for(var i = 0; i < rs.length; i++) {
                        $('#seats').append(`
                            <tr>
                                <td>
                                    <input type="hidden" name="billing_id[]" value="${rs[i] ? rs[i].motis_billing_id : ""}">
                                    <input type="text" class="form-control" readonly name="no[]" id="no${i}" autocomplete="off" value="${i + 1}">
                                </td>
                                <td>
                                    <select class="form-control sel2" id="email${i}" name="email[]">
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="nama_pemilik_kendaraan[]" id="nama_pemilik_kendaraan${i}" autocomplete="off" maxlength="100" value="${rs[i] ? rs[i].nama_pemilik_kendaraan : ""}">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="no_kendaraan[]" id="no_kendaraan${i}" autocomplete="off" maxlength="30" value="${rs[i] ? rs[i].no_kendaraan : ""}">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="jenis_kendaraan[]" id="jenis_kendaraan${i}" autocomplete="off" maxlength="100" value="${rs[i] ? rs[i].jenis_kendaraan : ""}">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="no_stnk_kendaraan[]" id="no_stnk_kendaraan${i}" autocomplete="off" value="${rs[i] ? rs[i].no_stnk_kendaraan : ""}">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="nik_pendaftar_kendaraan[]" id="nik_pendaftar_kendaraan${i}" autocomplete="off" value="${rs[i] ? rs[i].nik_pendaftar_kendaraan : ""}">
                                </td>
                                <td>
                                    <input type="file" class="form-control" name="file" id="foto_uploadkendaraan${i}" autocomplete="off" value="" >

                                    <input type="hidden" name="foto_kendaraan[]" id="foto_kendaraan${i}" value="${rs[i] ? rs[i].foto_kendaraan : ""}" />
                                    <div id="foto_progreskendarran${i}" style="display: inline;"></div>
                                    <div id="foto_errorkendaraan${i}" style="display: inline;"></div><br>
                                    <div class="fileskendaraan${i}" id="fileskendaraan${i}" style="display: inline-block; width: 200px;">
                                    </div>
                                </td>
                                <td>
                                    <input type="file" class="form-control" name="file" id="foto_uploadstnk${i}" autocomplete="off" value="">

                                    <input type="hidden" name="foto_stnk[]" id="foto_stnk${i}" value="${rs[i] ? rs[i].foto_stnk : ""}" />
                                    <div id="foto_progresstnk${i}" style="display: inline;"></div>
                                    <div id="foto_errorstnk${i}" style="display: inline;"></div><br>
                                    <div class="filesstnk${i}" id="filesstnk${i}" style="display: inline-block; width: 200px;">
                                    </div>
                                </td>
                                <td>
                                    <input type="file" class="form-control" name="file" id="foto_uploadktp${i}" autocomplete="off" value="">

                                    <input type="hidden" name="foto_ktp[]" id="foto_ktp${i}" value="${rs[i] ? rs[i].foto_ktp : ""}" />
                                    <div id="foto_progresktp${i}" style="display: inline;"></div>
                                    <div id="foto_errorktp${i}" style="display: inline;"></div><br>
                                    <div class="filesktp${i}" id="filesktp${i}" style="display: inline-block; width: 200px;">
                                    </div>
                                </td>
                                 <td>
                                    <select class="form-control sel2" id="armada_mudik${i}" name="armada_mudik[]">
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control sel2" id="armada_balik${i}" name="armada_balik[]">
                                    </select>
                                </td>
                            </tr>
                        `)

                        rs[i] ? $("#fileskendaraan" + i).html(`<div style="display: inline-block; padding: 5px;">
                                <img style="height: 150px; border: 1px solid #000" src="${url_ori}/${rs[i] ? rs[i].foto_kendaraan : ""}" />
                            </div>
                        `) : ""

                        rs[i] ? $("#filesstnk" + i).html(`<div style="display: inline-block; padding: 5px;">
                                <img style="height: 150px; border: 1px solid #000" src="${url_ori}/${rs[i] ? rs[i].foto_stnk : ""}" />
                            </div>
                        `) : ""

                        rs[i] ? $("#filesktp" + i).html(`<div style="display: inline-block; padding: 5px;">
                                <img style="height: 150px; border: 1px solid #000" src="${url_ori}/${rs[i] ? rs[i].foto_ktp : ""}" />
                            </div>
                        `) : ""

                        fotoKendaraanUpload('foto_uploadkendaraan' + i)

                        fotoSTNKUpload('foto_uploadstnk' + i)

                        fotoKTPUpload('foto_uploadktp' + i)

                        select2Init('#' + 'email' + i, '/email_select_get', 'Pilih Email Mudik', null);

                        select2Init('#' + 'armada_mudik' + i, '/armada_mudik_select_get', 'Pilih Armada Mudik', {id_jadwal:  id});

                        select2Init('#' + 'armada_balik' + i, '/armada_balik_select_get', 'Pilih Armada Balik', {id_jadwal:  id});

                        rs[i] ?
                            $('#' + 'email' + i).select2('trigger', 'select', {
                                data: {
                                    id: rs[i].motis_user_id,
                                    text: rs[i].motis_user_name
                                },
                                allowClear: true
                            })
                        : ""

                        rs[i] ?
                            $('#' + 'armada_mudik' + i).select2('trigger', 'select', {
                                data: {
                                    id: rs[i].motis_armada_id,
                                    text: rs[i].motis_armada_name
                                },
                                allowClear: true
                            })
                        : ""

                        rs[i] ?
                            $('#' + 'armada_balik' + i).select2('trigger', 'select', {
                                data: {
                                    id: rs[i].motis_armada_to_id,
                                    text: rs[i].motis_armada_to_name
                                },
                                allowClear: true
                            })
                        : ""
                    }

                    Swal.close();
                }
            })
        }
    });

    // select2 init
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

    // set datatable column set
    // function datatableColumn(){
    //     let columns = [
    //         {
    //             data: "id", orderable: false, width: 100,
    //             render: function (a, type, data, index) {
    //                 return dataStart + index.row + 1
    //             }
    //         },
    //         {
    //             data: "paguyuban_mudik_name", orderable: true
    //         },
    //         // {data: "jadwal_date_depart", orderable: true},
    //         // {data: "jadwal_time_depart", orderable: true},
    //         // {data: "jadwal_date_arrived", orderable: true},
    //         // {data: "jadwal_time_arrived", orderable: true},
    //         // {data: "route_name", orderable: true},
    //         // {
    //         //     data: "id", orderable: false,
    //         //     render: function (a, type, data, index) {
    //         //         let button = ''

    //         //         // if(auth_edit == "1"){
    //         //         //     button += '<button class="btn btn-sm btn-outline-primary edit" data-id="'+data.id+'" title="Edit">\
    //         //         //             <i class="fa fa-edit"></i>\
    //         //         //         </button>\
    //         //         //         ';
    //         //         // }

    //         //         // if(auth_delete == "1"){
    //         //         //     button += '<button class="btn btn-sm btn-outline-danger delete" data-id="'+data.id+'" title="Delete">\
    //         //         //                 <i class="fa fa-trash-o"></i>\
    //         //         //             </button></div>';
    //         //         // }

                    
    //         //         // button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

    //         //         return button;
    //         //     }
    //         // }
    //     ];

    //     return columns;
    // }

    // validate
    // validate max input no kendaraan (fix 12)
    $(document).on('keyup','input[id^="no_kendaraan"]',function(e){
        if(e.target.value.length > 12) {
            $(this).val(e.target.value.substr(0, e.target.value.length - 1))
        }
    });

    // validate max input jenis kendaraan (fix 100)
    $(document).on('keyup','input[id^="no_kendaraan"]',function(e){
        if(e.target.value.length > 100) {
            $(this).val(e.target.value.substr(0, e.target.value.length - 1))
        }
    });

    // validate max input jenis no stnk (fix 100)
    $(document).on('keyup','input[id^="no_stnk_kendaraan"]',function(e){
        if(e.target.value.length > 16) {
            $(this).val(e.target.value.substr(0, e.target.value.length - 1))
        }
    });

    // validate max input jenis no stnk (fix 16)
    $(document).on('keyup','input[id^="nik_pendaftar_kendaraan"]',function(e){
        if(e.target.value.length > 16) {
            $(this).val(e.target.value.substr(0, e.target.value.length - 1))
        } else if(e.target.value.length < 16) {
            $(this).addClass('border border-danger');
        } else {
            $(this).removeClass('border border-danger');
        }
    });
</script>
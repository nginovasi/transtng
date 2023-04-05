<!-- css internal -->
<style>
    .preview {
        height: 250px;
        width: auto;
    }

    .previewseatoriginalbis {
        min-height: 250px;
        width: auto;
    }

    .previewseatdestinationbis {
        min-height: 250px;
        width: auto;
    }

    .outer-seat {
        width: 30px;
        height: 30px;
        border-radius: 4px;
        background: white;
        position: relative;
    }

    .inner-seat {
        width: 30px;
        height: 30px;
        border-radius: 4px;
        top: 0%;
        left: 0%;
        background: #D8D8D8;
        position: absolute;
    }

    .barisSeat {
        margin: 2px !important;
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        flex-wrap: wrap;
        align-content: center;
        align-items: stretch;
        gap: 5px;
    }

    .baris {
        flex: 1 100%;
        max-width: 6%;
        position: relative;
        width: 100%;
    }

    .inner-seat:hover {
        background: #3366CC;
    }

    .selected-innerColor {
        background-color: #3322CC;
    }

    .selected-outerColor {
        border-color: #3366CC;
    }
</style>

<div>
    <div class="page-hero page-container" id="page-hero">
        <div class="padding d-flex">
            <div class="page-title">
                <h2 class="text-md text-highlight"><?=$page_title?></h2>
            </div>
            <div class="flex"></div>
        </div>
    </div>
    <div class="page-content page-container" id="page-content">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills no-border" id="tab">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-form" role="tab" aria-controls="tab-form" aria-selected="false">Form</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="false">Data</a>
                    </li> -->
                </ul>
            </div>
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
                                            <p>Jadwal yang dipilih hanya jadwal dengan status tidak buka</p>
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
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Bus asal</label>
                                            <select class="form-control sel2 originalbus" id="originalbus" name="originalbus" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Bus Tujuan</label>
                                            <select class="form-control sel2 destinationbus" id="destinationbus" name="destinationbus" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title">Seat Map Preview Original Bis</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="previewseatoriginalbis" id="previewseatoriginalbis">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title">Seat Map Preview Destination Bis</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="previewseatdestinationbis" id="previewseatdestinationbis">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div> -->
                            </form>
                        </div>
                        <!-- <div class="tab-pane fade" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-hover no-wrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Nama</span></th>
                                            <th><span>Jadwal Kedatangan</span></th>
                                            <th><span>Waktu Kedatangan</span></th>
                                            <th><span>Jadwal Sampai</span></th>
                                            <th><span>Waktu Sampai</span></th>
                                            <th><span>Nama Rute</span></th>
                                            <th class="column-2action"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div> -->
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

    var dataStart = 0;
    var coreEvents;

    const select2Array = [
        {
            id: 'originalbus',
            url: '/jadwal_bus_seat_id_select_get',
            placeholder: 'Pilih Bus Asal',
            params: null
        },
        {
            id: 'destinationbus',
            url: '/jadwal_bus_seat_id_select_get',
            placeholder: 'Pilih Bus Tujuan',
            params: null
        },
    ];

    $(document).ready(function() {
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?=csrf_token()?>": "<?=csrf_hash()?>"
        };
        coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder: 'Berhasil menyimpan data armada mudik',
            afterAction: function(result) {
                $( ".checkbox" ).prop( "checked", false );
                $("#files").html('');
            }
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
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

                // $('#facilities').html('');

                // var facilities = JSON.parse(result.data.facilities)
                // $.each(facilities, (k, v) => {
                //     var checklist = ""
                //     checklist = v.facilities_id != null ? "checked" : "" 

                //     $('#facilities').append(`
                //         <div class="col-lg-3">
                //             <div class="form-group">
                //                 <input type="hidden" class="facilities_id" name="facilities_id[]" value="${v.id}">
                //                 <input type="checkbox" class="check checkbox" name="check[${k}]" value="1" ${checklist}>
                //                 <label>${v.nama}</label>
                //             </div>
                //         </div>
                //     `)
                // })

                // $("#files").html('<div style="display: inline-block; padding: 5px;"><img style="height: 150px; border: 1px solid #000" src="'+result.data.armada_image+'" /></div>');
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus data armada mudik',
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
                data: "armada_name",
                orderable: true
            },
            {
                data: "jadwal_date_depart",
                orderable: true
            },
            {
                data: "jadwal_time_depart",
                orderable: true
            },
            {
                data: "jadwal_date_arrived",
                orderable: true
            },
            {
                data: "jadwal_time_arrived",
                orderable: true
            },
            {
                data: "route_name",
                orderable: true
            },
            {
                data: "id",
                orderable: false,
                render: function(a, type, data, index) {
                    let button = ''

                    // if (auth_edit == "1") {
                    //     button += '<button class="btn btn-sm btn-outline-primary edit" data-id="' + data.id + '" title="Edit">\
                    //                     <i class="fa fa-edit"></i>\
                    //                 </button>\
                    //                 ';
                    // }

                    // if (auth_delete == "1") {
                    //     button += '<button class="btn btn-sm btn-outline-danger delete" data-id="' + data.id + '" title="Delete">\
                    //                         <i class="fa fa-trash-o"></i>\
                    //                     </button></div>';
                    // }


                    button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

                    return button;
                }
            }
        ];

        return columns;
    }

    // show seat original
    $(".originalbus").on("change", function() {
        result = ''
        $('#previewseatoriginalbis').html(result);

        var csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };

        var data = {
            id: $(this).val()
        }

        $.extend(data, csrf);

        $.ajax({
            url: url_ajax + "/jadwal_bus_seat_map_id_select_get",
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result) {
                var map_detail = JSON.parse(result.seat)
                var abjact = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']

                var html = ''
                html = ''
                $('#previewseatoriginalbis').html(html);
                for (var j = 1; j <= result.seat_map_row; j++) {
                    html += `<div class="barisSeat justify-content-center">`
                
                    for(var i = 0; i < result.seat_map_left; i++) {
                        html += `<div class="outer-seat-original mx-md-2 my-md-2" 
                                    data-id="${map_detail[i + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].id}" 
                                    data-seat="${abjact[i]}${j}"
                                    data-use="${map_detail[i + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].seat_map_use}"
                                    data-container="body" 
                                    data-toggle="popover" 
                                    data-placement="top" 
                                    data-content="NIK : ${map_detail[i + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].transaction_nik} <> Nama : ${map_detail[i + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].transaction_booking_name}"
                                    >
                                        <div class="innerseat mb-1 text-center" style="min-width: 41px; min-height: 40px">
                                            <input type="hidden" class="seat_map_detail_name" name="seat_map_detail_name[]" value="${abjact[i]}${j}">`;

                        if(map_detail[i + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].seat_map_use == 1) {
                            html += `<img class="HTjVbe" alt="" src="<?php echo base_url(); ?>/assets/icon/seat/selected.png">`
                        } else {
                            html += `<img class="HTjVbe" alt="" src="<?php echo base_url(); ?>/assets/icon/seat/avaible.png">`
                        }

                        html += `<p class="my-n4 font-weight-bold">${abjact[i]}${j}</p>
                                </div>
                            </div>`
                    }

                    html += `<div class="outer-seat-original mx-md-2 my-md-2">
                                    <div class="innerseat mb-1 text-center" style="min-width: 41px; min-height: 40px">
                                        <img class="HTjVbe" alt="" src="">
                                    </div>
                                </div>`

                    for(var l = 0; l < result.seat_map_right; l++) {
                        var rAbjact = (parseInt(result.seat_map_left) + parseInt(l));
                        html += `<div class="outer-seat-original mx-md-2 my-md-2" 
                                    data-id="${map_detail[(l + parseInt(result.seat_map_left)) + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].id}"
                                    data-seat="${abjact[rAbjact]}${j}"
                                    data-use="${map_detail[(l + parseInt(result.seat_map_left)) + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].seat_map_use}"
                                    data-container="body" 
                                    data-toggle="popover" 
                                    data-placement="top" 
                                    data-content="NIK : ${map_detail[(l + parseInt(result.seat_map_left)) + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].transaction_nik} <> Nama : ${map_detail[(l + parseInt(result.seat_map_left)) + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].transaction_booking_name}"
                                    ">
                                        <div class="innerseat mb-1 text-center" style="min-width: 41px; min-height: 40px">
                                            <input type="hidden" class="seat_map_detail_name" name="seat_map_detail_name[]" value="${abjact[rAbjact]}${j}">
                                           `;

                                    if(map_detail[(l + parseInt(result.seat_map_left)) + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].seat_map_use == 1) {
                                        html += `<img class="HTjVbe" alt="" src="<?php echo base_url(); ?>/assets/icon/seat/selected.png">`
                                    } else {
                                        html += `<img class="HTjVbe" alt="" src="<?php echo base_url(); ?>/assets/icon/seat/avaible.png">`
                                    }

                                    html += `<p class="my-n4 font-weight-bold">${abjact[rAbjact]}${j}</p>
                                            </div>
                                        </div>`
                    }

                    html += `</div>`
                }

                html += `<div class="barisSeat justify-content-center">`
                for(var k = 0; k < result.seat_map_last; k++) {
                    html += `<div class="outer-seat-original mx-md-2 my-md-2" 
                                data-id="${map_detail[k + (parseInt(result.seat_map_row) * (parseInt(result.seat_map_left) + parseInt(result.seat_map_right)))].id}"
                                data-seat="${abjact[k]}${(parseInt(result.seat_map_row) + parseInt(1))}"
                                data-use="${map_detail[k + (parseInt(result.seat_map_row) * (parseInt(result.seat_map_left) + parseInt(result.seat_map_right)))].seat_map_use}"
                                data-container="body" 
                                data-toggle="popover" 
                                data-placement="top" 
                                data-content="NIK : ${map_detail[k + (parseInt(result.seat_map_row) * (parseInt(result.seat_map_left) + parseInt(result.seat_map_right)))].transaction_nik} <> Nama : ${map_detail[k + (parseInt(result.seat_map_row) * (parseInt(result.seat_map_left) + parseInt(result.seat_map_right)))].transaction_booking_name}"
                                ">
                                    <div class="innerseat mb-1 text-center" style="min-width: 41px; min-height: 40px">
                                        <input type="hidden" class="seat_map_detail_name" name="seat_map_detail_name[]" value="${abjact[k]}${(parseInt(result.seat_map_row) + parseInt(1))}">
                                    `

                    if(map_detail[k + (parseInt(result.seat_map_row) * (parseInt(result.seat_map_left) + parseInt(result.seat_map_right)))].seat_map_use == 1) {
                        html += `<img class="HTjVbe" alt="" src="<?php echo base_url(); ?>/assets/icon/seat/selected.png">`
                    } else {
                        html += `<img class="HTjVbe" alt="" src="<?php echo base_url(); ?>/assets/icon/seat/avaible.png">`
                    }

                    html += `<p class="my-n4 font-weight-bold">${abjact[k]}${(parseInt(result.seat_map_row) + parseInt(1))}</p>
                            </div>
                        </div>`
                }

                html += `</div>`

                $('#previewseatoriginalbis').append(html);
                $('[data-toggle="popover"]').popover()
            }
        });
    });

    //  show seat destination
    $(".destinationbus").on("change", function() {
        result = ''
        $('#previewseatdestinationbis').html(result);

        var csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };

        var data = {
            id: $(this).val()
        }

        $.extend(data, csrf);

        $.ajax({
            url: url_ajax + "/jadwal_bus_seat_map_id_select_get",
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result) {
                var map_detail = JSON.parse(result.seat)
                var abjact = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']

                var html = ''
                html = ''
                $('#previewseatdestinationbis').html(html);
                for (var j = 1; j <= result.seat_map_row; j++) {
                    html += `<div class="barisSeat justify-content-center">`
                
                    for(var i = 0; i < result.seat_map_left; i++) {
                        html += `<div class="outer-seat-destination mx-md-2 my-md-2" 
                                    data-id="${map_detail[i + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].id}" 
                                    data-seat="${abjact[i]}${j}"
                                    data-use="${map_detail[i + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].seat_map_use}"
                                    data-container="body" 
                                    data-toggle="popover" 
                                    data-placement="top" 
                                    data-content="NIK : ${map_detail[i + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].transaction_nik} <> Nama : ${map_detail[i + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].transaction_booking_name}"
                                    >
                                    <div class="innerseat mb-1 text-center" style="min-width: 41px; min-height: 40px">`;

                        if(map_detail[i + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].seat_map_use == 1) {
                            html += `<img class="" alt="" src="<?php echo base_url(); ?>/assets/icon/seat/selected.png">`
                        } else {
                            html += `<img class="" alt="" src="<?php echo base_url(); ?>/assets/icon/seat/avaible.png">`
                        }

                        html += `<p class="my-n4 font-weight-bold">${abjact[i]}${j}</p>
                                </div>
                            </div>`
                    }

                    html += `<div class="outer-seat-destination mx-md-2 my-md-2">
                                <div class="innerseat mb-1 text-center" style="min-width: 41px; min-height: 40px">
                                    <img class="" alt="" src="">
                                </div>
                            </div>`

                    for(var l = 0; l < result.seat_map_right; l++) {
                        var rAbjact = (parseInt(result.seat_map_left) + parseInt(l));
                        html += `<div class="outer-seat-destination mx-md-2 my-md-2" 
                                    data-id="${map_detail[(l + parseInt(result.seat_map_left)) + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].id}"
                                    data-seat="${abjact[rAbjact]}${j}"
                                    data-use="${map_detail[(l + parseInt(result.seat_map_left)) + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].seat_map_use}"
                                    data-container="body" 
                                    data-toggle="popover" 
                                    data-placement="top" 
                                    data-content="NIK : ${map_detail[(l + parseInt(result.seat_map_left)) + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].transaction_nik} <> Nama : ${map_detail[(l + parseInt(result.seat_map_left)) + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].transaction_booking_name}"
                                    ">
                                    <div class="innerseat mb-1 text-center" style="min-width: 41px; min-height: 40px">`

                                    if(map_detail[(l + parseInt(result.seat_map_left)) + ((parseInt(result.seat_map_left) + parseInt(result.seat_map_right)) * (j - 1))].seat_map_use == 1) {
                                        html += `<img class="HTjVbe" alt="" src="<?php echo base_url(); ?>/assets/icon/seat/selected.png">`
                                    } else {
                                        html += `<img class="HTjVbe" alt="" src="<?php echo base_url(); ?>/assets/icon/seat/avaible.png">`
                                    }

                                    html += `<p class="my-n4 font-weight-bold">${abjact[rAbjact]}${j}</p>
                                            </div>
                                        </div>`
                    }

                    html += `</div>`
                }

                html += `<div class="barisSeat justify-content-center">`
                for(var k = 0; k < result.seat_map_last; k++) {
                    html += `<div class="outer-seat-destination mx-md-2 my-md-2" 
                                data-id="${map_detail[k + (parseInt(result.seat_map_row) * (parseInt(result.seat_map_left) + parseInt(result.seat_map_right)))].id}"
                                data-seat="${abjact[k]}${(parseInt(result.seat_map_row) + parseInt(1))}"
                                data-use="${map_detail[k + (parseInt(result.seat_map_row) * (parseInt(result.seat_map_left) + parseInt(result.seat_map_right)))].seat_map_use}"
                                data-container="body" 
                                data-toggle="popover" 
                                data-placement="top" 
                                data-content="NIK : ${map_detail[k + (parseInt(result.seat_map_row) * (parseInt(result.seat_map_left) + parseInt(result.seat_map_right)))].transaction_nik} <> Nama : ${map_detail[k + (parseInt(result.seat_map_row) * (parseInt(result.seat_map_left) + parseInt(result.seat_map_right)))].transaction_booking_name}"
                                ">
                                <div class="innerseat mb-1 text-center" style="min-width: 41px; min-height: 40px">`

                    if(map_detail[k + (parseInt(result.seat_map_row) * (parseInt(result.seat_map_left) + parseInt(result.seat_map_right)))].seat_map_use == 1) {
                        html += `<img class="HTjVbe" alt="" src="<?php echo base_url(); ?>/assets/icon/seat/selected.png">`
                    } else {
                        html += `<img class="HTjVbe" alt="" src="<?php echo base_url(); ?>/assets/icon/seat/avaible.png">`
                    }

                    html += `<p class="my-n4 font-weight-bold">${abjact[k]}${(parseInt(result.seat_map_row) + parseInt(1))}</p>
                            </div>
                        </div>`
                }

                html += `</div>`

                $('#previewseatdestinationbis').append(html);
                $('[data-toggle="popover"]').popover()
            }
        });
    });

    var outerSeatOriginalArray = []
    var outerSeatUseOriginalArray = []
    var outerSeatIdOriginalArray = []
    var outerSeatContentOriginalArray = []
    $(document).on("click", '.outer-seat-original', function(e) {
        // $('[data-toggle="popover"]').popover()

        var eHandled = $(this)

        console.info($(this).data('content'))

        e.preventDefault();
                    
        if($('.outer-seat-original.bg-success').length > 1) {
            if($.inArray($(this).data('seat'), outerSeatOriginalArray) != -1) {
                outerSeatOriginalArray.splice($.inArray($(this).data('seat'), outerSeatOriginalArray), 1);
                outerSeatUseOriginalArray.splice($.inArray($(this).data('use'), outerSeatUseOriginalArray), 1);
                outerSeatIdOriginalArray.splice($.inArray($(this).data('id'), outerSeatIdOriginalArray), 1);
                outerSeatContentOriginalArray.splice($.inArray($(this).data('id'), outerSeatContentOriginalArray), 1);
            } else {
                $(this).toggleClass("bg-success")

                // error validation
                // Swal.close();
                // Swal.fire('Error', 'Pilih perpindahan kursi dengan benar', 'error');
            }
        } else if($('.outer-seat-original.bg-success').length !== outerSeatOriginalArray.length) {
            outerSeatOriginalArray = []
            outerSeatUseOriginalArray = []
            outerSeatIdOriginalArray = []
            outerSeatContentOriginalArray = []
        } else {
            if($.inArray($(this).data('seat'), outerSeatOriginalArray) != -1) {
                outerSeatOriginalArray.splice($.inArray($(this).data('seat'), outerSeatOriginalArray), 1);
                outerSeatUseOriginalArray.splice($.inArray($(this).data('use'), outerSeatUseOriginalArray), 1);
                outerSeatIdOriginalArray.splice($.inArray($(this).data('id'), outerSeatIdOriginalArray), 1);
                outerSeatContentOriginalArray.splice($.inArray($(this).data('id'), outerSeatContentOriginalArray), 1);
            } else {
                outerSeatOriginalArray.push($(this).data('seat'));
                outerSeatUseOriginalArray.push($(this).data('use'));
                outerSeatIdOriginalArray.push($(this).data('id'));
                outerSeatContentOriginalArray.push($(this).data('content'))

                if($('.outer-seat-original.bg-success').length > 0) {
                    if($.inArray(1, outerSeatUseOriginalArray) != -1) {
                        Swal.fire({
                            title: "Ingin merubah kursi ?",
                            html:
                                'Seat : ' + outerSeatOriginalArray[0] + ' <br> ' +
                                ' ' + outerSeatContentOriginalArray[0] + ' <br>' +
                                '<div class="d-flex justify-content-center align-items-center">' +
                                '<img src="<?php echo base_url(); ?>/assets/icon/right.png" style="width:20px" class="mr-2"> <br> ' +
                                '<img src="<?php echo base_url(); ?>/assets/icon/left.png" style="width:20px"> <br> ' +
                                '</div>' +
                                'Seat : ' + outerSeatOriginalArray[1] + '<br>' +
                                ' ' + outerSeatContentOriginalArray[1] + ' ',
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Iya",
                            confirmButtonColor: '#d33',
                            cancelButtonText: "Batal",
                            reverseButtons: true
                        }).then(function(result) {
                            if(result.value) {
                                var csrf = {
                                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                                };

                                var data = {
                                    id: outerSeatIdOriginalArray,
                                    seat: outerSeatOriginalArray,
                                    use: outerSeatUseOriginalArray
                                }

                                $.extend(data, csrf);

                                $.ajax({
                                    url : url + "_changeseat",
                                    type : 'post',
                                    data : data,
                                    dataType: 'json',
                                    success: function(result){
                                        Swal.close();
                                        if(result.success){
                                            Swal.fire('Sukses', 'Data seat berhasil di ubah', 'success');
                                            $('.outer-seat-original').removeClass('bg-success')

                                            $('.originalbus').val($('.originalbus').val()).trigger('change');
                                            outerSeatOriginalArray = []
                                            outerSeatUseOriginalArray = []
                                            outerSeatIdOriginalArray = []
                                            
                                            $('.bs-popover-top').hide()
                                        }else{
                                            Swal.fire('Error',result.message, 'error');
                                        }
                                    },
                                    error: function(){
                                        Swal.close();
                                        Swal.fire('Error','Terjadi kesalahan pada server', 'error');
                                    }
                                });
                            }
                        })
                    } else {
                        Swal.close();
                        Swal.fire('Error', 'Tidak bisa memindahkan 2 kursi kosong', 'error');
                    }
                }
            }
        }
        
        $(this).toggleClass("bg-success")

        if(outerSeatOriginalArray.length == 1 && outerSeatDestinationArray.length == 1) {
            Swal.fire({
                title: "Ingin merubah kursi ?",
                html:
                    '<b>Bis : ' + $('.originalbus option:selected').text() + '</b><br>' +
                    'Seat : ' + outerSeatOriginalArray + ' <br> ' +
                    ' ' + outerSeatContentOriginalArray[0] + ' <br>' +
                    '<div class="d-flex justify-content-center align-items-center">' +
                    '<img src="<?php echo base_url(); ?>/assets/icon/right.png" style="width:20px" class="mr-2"> <br> ' +
                    '<img src="<?php echo base_url(); ?>/assets/icon/left.png" style="width:20px"> <br> ' +
                    '</div>' +
                    '<b>Bis : ' + $('.destinationbus option:selected').text() + '</b><br>' +
                    'Seat : ' + outerSeatDestinationArray + '<br>' +
                    ' ' + outerSeatContentDestinationArray[0] + ' ',
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya",
                confirmButtonColor: '#d33',
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then(function(result) {
                if(result.value) {
                    var csrf = {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    };

                    var data = {
                        id: [outerSeatIdOriginalArray[0], outerSeatIdDestinationArray[0]],
                        seat: [outerSeatOriginalArray[0], outerSeatDestinationArray[0]],
                        use: [outerSeatUseOriginalArray[0], outerSeatUseDestinationArray[0]]
                    }

                    $.extend(data, csrf);

                    $.ajax({
                        url : url + "_changeseat",
                        type : 'post',
                        data : data,
                        dataType: 'json',
                        success: function(result){
                            Swal.close();
                            if(result.success){
                                Swal.fire('Sukses', 'Data seat berhasil di ubah', 'success');
                                $('.outer-seat-original').removeClass('bg-success')
                                $('.outer-seat-destination').removeClass('bg-success')

                                $('.originalbus').val($('.originalbus').val()).trigger('change');
                                $('.destinationbus').val($('.destinationbus').val()).trigger('change');

                                outerSeatDestinationArray = []
                                outerSeatUseDestinationArray = []
                                outerSeatIdDestinationArray = []
                                outerSeatOriginalArray = []
                                outerSeatUseOriginalArray = []
                                outerSeatIdOriginalArray = []

                                $('.bs-popover-top').hide()
                            }else{
                                Swal.fire('Error',result.message, 'error');
                            }
                        },
                        error: function(){
                            Swal.close();
                            Swal.fire('Error','Terjadi kesalahan pada server', 'error');
                        }
                    });
                }
            })
        }

        var csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };

        var data = {
            id: $(this).data('id')
        }

        $.extend(data, csrf);

        $.ajax({
            url: url_ajax + "/detail_seats_get",
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result) {
                // if(result != null) {
                //     $('.nik_original_bus').text(result.transaction_nik)
                //     $('.name_original_bus').text(result.transaction_booking_name)
                //     $('.seat_original_bus').text(outerSeatOriginalArray[1] ? outerSeatOriginalArray[1] : outerSeatOriginalArray[0])
                // } else {
                //     // console.info('masuk')
                //     $(this).attr('data-content', '-')
                //     $('.nik_original_bus').text('')
                //     $('.name_original_bus').text('')
                //     $('.seat_original_bus').text('')
                // }
            }
        });
    });

    var outerSeatDestinationArray = []
    var outerSeatUseDestinationArray = []
    var outerSeatIdDestinationArray = []
    var outerSeatContentDestinationArray = []
    $(document).on("click", '.outer-seat-destination', function(e) {
        e.preventDefault();
        if($('.outer-seat-destination.bg-success').length > 1) {
            if($.inArray($(this).data('seat'), outerSeatDestinationArray) != -1) {
                outerSeatDestinationArray.splice($.inArray($(this).data('seat'), outerSeatDestinationArray), 1);
                outerSeatUseDestinationArray.splice($.inArray($(this).data('use'), outerSeatUseDestinationArray), 1);
                outerSeatIdDestinationArray.splice($.inArray($(this).data('id'), outerSeatIdDestinationArray), 1);
                outerSeatContentDestinationArray.splice($.inArray($(this).data('id'), outerSeatContentDestinationArray), 1);
            } else {
                $(this).toggleClass("bg-success")

                // error validation
                // Swal.close();
                // Swal.fire('Error', 'Pilih perpindahan kursi dengan benar', 'error');
            }
        } else if($('.outer-seat-destination.bg-success').length !== outerSeatDestinationArray.length) {
            outerSeatDestinationArray = []
            outerSeatUseDestinationArray = []
            outerSeatIdDestinationArray = []
            outerSeatContentDestinationArray = []
        } else {
            if($.inArray($(this).data('seat'), outerSeatDestinationArray) != -1) {
                outerSeatDestinationArray.splice($.inArray($(this).data('seat'), outerSeatDestinationArray), 1);
                outerSeatUseDestinationArray.splice($.inArray($(this).data('use'), outerSeatUseDestinationArray), 1);
                outerSeatIdDestinationArray.splice($.inArray($(this).data('id'), outerSeatIdDestinationArray), 1);
                outerSeatContentDestinationArray.splice($.inArray($(this).data('id'), outerSeatContentDestinationArray), 1);
            } else {
                outerSeatDestinationArray.push($(this).data('seat'));
                outerSeatUseDestinationArray.push($(this).data('use'));
                outerSeatIdDestinationArray.push($(this).data('id'));
                outerSeatContentDestinationArray.push($(this).data('content'))

                if($('.outer-seat-destination.bg-success').length > 0) {
                    if($.inArray(1, outerSeatUseDestinationArray) != -1) {
                        Swal.fire({
                            title: "Ingin merubah kursi ?",
                            html:
                                'Seat : ' + outerSeatDestinationArray[0] + ' <br> ' +
                                ' ' + outerSeatContentDestinationArray[0] + ' <br>' +
                                '<div class="d-flex justify-content-center align-items-center">' +
                                '<img src="<?php echo base_url(); ?>/assets/icon/right.png" style="width:20px" class="mr-2"> <br> ' +
                                '<img src="<?php echo base_url(); ?>/assets/icon/left.png" style="width:20px"> <br> ' +
                                '</div>' +
                                'Seat : ' + outerSeatDestinationArray[1] + '<br>' +
                                ' ' + outerSeatContentDestinationArray[1] + ' ',
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Iya",
                            confirmButtonColor: '#d33',
                            cancelButtonText: "Batal",
                            reverseButtons: true
                        }).then(function(result) {
                            if(result.value) {
                                var csrf = {
                                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                                };

                                var data = {
                                    id: outerSeatIdDestinationArray,
                                    seat: outerSeatDestinationArray,
                                    use: outerSeatUseDestinationArray
                                }

                                $.extend(data, csrf);

                                $.ajax({
                                    url : url + "_changeseat",
                                    type : 'post',
                                    data : data,
                                    dataType: 'json',
                                    success: function(result){
                                        Swal.close();
                                        if(result.success){
                                            Swal.fire('Sukses', 'Data seat berhasil di ubah', 'success');
                                            $('.outer-seat-destination').removeClass('bg-success')

                                            $('.destinationbus').val($('.destinationbus').val()).trigger('change');
                                            outerSeatDestinationArray = []
                                            outerSeatUseDestinationArray = []
                                            outerSeatIdDestinationArray = []

                                            $('.bs-popover-top').hide()
                                        }else{
                                            Swal.fire('Error',result.message, 'error');
                                        }
                                    },
                                    error: function(){
                                        Swal.close();
                                        Swal.fire('Error','Terjadi kesalahan pada server', 'error');
                                    }
                                });
                            }
                        })
                    } else {
                        Swal.close();
                        Swal.fire('Error', 'Tidak bisa memindahkan 2 kursi kosong', 'error');
                    }
                }
            }
        }

        $(this).toggleClass("bg-success")

        if(outerSeatOriginalArray.length == 1 && outerSeatDestinationArray.length == 1) {
            Swal.fire({
                title: "Ingin merubah kursi ?",
                html:
                    '<b>Bis : ' + $('.originalbus option:selected').text() + '</b><br>' +
                    'Seat : ' + outerSeatOriginalArray + ' <br> ' +
                    ' ' + outerSeatContentOriginalArray[0] + ' <br>' +
                    '<div class="d-flex justify-content-center align-items-center">' +
                    '<img src="<?php echo base_url(); ?>/assets/icon/right.png" style="width:20px" class="mr-2"> <br> ' +
                    '<img src="<?php echo base_url(); ?>/assets/icon/left.png" style="width:20px"> <br> ' +
                    '</div>' +
                    '<b>Bis : ' + $('.destinationbus option:selected').text() + '</b><br>' +
                    'Seat : ' + outerSeatDestinationArray + '<br>' +
                    ' ' + outerSeatContentDestinationArray[0] + ' ',
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya",
                confirmButtonColor: '#d33',
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then(function(result) {
                if(result.value) {
                    var csrf = {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    };

                    var data = {
                        id: [outerSeatIdOriginalArray[0], outerSeatIdDestinationArray[0]],
                        seat: [outerSeatOriginalArray[0], outerSeatDestinationArray[0]],
                        use: [outerSeatUseOriginalArray[0], outerSeatUseDestinationArray[0]]
                    }

                    $.extend(data, csrf);

                    $.ajax({
                        url : url + "_changeseat",
                        type : 'post',
                        data : data,
                        dataType: 'json',
                        success: function(result){
                            Swal.close();
                            if(result.success){
                                Swal.fire('Sukses', 'Data seat berhasil di ubah', 'success');
                                $('.outer-seat-original').removeClass('bg-success')
                                $('.outer-seat-destination').removeClass('bg-success')

                                $('.originalbus').val($('.originalbus').val()).trigger('change');
                                $('.destinationbus').val($('.destinationbus').val()).trigger('change');

                                outerSeatDestinationArray = []
                                outerSeatUseDestinationArray = []
                                outerSeatIdDestinationArray = []
                                outerSeatOriginalArray = []
                                outerSeatUseOriginalArray = []
                                outerSeatIdOriginalArray = []

                                $('.bs-popover-top').hide()
                            }else{
                                Swal.fire('Error',result.message, 'error');
                            }
                        },
                        error: function(){
                            Swal.close();
                            Swal.fire('Error','Terjadi kesalahan pada server', 'error');
                        }
                    });
                }
            })
        }

        var csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };

        var data = {
            id: $(this).data('id')
        }

        $.extend(data, csrf);

        $.ajax({
            url: url_ajax + "/detail_seats_get",
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result) {
                // if(result) {
                //     $('.nik_destination_bus').text(result.transaction_nik)
                //     $('.name_destination_bus').text(result.transaction_booking_name)
                //     $('.seat_destination_bus').text(outerSeatDestinationArray[1] ? outerSeatDestinationArray[1] : outerSeatDestinationArray[0])
                // }
            }
        });
    });

    $(function () {
        // $('[data-toggle="popover"]').popover()
        $('[data-toggle="tooltip"]').tooltip()

        $('[data-toggle="popover"]').popover()

        // $('[data-toggle="popover"]').popover('show');    
    })

</script>

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
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills no-border" id="tab">
                    <!-- <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-form" role="tab" aria-controls="tab-form" aria-selected="false">Form</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="false"><i class="fa fa-table"></i> Data</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <!-- <div class="tab-pane fade active show" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                            <form data-plugin="parsley" data-option="{}" id="form">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?=csrf_field();?>
                                <div class="form-group">
                                    <label>Nama Modul</label>
                                    <input type="text" class="form-control" id="module_name" name="module_name" required autocomplete="off" placeholder="Tentukan nama modul">
                                </div>
                                <div class="form-group">
                                    <label>Url Modul</label>
                                    <input type="text" class="form-control" id="module_url" name="module_url" required autocomplete="off" placeholder="Tentukan nama modul">
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form> -->
                        <div class="row mb-3">
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-control-md date" name="date-start" id="date-start" placeholder="Tgl Exp Start" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-control-md date" name="date-end" id="date-end" placeholder="Tgl Exp End" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Jenis Pelayanan</span></th>
                                            <th><span>Noken</span></th>
                                            <th><span>No Rangka</span></th>
                                            <th><span>No Mesin</span></th>
                                            <th><span>Tgl Exp Kps</span></th>
                                            <th><span>Action</span></th>
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

<!-- .modal -->
<div class="modal fade" id="modal_blue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List File</h5>
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
<!-- / .modal -->

<script type="text/javascript">
    const auth_insert = '<?=$rules->i?>';
    const auth_edit = '<?=$rules->e?>';
    const auth_delete = '<?=$rules->d?>';
    const auth_otorisasi = '<?=$rules->o?>';

    const url = '<?=base_url()."/".uri_segment(0)."/action/".uri_segment(1)?>';
    const url_ajax = '<?=base_url()."/".uri_segment(0)."/ajax"?>';

    var dataStart = 0;
    var coreEvents;

    var dateStart

    const select2Array = [];

    // call api spionam
    // $(document).ready(function(){
    //     coreEvents = new CoreEventsHubdat();
    //     coreEvents.url = url;
    //     coreEvents.ajax = url_ajax;
    //     coreEvents.csrf = { "<?=csrf_token()?>": "<?=csrf_hash()?>" };
    //     coreEvents.tableColumn = datatableColumn();

    //     coreEvents.detailHandler = {
    //         action: function() {

    //         }
    //     }

    //     coreEvents.filter = [null, null]

    //     $('.date').each(function(){

    //     }).on('changeDate', function () {
    //         coreEvents.filter = [$('#date-start').val(), $('#date-end').val()]
    //         if($('#date-start').val() !== "" || $('#date-start').val() !== "") {
    //             coreEvents.load(coreEvents.filter);
    //         }

    //         console.info(coreEvents.filter)

    //         $(this).datepicker('hide');
    //     });

    //     coreEvents.load(coreEvents.filter);

    //     coreEvents.datepicker('#date-start')
    //     coreEvents.datepicker('#date-end')  
    // });

    $(document).ready(function(){
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = { "<?=csrf_token()?>": "<?=csrf_hash()?>" };
        coreEvents.tableColumn = datatableColumn();

        // coreEvents.insertHandler = {
        //     placeholder : 'Berhasil menyimpan menu',
        //     afterAction : function(result) {

        //     }
        // }

        // coreEvents.editHandler = {
        //     placeholder : '',
        //     afterAction : function(result) {
        //         setTimeout(function() {
        //             $('#module_id').val(result.data.module_id).trigger('change');

        //             getListMenu(result.data.module_id,function(){
        //                 $('#menu_id').val(result.data.menu_id).trigger('change');
        //             });
        //         },500);
        //     }
        // }

        // coreEvents.deleteHandler = {
        //     placeholder : 'Berhasil menghapus menu',
        //     afterAction : function() {
                
        //     }
        // }

        // coreEvents.resetHandler = {
        //     action : function() {
        //         $('#menu_id').data('select2').destroy();
        //         $('#menu_id').html('');
        //         $('#menu_id').select2({ placeholder : "Pilih modul terlebih dahulu" });
        //         $('#module_id').val(null).trigger('change');
        //     }
        // }

        coreEvents.filter = [null, null]

        $('.date').each(function(){

        })
        .on('changeDate', function () {
            coreEvents.filter = [$('#date-start').val(), $('#date-end').val()]
            if($('#date-start').val().length != 0 && $('#date-end').val().length != 0) {
                coreEvents.load(coreEvents.filter);
            }

            $(this).datepicker('hide');
        });

        coreEvents.load(coreEvents.filter);

        coreEvents.datepicker('#date-start', 'yyyy-mm-dd')
        coreEvents.datepicker('#date-end', 'yyyy-mm-dd')  
    });

    function datatableColumn(){
        let columns = [
                {
                    data: "id", orderable: false, width: 100,
                    render: function (a, type, data, index) {
                        return dataStart + index.row + 1
                    }
                },
                {data: "jenis_pelayanan", orderable: false},
                {data: "noken", orderable: false},
                {data: "no_rangka", orderable: false},
                {data: "no_mesin", orderable: false},
                {data: "tgl_exp_kps", orderable: false, 
                    render: function(a, type, data, index) {
                        return data.tgl_exp_kps.split(' ')[0]
                    }
                },
                {
                    data: "id", orderable: false, width: 100,
                    render: function (a, type, data, index) {
                        let button = ''

                        button += '<div class="d-flex mx-2">'

                        button += '<button class="btn btn-sm btn-outline-primary spionam-last mr-2" data-noken="'+data.noken+'" data-toggle="tooltip" data-placement="top" title="Sionam Last">\
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye mx-2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>\
                                </button>\
                                ';
                        
                        button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

                        button += '</div>'

                        return button;
                    }
                }
            ];

        return columns;
    }
</script>
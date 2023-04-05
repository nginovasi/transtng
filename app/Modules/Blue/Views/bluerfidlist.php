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
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="false">Data</a>
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search mx-2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-control-md search" name="search" id="search" placeholder="Search" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Nama Pemilik</span></th>
                                            <th><span>Alamat Pemilik</span></th>
                                            <th><span>Jenis Kendaraan</span></th>
                                            <th><span>No Registrasi Kendaraan</span></th>
                                            <th><span>Merk</span></th>
                                            <th><span>Date</span></th>
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

    // get api blue list
    $(document).ready(function(){
        coreEvents = new CoreEventsHubdat();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = { "<?=csrf_token()?>": "<?=csrf_hash()?>" };
        coreEvents.tableColumn = datatableColumn();

        coreEvents.detailHandler = {
            action: function() {

            }
        }

        coreEvents.filter = [null, null]

        coreEvents.search = ""

        $('.search').keyup(debounce(function() {
            if($('.search').val() !== "") {
                coreEvents.search = $('.search').val()
                coreEvents.load(coreEvents.filter, coreEvents.search);
            }
        }, 1000))

        coreEvents.load(coreEvents.filter); 
    });

    function datatableColumn(){
        let columns = [
                {
                    data: "id", orderable: false, width: 100,
                    render: function (a, type, data, index) {
                        return dataStart + index.row + 1
                    }
                },
                {data: "nama_pemilik", orderable: false},
                {data: "alamat_pemilik", orderable: false},
                {data: "jenis_kendaraan", orderable: false},
                {data: "no_registrasi_kendaraan", orderable: false},
                {data: "merk", orderable: false},
                {data: "date", orderable: false},
                {
                    data: "id", orderable: false, width: 100,
                    render: function (a, type, data, index) {
                        let button = ''

                        button += '<div class="d-flex mx-2">'

                        button += '<button class="btn btn-sm btn-outline-primary blue-rfid-last mr-2" data-id="'+data.no_registrasi_kendaraan+'" data-toggle="tooltip" data-placement="top" title="Blue RFID Last">\
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
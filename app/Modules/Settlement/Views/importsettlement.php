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
                        <a class="nav-link active" data-toggle="tab" href="#tab-form" role="tab" aria-controls="tab-form" aria-selected="true"><i class="fa fa-calendar" aria-hidden="true"></i> Import</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="true"><i class="fa fa-calendar" aria-hidden="true"></i> Data</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                            <form method="post" enctype="multipart/form-data" name="formexcel" id="formexcel">
                                <?= csrf_field(); ?>
                                <div class="form-group row">
                                    <div class="input-group mb-3 col-md-4">
                                        <select class="custom-select select2" name="bank_id" id="bank_id" required></select>
                                    </div>
                                    <div class="input-group mb-3 col-md-4">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="excelfile" id="excelfile" onchange="FileSelected()" accept=".csv,.bri,.txt" required >
                                            <label class="custom-file-label" for="excelfile" id="filename" >Pilih file</label>
                                        </div>
                                    </div>
                                    <div class="input-group btn-group-download-template mb-3 col-md-2" style="display: none">
                                        <button class="btn btn-success" id="download-template">Download Template</button>
                                        <a href="" id="download-template-final"></a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group btn-group-process-file mb-3 col-md-2" style="display: none">
                                        <button type="submit" class="btn btn-success" id="process-excel">Proses File</button>
                                    </div>
                                </div>
                            </form>

                            <div class="tab-content-body" style="display: block;">        
                            </div>

                            <button type="button" class="btn btn-success ml-auto mt-2" id="save-excel" style="display: none;">Simpan File</button>
                        </div>
                        <div class="tab-pane fade" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Bank</span></th>
                                            <th><span>Filename</span></th>
                                            <th><span>Jumlah Settlement</span></th>
                                            <th><span>Tanggal Settlement</span></th>
                                            <th><span>Tanggal Impor</span></th>
                                            <th><span>User</span></th>
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

<!-- script internal -->
<script type="text/javascript">
    const auth_insert = '<?= $rules->i ?>';
    const auth_edit = '<?= $rules->e ?>';
    const auth_delete = '<?= $rules->d ?>';
    const auth_otorisasi = '<?= $rules->o ?>';

    const base_url = '<?= base_url() ?>';
    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';
    const url_pdf = '<?= base_url() . "/assets/csv/" ?>';

    let dataStart = 0;
    let coreEvents;

    // init select2
    const select2Array = [
        {
            id: 'bank_id',
            url: '/bank_id_select_get',
            placeholder: 'Pilih Bank',
            params: null
        }
    ];

    $(document).ready(function() {
        // init core event
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };

        // datatable load
        coreEvents.tableColumn = datatableColumn();

        // insert
        coreEvents.insertHandler = {
        }

        // update
        coreEvents.editHandler = {
        }

        // delete
        coreEvents.deleteHandler = {
        }

        // reset
        coreEvents.resetHandler = {
        }

        select2Array.forEach(function(x) {
            coreEvents.select2Init('#' + x.id, x.url, x.placeholder, x.params);
        });
        
        coreEvents.load(null, [0, 'asc'], null);

    });

    // datatable column
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
                data: "bank",
                orderable: true
            },
            {
                data: "filename",
                orderable: true
            },
            {
                data: "ttl_sttl",
                orderable: true
            },
            {
                data: "date_sttl",
                orderable: true
            },
            {
                data: "created_at",
                orderable: true
            },
            {
                data: "user_web_username",
                orderable: true
            }
        ];
        return columns;
    }

    $('#bank_id').on('change', function() {
        $('.btn-group-download-template').css('display', 'block')

        if($('#excelfile').val() !== ""){
            $('.btn-group-process-file').css('display', 'block')
        }
    })
    
    $('#download-template').on('click', function() {
        let bank = $('#bank_id').select2('data');

        Swal.fire({
            title: "Unduh Template CSV " + bank[0].text + "?",
            icon: 'info',
            showDenyButton: true,
            confirmButtonText: 'Ok',
            denyButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    let filename = bank[0].text+"SttlTemplate.csv";

                    if(bank[0].text === "BNI"){
                        filename = bank[0].text + "RekKoranTemplate.csv";
                    }else{
                        filename = bank[0].text + "SttlTemplate.csv";
                    }

                    window.location = url_pdf + filename
                }
            }
        )
    })

    function FileSelected(e)
    {
        $('#simpanexcel').css('display','none');

        let file = document.getElementById('excelfile').files[document.getElementById('excelfile').files.length - 1];
        document.getElementById('filename').innerHtml= file.name;
        $('#filename').text(file.name);

        if($('#bank_id').val() !== "" && $('#bank_id').val() !== null){

            $('.btn-group-process-file').css('display', 'block')
        }
    }

    $(document).on('submit', 'form[name="formexcel"]',function(e){
        e.preventDefault()

        let bank = $('#bank_id').find(":selected").text()
        let fileInput = document.getElementById('excelfile')

        $('.tab-content-body').css('display', "block")
        $('.tab-content-body').html("")

        Swal.fire({
            title: "Proses file excel terpilih?",
            icon : "warning",
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.isConfirmed) {
                switch(bank) {
                    case "BCA":
                        loadCSVBCA(fileInput, "BCA")
                        break;
                    case "BNI":
                        loadCSVBNI(fileInput, "BNI")
                        break;
                    case "BRI":
                        loadCSVBRI(fileInput, "BRI")
                        break;
                    case "Mandiri":
                        loadCSVMandiri(fileInput, "Mandiri")
                        break;
                    default:
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan template',
                        text: 'Silahkan hub team!'
                    })
                }

                $('#save-excel').css('display', "block")
            }
        })
    })

    let DataBCA
    function loadCSVBCA(fileInput, bank){
        readFile = function () {
            loaderStart()

            let reader = new FileReader();

            reader.onload = function () {
                let readerResult = reader.result.split(/\r\n|\n|\r/);

                let resultCSV = [];
                let blackListWord =  ["Saldo Awal", "Mutasi Debet", "Mutasi Kredit", "Saldo Akhir"];
                for (let i = 0; i < readerResult.length; i++) {
                    csvLineSplit =  readerResult[i].split('","');

                    if(i != 0) {
                        if(csvLineSplit != "") {
                            resultCSV.push(csvLineSplit);
                            if(readerResult[i][0] == 0){
                                resultCSV.pop()
                            }
                        }
                    } else {
                        if(csvLineSplit[0] != '"Tanggal Transaksi' || csvLineSplit[1] != 'Keterangan' || csvLineSplit[2] != 'Cabang' || csvLineSplit[3] != 'Jumlah' || csvLineSplit[4] != 'Saldo"') {
                            templateWrong()
                            return
                        }
                    }
                }

                let getIndexBlackList = []
                $.each(resultCSV, function(i, n) {
                    $.each(blackListWord, function(i2, n2) {
                        if(n[0].includes(n2)) {
                            getIndexBlackList.push(i);
                            return true;
                        } 
                    })
                })

                $.each(getIndexBlackList, function(i, n) {
                    resultCSV.splice(n - i, 1);
                })

                $.each(resultCSV, function(i, n) {
                    n[0] = n[0].replace('"', '')
                    n[1] = n[1].replace('"', '')
                    n[2] = n[2].replace('"', '')
                    n[3] = n[3].replace('"', '')
                    n[4] = n[4].replace('"', '')
                })

                $.ajax({
                    url : url + "_load_" + bank + "Paid",
                    method: 'post',
                    dataType : 'json',
                    data : {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                        data: JSON.stringify(resultCSV)
                    },
                    success : function (rs) {
                        if(rs.success == true) {
                            loaderEnd()

                            let result = `<div class="table-responsive">
                                                <table class="table" id="exceltable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Transaction Date</th>
                                                            <th scope="col">Paid Date</th>
                                                            <th scope="col">Settlement Date</th>
                                                            <th scope="col">Description</th>
                                                            <th scope="col">MID</th>
                                                            <th scope="col">Merchant</th>
                                                            <th scope="col">TID</th>
                                                            <th scope="col">Trans. Type</th>
                                                            <th scope="col">Kredit</th>
                                                            <th scope="col">No Ref</th>
                                                            <th scope="col">Sttl Number</th>
                                                            <th scope="col">Branch</th>
                                                            <th scope="col">Last Balance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tbody">`

                            $.each(rs.data, function(i, val) {
                                result += `
                                        <tr>
                                            <th scope="row" class="text-center">${i + 1}</th>
                                            <td>${val['date_trx']}</td>
                                            <td>${val['date_paid']}</td>
                                            <td>${val['date_sttl']}</td>
                                            <td class="text-right">${val['description']}</td>
                                            <td class="text-right">${val['mid']}</td>
                                            <td class="text-right">${val['merchant']}</td>
                                            <td class="text-right">${val['tid']}</td>
                                            <td class="text-right">${val['type_trx']}</td>
                                            <td class="text-right">${val['kredit']}</td>
                                            <td class="text-right">${val['no_reff']}</td>
                                            <td class="text-right">${val['sttl_num']}</td>
                                            <td class="text-right">${val['branch']}</td>
                                            <td class="text-right">${val['last_balance']}</td>
                                        </tr>`
                            })             

                            result += `
                                    </tbody>
                                </table>
                            </div>`

                            $(".tab-content-body").append(result)

                            $('#exceltable').DataTable({
                                "scrollX": true
                            });

                            DataBCA = rs.data

                        } else {
                            swal.close();

                            Swal.fire('Error', rs.message, 'error');
                        }
                    }
                })
            };

            reader.readAsBinaryString(fileInput.files[0]);
        };

        readFile()
    }

    let DataBNI
    function loadCSVBNI(fileInput, bank){
        readFile = function () {
            loaderStart()

            let reader = new FileReader();

            reader.onload = function () {
                let readerResult = reader.result.split(/\r\n|\n|\r/);

                let resultCSV = [];
                let blackListWord =  ["No."];
                for (let i = 0; i < readerResult.length; i++) {
                    csvLineSplit =  readerResult[i].split(';');

                    if(i != 0) {
                        if(csvLineSplit != "") {
                            resultCSV.push(csvLineSplit);
                            if(readerResult[i][0] == 0){
                                resultCSV.pop()
                            }
                        }
                    } else {
                        if(csvLineSplit[0] != 'No.' || csvLineSplit[1] != 'Post Date' || csvLineSplit[2] != 'Branch' || csvLineSplit[3] != 'Journal No.' || csvLineSplit[4] != 'Description' || csvLineSplit[5] != 'Amount' || csvLineSplit[6] != 'Db/Cr' || csvLineSplit[7] != 'Balance') {
                            templateWrong()
                            return
                        }
                    }
                }

                let getIndexBlackList = []
                $.each(resultCSV, function(i, n) {
                    $.each(blackListWord, function(i2, n2) {
                        if(n[0].includes(n2)) {
                            getIndexBlackList.push(i);
                            return true;
                        } 
                    })
                })

                $.each(getIndexBlackList, function(i, n) {
                    resultCSV.splice(n - i, 1);
                })

                $.each(resultCSV, function(i, n) {
                    n[0] = n[0].replace('"', '')
                    n[1] = n[1].replace('"', '')
                    n[2] = n[2].replace('"', '')
                    n[3] = n[3].replace('"', '')
                    n[4] = n[4].replace('"', '')
                    n[5] = n[5].replace('"', '')
                    n[6] = n[6].replace('"', '')
                    n[7] = n[7].replace('"', '')
                })

                $.ajax({
                    url : url + "_load_" + bank + "Paid",
                    method: 'post',
                    dataType : 'json',
                    data : {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                        data: JSON.stringify(resultCSV)
                    },
                    success : function (rs) {
                        if(rs.success == true) {
                            loaderEnd()

                            let result = `<div class="table-responsive">
                                                <table class="table" id="exceltable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Paid Date</th>
                                                            <th scope="col">Trx Date</th>
                                                            <th scope="col">Branch</th>
                                                            <th scope="col">Journal Number</th>
                                                            <th scope="col">Description</th>
                                                            <th scope="col">Kredit</th>
                                                            <th scope="col">Debit/Credit</th>
                                                            <th scope="col">Balance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tbody">`

                            $.each(rs.data, function(i, val) {
                                result += `
                                        <tr>
                                            <th scope="row" class="text-center">${i + 1}</th>
                                            <td>${val['date_paid']}</td>
                                            <td>${val['date_trx']}</td>
                                            <td>${val['branch']}</td>
                                            <td>${val['no_journal']}</td>
                                            <td>${val['description']}</td>
                                            <td class="text-right">${val['kredit']}</td>
                                            <td class="text-right">${val['dc']}</td>
                                            <td class="text-right">${val['balance']}</td>
                                        </tr>`
                            })             

                            result += `
                                    </tbody>
                                </table>
                            </div>`

                            $(".tab-content-body").append(result)

                            $('#exceltable').DataTable({
                                "scrollX": true
                            });

                            DataBNI = rs.data

                        } else {
                            swal.close();

                            Swal.fire('Error','Terjadi kesalahan pada server', 'error');
                        }
                    }
                })
            };

            reader.readAsBinaryString(fileInput.files[0]);
        };

        readFile()
    }

    let DataBRI
    function loadCSVBRI(fileInput, bank){
        readFile = function () {
            loaderStart()

            let reader = new FileReader();

            reader.onload = function () {
                let readerResult = reader.result.split(/\r\n|\n|\r/);

                let resultCSV = [];
                let blackListWord =  ["tanggal"];
                for (let i = 0; i < readerResult.length; i++) {
                    csvLineSplit =  readerResult[i].split(';');

                    if(i != 0) {
                        if(csvLineSplit != "") {
                            resultCSV.push(csvLineSplit);
                            if(readerResult[i][0] == 0){
                                resultCSV.pop()
                            }
                        }
                    } else {
                        if(csvLineSplit[0] != 'tanggal' || csvLineSplit[1] != 'transaksi' || csvLineSplit[2] != 'debet' || csvLineSplit[3] != 'kredit' || csvLineSplit[4] != 'Saldo') {
                            templateWrong()
                            return
                        }
                    }
                }

                let getIndexBlackList = []
                $.each(resultCSV, function(i, n) {
                    $.each(blackListWord, function(i2, n2) {
                        if(n[0].includes(n2)) {
                            getIndexBlackList.push(i);
                            return true;
                        } 
                    })
                })

                $.each(getIndexBlackList, function(i, n) {
                    resultCSV.splice(n - i, 1);
                })

                $.each(resultCSV, function(i, n) {
                    n[0] = n[0].replace('"', '')
                    n[1] = n[1].replace('"', '')
                    n[2] = n[2].replace('"', '')
                    n[3] = n[3].replace('"', '')
                    n[4] = n[4].replace('"', '')
                })

                $.ajax({
                    url : url + "_load_" + bank + "Paid",
                    method: 'post',
                    dataType : 'json',
                    data : {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                        data: JSON.stringify(resultCSV)
                    },
                    success : function (rs) {

                        if(rs.success == true) {
                            loaderEnd()

                            let result = `<div class="table-responsive">
                                                <table class="table" id="exceltable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">DATE PAID</th>
                                                            <th scope="col">TRANSACTION REF</th>
                                                            <th scope="col">FILE 1</th>
                                                            <th scope="col">BODY</th>
                                                            <th scope="col">FILE 2</th>
                                                            <th scope="col">SHIFT</th>
                                                            <th scope="col">COUNT</th>
                                                            <th scope="col">KREDIT</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tbody">`

                            $.each(rs.data, function(i, val) {
                                result += `
                                        <tr>
                                            <th scope="row" class="text-center">${i + 1}</th>
                                            <td>${val['date_paid']}</td>
                                            <td>${val['ref_trx']}</td>
                                            <td>${val['file_1']}</td>
                                            <td>${val['body']}</td>
                                            <td>${val['file_2']}</td>
                                            <td>${val['shift']}</td>
                                            <td>${val['count']}</td>
                                            <td class="text-right">${val['kredit']}</td>
                                        </tr>`
                            })             

                            result += `
                                    </tbody>
                                </table>
                            </div>`

                            $(".tab-content-body").append(result)

                            $('#exceltable').DataTable({
                                "scrollX": true
                            });

                            DataBRI = rs.data
                        } else {
                            loaderEnd()

                            Swal.fire('Error','Terjadi kesalahan pada server', 'error');
                        }
                    }
                })
            };

            reader.readAsBinaryString(fileInput.files[0]);
        };

        readFile()
    }

    let DataMandiri
    function loadCSVMandiri(fileInput, bank){
        readFile = function () {

        loaderStart()

            let reader = new FileReader();

            reader.onload = function () {
                let readerResult = reader.result.split(/\r\n|\n|\r/);

                let resultCSV = [];
                let blackListWord =  ["Account No."];
                for (let i = 0; i < readerResult.length; i++) {
                    let csvLineSplit = readerResult[i].split(';')

                    if(i != 0) {
                        if(i % 2 == 1) {
                            csvLineSplitMerge = $.merge(readerResult[i].split(';'), readerResult[i + 1].split(';'))

                            if(csvLineSplitMerge != "") {
                                resultCSV.push(csvLineSplitMerge);
                                if(readerResult[i][0] == 0){
                                    resultCSV.pop()
                                }
                            }
                        }
                    } else {
                        if(csvLineSplit[0] != 'Account No.' || csvLineSplit[1] != 'Date & Time' || csvLineSplit[2] != 'Value Date' || csvLineSplit[3] != 'Account No Alias' || csvLineSplit[4] != 'Description' || csvLineSplit[5] != 'Reference No.' || csvLineSplit[6] != 'Debit' || csvLineSplit[7] != 'Credit' || csvLineSplit[8] != 'Balance') {
                            templateWrong()
                            return
                        }
                    }
                }

                let getIndexBlackList = []
                $.each(resultCSV, function(i, n) {
                    $.each(blackListWord, function(i2, n2) {
                        if(n[0].includes(n2)) {
                            getIndexBlackList.push(i);
                            return true;
                        } 
                    })
                })

                $.each(getIndexBlackList, function(i, n) {
                    resultCSV.splice(n - i, 1);
                })

                $.each(resultCSV, function(i, n) {
                    n[0] = n[0].replace('"', '')
                    n[1] = n[1].replace('"', '')
                    n[2] = n[2].replace('"', '')
                    n[3] = n[3].replace('"', '')
                    n[4] = n[4].replace('"', '')
                    n[5] = n[5].replace('"', '')
                    n[6] = n[6].replace('"', '')
                    n[7] = n[7].replace('"', '')
                    n[8] = n[8].replace('"', '')
                })

                $.ajax({
                    url : url + "_load_" + bank + "Paid",
                    method: 'post',
                    dataType : 'json',
                    data : {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                        data: JSON.stringify(resultCSV)
                    },
                    success : function (rs) {

                        if(rs.success == true) {
                            loaderEnd()

                            let result = `<div class="table-responsive">
                                                <table class="table" id="exceltable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">DATE TRX</th>
                                                            <th scope="col">DATE PAID</th>
                                                            <th scope="col">DESCRIPTION</th>
                                                            <th scope="col">FILENAME</th>
                                                            <th scope="col">NO REFERENSI</th>
                                                            <th scope="col">KREDIT</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tbody">`

                            $.each(rs.data, function(i, val) {
                                result += `
                                        <tr>
                                            <th scope="row" class="text-center">${i + 1}</th>
                                            <td>${val['date_trx']}</td>
                                            <td>${val['date_paid']}</td>
                                            <td>${val['description']}</td>
                                            <td>${val['sttl_file_name']}</td>
                                            <td>${val['no_ref']}</td>
                                            <td class="text-right">${val['kredit']}</td>
                                        </tr>`
                            })             

                            result += `
                                    </tbody>
                                </table>
                            </div>`

                            $(".tab-content-body").append(result)

                            $('#exceltable').DataTable({
                                "scrollX": true
                            });

                            DataMandiri = rs.data
                        } else {
                            loaderEnd()

                            Swal.fire('Error','Terjadi kesalahan pada server', 'error');
                        }
                    }
                })
            };

            reader.readAsBinaryString(fileInput.files[0]);
        };

        readFile()
    }

    $(document).on('click', '#save-excel',function(e){
        let bank = $('#bank_id').find(":selected").text()

        switch(bank) {
            case "BCA":
                saveExcel("BCA", DataBCA)
                break;
            case "BNI":
                saveExcel("BNI", DataBNI)
                break;
            case "BRI":
                saveExcel("BRI", DataBRI)
                break;
            case "Mandiri":
                saveExcel("Mandiri", DataMandiri)
                break;
            default:
            errorServer()
        }
    })

    function saveExcel(bank, data){
        Swal.fire({
            title: "",
            icon: "info",
            text: "Proses menampilkan data, mohon ditunggu...",
            didOpen: function() {
                Swal.showLoading()
            }
        });

        $.ajax({
            url : url + "_save_" + bank + "Paid",
            method: 'post',
            dataType : 'json',
            data : {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                data: JSON.stringify(data),
                name_file: $('#filename').text()
            },
            success : function (rs) {
                $('#datatable').DataTable().ajax.reload();

                if(rs.success == true) {
                    swal.close()

                    $('#formexcel')[0].reset()
                    $('#bank_id').val(null).trigger('change')
                    $('#filename').text("");

                    $('.btn-group-download-template').css('display', 'none')
                    $('.btn-group-process-file').css('display', 'none')
                    $('#save-excel').css('display', "none")

                    $(".tab-content-body").html('')

                    Swal.fire('Sukses','Berhasil menambahkan sttl ' + bank, 'success')
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: rs.message,
                    })
                }
            }
        })
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function loaderStart() {
        Swal.fire({
            title: "",
            icon: "info",
            text: "Proses menampilkan data, mohon ditunggu...",
            didOpen: function() {
                Swal.showLoading()
            }
        });
    }

    function loaderEnd() {
        swal.close();
    }

    function templateWrong() {
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan Upload Template',
            text: 'Silahkan gunakan template yang benar'
        })
    }

    function errorServer() {
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan template',
            text: 'Silahkan hub customer service!'
        })
    }

</script>

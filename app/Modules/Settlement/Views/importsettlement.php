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
                        <a class="nav-link" data-toggle="tab" href="#tab-log" role="tab" aria-controls="tab-log" aria-selected="true"><i class="fa fa-calendar" aria-hidden="true"></i> Log</a>
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

                            <button type="button" class="btn btn-success ml-auto" id="save-excel" style="display: none;">Simpan File</button>

                        </div>
                        <div class="tab-pane fade" id="tab-log" role="tabpanel" aria-labelledby="tab-log">
                            <div class="form-group row">
                                <div class="input-group mb-3 col-lg-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-md date" name="date-haltebis" id="date-haltebis" placeholder="Masukkan Tanggal" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="btn-group-haltebis" style="display: none;">
                                        <button class="btn btn-white">Export</button>
                                        <button class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu bg-dark" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(93px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" id="download-haltebis-pdf">
                                                PDF
                                            </a>    
                                            <!-- <a class="dropdown-item">
                                                Excel
                                            </a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div id="statistik-rekap-haltebis"></div>
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
        // coreEvents.tableColumn = datatableColumn();

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
        
        // coreEvents.load(null, [0, 'asc'], null);

    });

    $('#bank_id').on('change', function() {
        $('.btn-group-download-template').css('display', 'block')

        if($('#excelfile').val() !== ""){

            $('.btn-group-process-file').css('display', 'block')
            // $('#simpanexcel').css('display','none');
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
        // $('#divexceltable').html('');

        if($('#bank_id').val() !== "" && $('#bank_id').val() !== null){

            $('.btn-group-process-file').css('display', 'block')
            // $('#simpanexcel').css('display','none');
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
                        loadCSVBNI(fileInput)
                        break;
                    case "BRI":
                        loadCSVBRI(fileInput)
                        break;
                    case "Mandiri":
                        loadCSVMandiri(fileInput)
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
            let result = `<div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tanggal Transaksi</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Cabang</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                        `

            let reader = new FileReader();

            reader.onload = function () {
                let readerResult = reader.result.split(/\r\n|\n|\r/);

                let resultCSV = [];
                let blackListWord =  ["Saldo Awal", "Mutasi Debet", "Mutasi Kredit", "Saldo Akhir"];
                for (let i = 0; i < readerResult.length; i++) {
                    if(i != 0) {
                        csvLineSplit =  readerResult[i].split('","');

                        if(csvLineSplit != "") {
                            resultCSV.push(csvLineSplit);
                            if(readerResult[i][0] == 0){
                                resultCSV.pop()
                            }
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

                $.each(resultCSV, function(i, val) {
                    result += `
                            <tr>
                                <th scope="row">${i + 1}</th>
                                <td>${val[0]}</td>
                                <td>${val[1]}</td>
                                <td>${val[2]}</td>
                                <td>${val[3]}</td>
                                <td>${val[4]}</td>
                            </tr>
                    `
                })             

                result += `
                                </tbody>
                            </table>
                        </div>
                `

                $(".tab-content-body").append(result)

                DataBCA = resultCSV

                console.info("cek result csv")
                console.info(resultCSV)

                $.ajax({
                    url : url + "_load_" + bank + "Paid",
                    method: 'post',
                    dataType : 'json',
                    data : {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                        data: JSON.stringify(data)
                    },
                    success : function (rs) {
                        // table.ajax.reload();
                        console.log(rs);

                        if(rs.success == true) {

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: rs.message,
                            })
                        }
                    }
                })
            };

            reader.readAsBinaryString(fileInput.files[0]);
        };

        readFile()
    }

    let DataBNI
    function loadCSVBNI(fileInput){
        readFile = function () {

        let result = `<div class="table-responsive">
                        <table class="table ttable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Post Date</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Journal No</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Db/Cr</th>
                                    <th scope="col">Balance</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                    `

        let reader = new FileReader();

        reader.onload = function () {
            let readerResult = reader.result.split(/\r\n|\n|\r/);

            let resultCSV = [];
            let blackListWord =  ["No."];
            for (let i = 0; i < readerResult.length; i++) {
                if(i != 0) {
                    csvLineSplit =  readerResult[i].split(';');

                    if(csvLineSplit != "") {
                        resultCSV.push(csvLineSplit);
                        if(readerResult[i][0] == 0){
                            resultCSV.pop()
                        }
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

            $.each(resultCSV, function(i, val) {
                result += `
                        <tr>
                            <th scope="row">${val[0]}</th>
                            <td>${val[1]}</td>
                            <td>${val[2]}</td>
                            <td>${val[3]}</td>
                            <td>${val[4]}</td>
                            <td>${val[5]}</td>
                            <td>${val[6]}</td>
                            <td>${val[7]}</td>
                        </tr>
                `
            })             

            result += `
                        </tbody>
                    </table>
                </div>
            `

            $(".tab-content-body").append(result)

            DataBNI = resultCSV
        };

        reader.readAsBinaryString(fileInput.files[0]);
        };

        readFile()
    }

    let DataBRI
    function loadCSVBRI(fileInput){
        readFile = function () {

        let result = `<div class="table-responsive">
                        <table class="table ttable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Transaksi</th>
                                    <th scope="col">Debet</th>
                                    <th scope="col">Kredit</th>
                                    <th scope="col">Saldo</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                    `

        let reader = new FileReader();

        reader.onload = function () {
            let readerResult = reader.result.split(/\r\n|\n|\r/);

            let resultCSV = [];
            let blackListWord =  ["tanggal"];
            for (let i = 0; i < readerResult.length; i++) {
                if(i != 0) {
                    csvLineSplit =  readerResult[i].split(';');

                    if(csvLineSplit != "") {
                        resultCSV.push(csvLineSplit);
                        if(readerResult[i][0] == 0){
                            resultCSV.pop()
                        }
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

            $.each(resultCSV, function(i, val) {
                result += `
                        <tr>
                            <th scope="row">${i + 1}</th>
                            <td>${val[0]}</td>
                            <td>${val[1]}</td>
                            <td>${val[2]}</td>
                            <td>${val[3]}</td>
                            <td>${val[4]}</td>
                        </tr>
                `
            })             

            result += `
                        </tbody>
                    </table>
                </div>
            `

            $(".tab-content-body").append(result)

            DataBRI = resultCSV
        };

        reader.readAsBinaryString(fileInput.files[0]);
        };

        readFile()
    }

    let DataMandiri
    function loadCSVMandiri(fileInput){
        readFile = function () {

        let result = `<div class="table-responsive">
                        <table class="table ttable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Account No</th>
                                    <th scope="col">Date & Time</th>
                                    <th scope="col">Value Date</th>
                                    <th scope="col">Account No Alias</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Reference No</th>
                                    <th scope="col">Debit</th>
                                    <th scope="col">Kredit</th>
                                    <th scope="col">Balance</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                    `

        let reader = new FileReader();

        reader.onload = function () {
            let readerResult = reader.result.split(/\r\n|\n|\r/);

            let resultCSV = [];
            let blackListWord =  ["Account No."];
            for (let i = 0; i < readerResult.length; i++) {
                if(i != 0) {
                    if(i % 2 == 1) {
                        csvLineSplit = $.merge(readerResult[i].split(';'), readerResult[i + 1].split(';'))

                        if(csvLineSplit != "") {
                            resultCSV.push(csvLineSplit);
                            if(readerResult[i][0] == 0){
                                resultCSV.pop()
                            }
                        }
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

            $.each(resultCSV, function(i, val) {
                result += `
                        <tr>
                            <th scope="row">${i + 1}</th>
                            <td>${val[0]}</td>
                            <td>${val[1]}</td>
                            <td>${val[2]}</td>
                            <td>${val[3]}</td>
                            <td>${val[4]}</td>
                            <td>${val[5]}</td>
                            <td>${val[6]}</td>
                            <td>${val[7]}</td>
                            <td>${val[8]}</td>
                        </tr>
                `
            })             

            result += `
                            </tbody>
                        </table>
                    </div>
            `

            $(".tab-content-body").append(result)

            DataMandiri = resultCSV
        };

        reader.readAsBinaryString(fileInput.files[0]);
        };

        readFile()
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan template',
                text: 'Silahkan hub team!'
            })
        }
    })

    function saveExcel(bank, data){
        $.ajax({
            url : url + "_save_" + bank + "Paid",
            method: 'post',
            dataType : 'json',
            data : {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                data: JSON.stringify(data)
            },
            success : function (rs) {
                // table.ajax.reload();
                console.log(rs);

                if(rs.success == true) {

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

</script>

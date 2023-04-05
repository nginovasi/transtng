<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<div>
    <div class="page-hero page-container " id="page-hero">
        <div class="padding d-flex">
            <div class="page-title">
                <h2 class="text-md text-highlight">
                    <?= $page_title ?>
                </h2>
            </div>
            <div class="flex"></div>
        </div>
    </div>
    <div class="page-content page-container" id="page-content">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills no-border" id="tab">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data" aria-selected="false">Scanner QR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-form" role="tab" aria-controls="tab-form" aria-selected="false">Data</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <section class="content">
                                    <form data-plugin="parsley" data-option="{}" id="form">
                                        <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                        <?= csrf_field(); ?>
                                        <!-- Default box -->
                                        <div class="card">
                                            <div id="reader" style="display: inline-block; position: relative; padding: 0px; border: 1px solid silver;">
                                                <div style="text-align: left; margin: 0px;">
                                                    <div style="position: absolute; top: 10px; right: 10px; z-index: 2; display: none; padding: 5pt; border: 1px solid rgb(23, 23, 23); font-size: 10pt; background: rgba(0, 0, 0, 0.69); border-radius: 5px; text-align: center; font-weight: 400; color: white;">
                                                        Powered by <a href="https://scanapp.org" target="new" style="color: white;">ScanApp</a><br><br><a href="https://github.com/mebjas/html5-qrcode/issues" target="new" style="color: white;">Report
                                                            issues</a></div><img alt="Info icon" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0NjAgNDYwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NjAgNDYwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cGF0aCBkPSJNMjMwIDBDMTAyLjk3NSAwIDAgMTAyLjk3NSAwIDIzMHMxMDIuOTc1IDIzMCAyMzAgMjMwIDIzMC0xMDIuOTc0IDIzMC0yMzBTMzU3LjAyNSAwIDIzMCAwem0zOC4zMzMgMzc3LjM2YzAgOC42NzYtNy4wMzQgMTUuNzEtMTUuNzEgMTUuNzFoLTQzLjEwMWMtOC42NzYgMC0xNS43MS03LjAzNC0xNS43MS0xNS43MVYyMDIuNDc3YzAtOC42NzYgNy4wMzMtMTUuNzEgMTUuNzEtMTUuNzFoNDMuMTAxYzguNjc2IDAgMTUuNzEgNy4wMzMgMTUuNzEgMTUuNzFWMzc3LjM2ek0yMzAgMTU3Yy0yMS41MzkgMC0zOS0xNy40NjEtMzktMzlzMTcuNDYxLTM5IDM5LTM5IDM5IDE3LjQ2MSAzOSAzOS0xNy40NjEgMzktMzkgMzl6Ii8+PC9zdmc+" style="position: absolute; top: 4px; right: 4px; opacity: 0.6; cursor: pointer; z-index: 2; width: 16px; height: 16px;">
                                                    <div id="reader__header_message" style="display: none; text-align: center; font-size: 14px; padding: 2px 10px; margin: 4px; border-top: 1px solid rgb(246, 246, 246);">
                                                    </div>
                                                </div>
                                                <div id="reader__scan_region" style="width: 100%; min-height: 100px; text-align: center;"><br><img width="64" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNzEuNjQzIDM3MS42NDMiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDM3MS42NDMgMzcxLjY0MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PHBhdGggZD0iTTEwNS4wODQgMzguMjcxaDE2My43Njh2MjBIMTA1LjA4NHoiLz48cGF0aCBkPSJNMzExLjU5NiAxOTAuMTg5Yy03LjQ0MS05LjM0Ny0xOC40MDMtMTYuMjA2LTMyLjc0My0yMC41MjJWMzBjMC0xNi41NDItMTMuNDU4LTMwLTMwLTMwSDEyNS4wODRjLTE2LjU0MiAwLTMwIDEzLjQ1OC0zMCAzMHYxMjAuMTQzaC04LjI5NmMtMTYuNTQyIDAtMzAgMTMuNDU4LTMwIDMwdjEuMzMzYTI5LjgwNCAyOS44MDQgMCAwIDAgNC42MDMgMTUuOTM5Yy03LjM0IDUuNDc0LTEyLjEwMyAxNC4yMjEtMTIuMTAzIDI0LjA2MXYxLjMzM2MwIDkuODQgNC43NjMgMTguNTg3IDEyLjEwMyAyNC4wNjJhMjkuODEgMjkuODEgMCAwIDAtNC42MDMgMTUuOTM4djEuMzMzYzAgMTYuNTQyIDEzLjQ1OCAzMCAzMCAzMGg4LjMyNGMuNDI3IDExLjYzMSA3LjUwMyAyMS41ODcgMTcuNTM0IDI2LjE3Ny45MzEgMTAuNTAzIDQuMDg0IDMwLjE4NyAxNC43NjggNDUuNTM3YTkuOTg4IDkuOTg4IDAgMCAwIDguMjE2IDQuMjg4IDkuOTU4IDkuOTU4IDAgMCAwIDUuNzA0LTEuNzkzYzQuNTMzLTMuMTU1IDUuNjUtOS4zODggMi40OTUtMTMuOTIxLTYuNzk4LTkuNzY3LTkuNjAyLTIyLjYwOC0xMC43Ni0zMS40aDgyLjY4NWMuMjcyLjQxNC41NDUuODE4LjgxNSAxLjIxIDMuMTQyIDQuNTQxIDkuMzcyIDUuNjc5IDEzLjkxMyAyLjUzNCA0LjU0Mi0zLjE0MiA1LjY3Ny05LjM3MSAyLjUzNS0xMy45MTMtMTEuOTE5LTE3LjIyOS04Ljc4Ny0zNS44ODQgOS41ODEtNTcuMDEyIDMuMDY3LTIuNjUyIDEyLjMwNy0xMS43MzIgMTEuMjE3LTI0LjAzMy0uODI4LTkuMzQzLTcuMTA5LTE3LjE5NC0xOC42NjktMjMuMzM3YTkuODU3IDkuODU3IDAgMCAwLTEuMDYxLS40ODZjLS40NjYtLjE4Mi0xMS40MDMtNC41NzktOS43NDEtMTUuNzA2IDEuMDA3LTYuNzM3IDE0Ljc2OC04LjI3MyAyMy43NjYtNy42NjYgMjMuMTU2IDEuNTY5IDM5LjY5OCA3LjgwMyA0Ny44MzYgMTguMDI2IDUuNzUyIDcuMjI1IDcuNjA3IDE2LjYyMyA1LjY3MyAyOC43MzMtLjQxMyAyLjU4NS0uODI0IDUuMjQxLTEuMjQ1IDcuOTU5LTUuNzU2IDM3LjE5NC0xMi45MTkgODMuNDgzLTQ5Ljg3IDExNC42NjEtNC4yMjEgMy41NjEtNC43NTYgOS44Ny0xLjE5NCAxNC4wOTJhOS45OCA5Ljk4IDAgMCAwIDcuNjQ4IDMuNTUxIDkuOTU1IDkuOTU1IDAgMCAwIDYuNDQ0LTIuMzU4YzQyLjY3Mi0zNi4wMDUgNTAuODAyLTg4LjUzMyA1Ni43MzctMTI2Ljg4OC40MTUtMi42ODQuODIxLTUuMzA5IDEuMjI5LTcuODYzIDIuODM0LTE3LjcyMS0uNDU1LTMyLjY0MS05Ljc3Mi00NC4zNDV6bS0yMzIuMzA4IDQyLjYyYy01LjUxNCAwLTEwLTQuNDg2LTEwLTEwdi0xLjMzM2MwLTUuNTE0IDQuNDg2LTEwIDEwLTEwaDE1djIxLjMzM2gtMTV6bS0yLjUtNTIuNjY2YzAtNS41MTQgNC40ODYtMTAgMTAtMTBoNy41djIxLjMzM2gtNy41Yy01LjUxNCAwLTEwLTQuNDg2LTEwLTEwdi0xLjMzM3ptMTcuNSA5My45OTloLTcuNWMtNS41MTQgMC0xMC00LjQ4Ni0xMC0xMHYtMS4zMzNjMC01LjUxNCA0LjQ4Ni0xMCAxMC0xMGg3LjV2MjEuMzMzem0zMC43OTYgMjguODg3Yy01LjUxNCAwLTEwLTQuNDg2LTEwLTEwdi04LjI3MWg5MS40NTdjLS44NTEgNi42NjgtLjQzNyAxMi43ODcuNzMxIDE4LjI3MWgtODIuMTg4em03OS40ODItMTEzLjY5OGMtMy4xMjQgMjAuOTA2IDEyLjQyNyAzMy4xODQgMjEuNjI1IDM3LjA0IDUuNDQxIDIuOTY4IDcuNTUxIDUuNjQ3IDcuNzAxIDcuMTg4LjIxIDIuMTUtMi41NTMgNS42ODQtNC40NzcgNy4yNTEtLjQ4Mi4zNzgtLjkyOS44LTEuMzM1IDEuMjYxLTYuOTg3IDcuOTM2LTExLjk4MiAxNS41Mi0xNS40MzIgMjIuNjg4aC05Ny41NjRWMzBjMC01LjUxNCA0LjQ4Ni0xMCAxMC0xMGgxMjMuNzY5YzUuNTE0IDAgMTAgNC40ODYgMTAgMTB2MTM1LjU3OWMtMy4wMzItLjM4MS02LjE1LS42OTQtOS4zODktLjkxNC0yNS4xNTktMS42OTQtNDIuMzcgNy43NDgtNDQuODk4IDI0LjY2NnoiLz48cGF0aCBkPSJNMTc5LjEyOSA4My4xNjdoLTI0LjA2YTUgNSAwIDAgMC01IDV2MjQuMDYxYTUgNSAwIDAgMCA1IDVoMjQuMDZhNSA1IDAgMCAwIDUtNVY4OC4xNjdhNSA1IDAgMCAwLTUtNXpNMTcyLjYyOSAxNDIuODZoLTEyLjU2VjEzMC44YTUgNSAwIDEgMC0xMCAwdjE3LjA2MWE1IDUgMCAwIDAgNSA1aDE3LjU2YTUgNSAwIDEgMCAwLTEwLjAwMXpNMjE2LjU2OCA4My4xNjdoLTI0LjA2YTUgNSAwIDAgMC01IDV2MjQuMDYxYTUgNSAwIDAgMCA1IDVoMjQuMDZhNSA1IDAgMCAwIDUtNVY4OC4xNjdhNSA1IDAgMCAwLTUtNXptLTUgMjQuMDYxaC0xNC4wNlY5My4xNjdoMTQuMDZ2MTQuMDYxek0yMTEuNjY5IDEyNS45MzZIMTk3LjQxYTUgNSAwIDAgMC01IDV2MTQuMjU3YTUgNSAwIDAgMCA1IDVoMTQuMjU5YTUgNSAwIDAgMCA1LTV2LTE0LjI1N2E1IDUgMCAwIDAtNS01eiIvPjwvc3ZnPg==" style="opacity: 0.8;"></div>
                                                <div id="reader__dashboard" style="width: 100%;">
                                                    <div id="reader__dashboard_section" style="width: 100%; padding: 10px 0px; text-align: left;">
                                                        <div>
                                                            <div id="reader__dashboard_section_csr" style="display: block;">
                                                                <div style="text-align: center;"><button id="html5-qrcode-button-camera-permission" class="html5-qrcode-element">Request Camera
                                                                        Permissions</button></div>
                                                            </div>
                                                            <div style="text-align: center; margin: auto auto 10px; width: 80%; max-width: 600px; border: 6px dashed rgb(235, 235, 235); padding: 10px; display: none;">
                                                                <label for="html5-qrcode-private-filescan-input" style="display: inline-block;"><button id="html5-qrcode-button-file-selection" class="html5-qrcode-element">Choose Image - No
                                                                        image choosen</button><input id="html5-qrcode-private-filescan-input" class="html5-qrcode-element" type="file" accept="image/*" style="display: none;"></label>
                                                                <div style="font-weight: 400;">Or drop an image to scan
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="text-align: center;"><a id="html5-qrcode-anchor-scan-type-change" class="html5-qrcode-element" style="text-decoration: underline;">Scan an Image
                                                                File</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="empty"></div>
                                            <div id="scanned-result"></div>

                                            <div class="form-group">
                                                <br />
                                                <label>Satus Verifikasi</label>
                                                <input type="text" class="form-control" id="is_verified" name="is_verified" autocomplete="off" placeholder="STATUS VERIVIKASI" disabled>
                                                <br />
                                                <label>Nama</label>
                                                <input type="text" class="form-control" id="scan_qr" name="scan_qr" autocomplete="off" placeholder="NAMA" disabled>
                                                <br />
                                                <label>NIK</label>
                                                <input type="text" class="form-control" id="nik" name="nik" autocomplete="off" placeholder="NIK" disabled>
                                                <br />
                                                <label>Kode Billing</label>
                                                <input type="text" class="form-control" id="billing" name="billing" autocomplete="off" placeholder="Kode Billing" disabled>
                                                <br />
                                                <label>Kode Transaksi</label>
                                                <input type="text" class="form-control" id="kodetransaksi" name="kodetransaksi" autocomplete="off" placeholder="Nomor Transaksi" disabled>
                                                <br />
                                                <label>Alasan Unverifikasi</label>
                                                <input type="text" class="form-control" id="reject_verified_reason" name="reject_verified_reason" autocomplete="off" placeholder="" disabled>

                                            </div>


                                            <div class="card-footer text-center">
                                                <button type="submit" id="submit" class="btn btn-primary">Check In</button>/
                                               
                                                <!-- <a href="#" onClick="unverif()" class="btn btn-danger" disabled>Unverifikasi</a> -->
                                            </div>
                                    </form>
                            </div>

                            </section>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                        <div class="card-body">
                            <div class="padding">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-theme table-row v-middle">
                                                <thead>
                                                    <tr>

                                                        <th><span>#</span></th>
                                                        <th><span>Nama</span></th>
                                                        <th><span>NIK</span></th>
                                                        <th><span>Kode Transaksi</span></th>
                                                        <th><span>Kode Billing</span></th>
                                                        <th><span>Nomor Kursi</span></th>
                                                        <th class="column-2action">Cetak</th>
                                                        <th><span></span></th>
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
        </div>
    </div>
</div>
</div>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script type="text/javascript">
    const auth_insert = '<?= $rules->i ?>';
    const auth_edit = '<?= $rules->e ?>';
    const auth_delete = '<?= $rules->d ?>';
    const auth_otorisasi = '<?= $rules->o ?>';

    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';
    const url_pdf_verif = '<?= base_url() . "/" . uri_segment(0) . "/action/pdf/verifikasipesertamudik" ?>';

    var dataStart = 0;
    var coreEvents;

    function unverif() {
        Swal.fire({
            title: 'Masukkan Alasan Ditolak',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off',
                id: 'reject_verified_reason',
                required: true
            },
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            showLoaderOnConfirm: true,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Loading...',
                    html: 'Please wait',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
                $.ajax({
                    url: url + '_unverif',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        // 'transaction_number': $('#kodetransaksi').val(),
                        'id': $('#id').val(),
                        'reject_verified_reason': result.value,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>' // just for security purpose
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            Swal.close();
                            Swal.fire({
                                title: data.title,
                                text: data.message,
                                icon: data.status,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            window.location.reload();
                        } else {
                            Swal.fire({
                                title: data.title,
                                text: data.message,
                                icon: data.status,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            window.location.reload();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire({
                            title: 'Error',
                            text: xhr.status + ' ' + thrownError,
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        })
    }


    $(document).ready(function() {
        $('#submit').attr('disabled', false);

        function onScanSuccess(decodedText, decodedResult) {
            html5QrcodeScanner.clear();
            const qrid = decodedText;
            if (qrid != '') {
                Swal.fire({
                    title: 'Loading...',
                    html: 'Please wait',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'QR Code tidak ditemukan!',
                });
            }
            $.ajax({
                url: url + '_edit',
                type: 'POST',
                dataType: 'json',
                data: {
                    'transaction_number': qrid,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>' // just for security purpose
                },
                success: function(data) {
                    Swal.close();
                    if (data.success) {
                        var is_verified = data.data.is_verified;
                        var billing_code = data.data.billing_code;
                        var transaction_booking_name = data.data.transaction_booking_name;
                        var transaction_nik = data.data.transaction_nik;
                        var transaction_number = data.data.transaction_number;
                        var reject_verified_reason = data.data.reject_verified_reason;

                        if (is_verified == 0) {
                            is_verified = 'BELUM VERIFIKASI';
                            $('#submit').attr('disabled', true);
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Anda belum melakukan verifikasi data peserta',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload(); // Reload the page
                                }
                            });
                        } else if (is_verified == 1) {
                            is_verified = 'SUDAH TERVERIFIKASI';
                        } else if (is_verified == 2) {
                            is_verified = 'DITOLAK';
                            $('#submit').attr('disabled', true);
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'DATA ANDA DI TOLAK / TIDAK SESUAI',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload(); // Reload the page
                                }
                            });
                        } else if (is_verified == 3) {
                            is_verified = 'Sudah Verifikasi Ulang';
                        }
                        $('#is_verified').val(is_verified);
                        $('#scan_qr').val(data.data.transaction_booking_name);
                        $('#nik').val(data.data.transaction_nik);
                        $('#billing').val(data.data.billing_code);
                        $('#kodetransaksi').val(data.data.transaction_number);
                        $('#reject_verified_reason').val(data.data.reject_verified_reason);
                        $('#id').val(data.data.id);

                        // Create a new table row with the data
                        var row = $('<tr>').append(
                            $('<td>').text(is_verified),
                            $('<td>').text(billing_code),
                            $('<td>').text(transaction_booking_name),
                            $('<td>').text(transaction_nik),
                            $('<td>').text(transaction_number),
                            $('<td>').text(reject_verified_reason)
                        );
                        // Append the row to the table
                        $('#my-table tbody').append(row);
                    } else {
                        $('#scanned-result').html('<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
                        Swal.fire({
                            title: 'warning',
                            text: 'Data Tidak Ditemukan',
                            icon: 'warning',
                            showConfirmButton: true,
                            // timer: 1500

                        }).then((result) => {
                            window.location.reload(); // Reload the page
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                delay: 5000,
                mirror: true,
                qrbox: 700
            });
        html5QrcodeScanner.render(onScanSuccess);

        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };
        coreEvents.tableColumn = datatableColumn()

        // form submit
        $(document).on('submit', '#form', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            $.ajax({
                url: url + '_save',
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    // console.log(data.success);
                    if (data.success == 1) {
                        Swal.fire({
                            title: data.title,
                            text: data.message,
                            icon: data.status,
                            icon: "success",
                            showCancelButton: false,
                            showCancelButton: false,
                            timer: 10000, // Set the timer to 5 seconds
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload(); // Reload the page
                            }
                        });
                    } else if (data.success == 2) {
                        Swal.fire({
                            title: data.title,
                            text: data.message,
                            icon: data.status,
                            icon: "warning",
                            showConfirmButton: true,
                            confirmButtonText: "Oke",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload(); // Reload the page
                            }
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        title: 'error',
                        text: xhr.status + ' ' + thrownError,
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1500

                    }).then((result) => {
                        window.location.reload(); // Reload the page
                    });
                }
            });
        })
        // window.location.reload();

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
                console.log("hello world2");
                window.location.reload();
            }
        }

        coreEvents.deleteHandler = {
            placeholder: '',
            afterAction: function() {

            }
        }

        coreEvents.resetHandler = {
            action: function() {
                console.log("hello world3");
            }
        }

        coreEvents.load();
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

    // $where = ["a.id", "a.transaction_booking_name", "a.transaction_nik", "a.transaction_number", "a.billing_code", "a.transaction_seat_id"];


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
                data: "transaction_booking_name",
                orderable: true
            },
            {
                data: "transaction_nik",
                orderable: true
            },
            {
                data: "transaction_number",
                orderable: true
            },
            {
                data: "billing_code",
                orderable: true
            },
            {
                data: "transaction_seat_id",
                orderable: true
            },
            {
                data: "id",
                orderable: false,
                render: function(a, type, data, index) {
                    let button = ''

                    // if (auth_edit == "1") {
                    //     button += '<button class="btn btn-sm btn-outline-success" data-id="' + data.id + '" title="Print" target="_blank">\
                    // <i class="fa fa-print"></i> \
                    // </button>\
                    // ';
                    // }

                    // if (auth_edit == "1") {
                    //     button += '<button class="btn btn-sm btn-outline-success" data-id="' + data.id + '" title="Print" target="_blank">\
                    //                 <i class="fa fa-print"></i> \
                    //             </button>\
                    //             ';
                    // }

                    if (auth_edit == "1") {
                        button += ' <a href="' + url_pdf_verif + '/p?o=p&search=' + btoa(data['billing_code']) + '.' + btoa(data['id']) + '" target="_blank">\
                                    <button class="btn btn-sm btn-outline-success" title="Print"><i class="fa fa-print"></i></button>\
                                </a>';
                    }

                    button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

                    return button;
                }
            }
        ];

        return columns;
    }
</script>
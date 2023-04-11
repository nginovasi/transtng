<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<div>
    <div class="page-hero page-container " id="page-hero">
        <div class="padding d-flex">
            <div class="page-title">
                <h2 class="text-md text-highlight"><?= $page_title ?></h2>
                <small class="text-muted">
                    <strong></strong>
                </small>
            </div>
            <div class="flex"></div>
            <div></div>
        </div>
    </div>
    <div class="page-content page-container" id="page-content">
        <div class="padding">
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
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <div class="content">
                                    <!-- <form data-plugin="parsley" data-option="{}" id="form">
                                        <input type="hidden" class="form-control" id="id" name="id" value="" required> -->
                                    <!-- <?= csrf_field() ?> -->
                                    <!-- Default box -->
                                    <div class="card">
                                        <div id="reader" style="display: inline-block; position: relative; padding: 0px; border: 1px solid silver;">
                                            <div style="text-align: left; margin: 0px;">
                                                <div style="position: absolute; top: 10px; right: 10px; z-index: 2; display: none; padding: 5pt; border: 1px solid rgb(23, 23, 23); font-size: 10pt; background: rgba(0, 0, 0, 0.69); border-radius: 5px; text-align: center; font-weight: 400; color: white;">
                                                    Powered by
                                                    <a href="https://scanapp.org" target="new" style="color: white;">ScanApp</a><br><br>
                                                    <a href="https://github.com/mebjas/html5-qrcode/issues" target="new" style="color: white;">Report issues</a>
                                                </div>
                                                <img alt="Info icon" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0NjAgNDYwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NjAgNDYwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cGF0aCBkPSJNMjMwIDBDMTAyLjk3NSAwIDAgMTAyLjk3NSAwIDIzMHMxMDIuOTc1IDIzMCAyMzAgMjMwIDIzMC0xMDIuOTc0IDIzMC0yMzBTMzU3LjAyNSAwIDIzMCAwem0zOC4zMzMgMzc3LjM2YzAgOC42NzYtNy4wMzQgMTUuNzEtMTUuNzEgMTUuNzFoLTQzLjEwMWMtOC42NzYgMC0xNS43MS03LjAzNC0xNS43MS0xNS43MVYyMDIuNDc3YzAtOC42NzYgNy4wMzMtMTUuNzEgMTUuNzEtMTUuNzFoNDMuMTAxYzguNjc2IDAgMTUuNzEgNy4wMzMgMTUuNzEgMTUuNzFWMzc3LjM2ek0yMzAgMTU3Yy0yMS41MzkgMC0zOS0xNy40NjEtMzktMzlzMTcuNDYxLTM5IDM5LTM5IDM5IDE3LjQ2MSAzOSAzOS0xNy40NjEgMzktMzkgMzl6Ii8+PC9zdmc+" style="position: absolute; top: 4px; right: 4px; opacity: 0.6; cursor: pointer; z-index: 2; width: 16px; height: 16px;">
                                                <div id="reader__header_message" style="display: none; text-align: center; font-size: 14px; padding: 2px 10px; margin: 4px; border-top: 1px solid rgb(246, 246, 246);"></div>
                                            </div>
                                            <div id="reader__scan_region" style="width: 100%; min-height: 100px; text-align: center;"><br>
                                                <img width="64" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNzEuNjQzIDM3MS42NDMiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDM3MS42NDMgMzcxLjY0MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PHBhdGggZD0iTTEwNS4wODQgMzguMjcxaDE2My43Njh2MjBIMTA1LjA4NHoiLz48cGF0aCBkPSJNMzExLjU5NiAxOTAuMTg5Yy03LjQ0MS05LjM0Ny0xOC40MDMtMTYuMjA2LTMyLjc0My0yMC41MjJWMzBjMC0xNi41NDItMTMuNDU4LTMwLTMwLTMwSDEyNS4wODRjLTE2LjU0MiAwLTMwIDEzLjQ1OC0zMCAzMHYxMjAuMTQzaC04LjI5NmMtMTYuNTQyIDAtMzAgMTMuNDU4LTMwIDMwdjEuMzMzYTI5LjgwNCAyOS44MDQgMCAwIDAgNC42MDMgMTUuOTM5Yy03LjM0IDUuNDc0LTEyLjEwMyAxNC4yMjEtMTIuMTAzIDI0LjA2MXYxLjMzM2MwIDkuODQgNC43NjMgMTguNTg3IDEyLjEwMyAyNC4wNjJhMjkuODEgMjkuODEgMCAwIDAtNC42MDMgMTUuOTM4djEuMzMzYzAgMTYuNTQyIDEzLjQ1OCAzMCAzMCAzMGg4LjMyNGMuNDI3IDExLjYzMSA3LjUwMyAyMS41ODcgMTcuNTM0IDI2LjE3Ny45MzEgMTAuNTAzIDQuMDg0IDMwLjE4NyAxNC43NjggNDUuNTM3YTkuOTg4IDkuOTg4IDAgMCAwIDguMjE2IDQuMjg4IDkuOTU4IDkuOTU4IDAgMCAwIDUuNzA0LTEuNzkzYzQuNTMzLTMuMTU1IDUuNjUtOS4zODggMi40OTUtMTMuOTIxLTYuNzk4LTkuNzY3LTkuNjAyLTIyLjYwOC0xMC43Ni0zMS40aDgyLjY4NWMuMjcyLjQxNC41NDUuODE4LjgxNSAxLjIxIDMuMTQyIDQuNTQxIDkuMzcyIDUuNjc5IDEzLjkxMyAyLjUzNCA0LjU0Mi0zLjE0MiA1LjY3Ny05LjM3MSAyLjUzNS0xMy45MTMtMTEuOTE5LTE3LjIyOS04Ljc4Ny0zNS44ODQgOS41ODEtNTcuMDEyIDMuMDY3LTIuNjUyIDEyLjMwNy0xMS43MzIgMTEuMjE3LTI0LjAzMy0uODI4LTkuMzQzLTcuMTA5LTE3LjE5NC0xOC42NjktMjMuMzM3YTkuODU3IDkuODU3IDAgMCAwLTEuMDYxLS40ODZjLS40NjYtLjE4Mi0xMS40MDMtNC41NzktOS43NDEtMTUuNzA2IDEuMDA3LTYuNzM3IDE0Ljc2OC04LjI3MyAyMy43NjYtNy42NjYgMjMuMTU2IDEuNTY5IDM5LjY5OCA3LjgwMyA0Ny44MzYgMTguMDI2IDUuNzUyIDcuMjI1IDcuNjA3IDE2LjYyMyA1LjY3MyAyOC43MzMtLjQxMyAyLjU4NS0uODI0IDUuMjQxLTEuMjQ1IDcuOTU5LTUuNzU2IDM3LjE5NC0xMi45MTkgODMuNDgzLTQ5Ljg3IDExNC42NjEtNC4yMjEgMy41NjEtNC43NTYgOS44Ny0xLjE5NCAxNC4wOTJhOS45OCA5Ljk4IDAgMCAwIDcuNjQ4IDMuNTUxIDkuOTU1IDkuOTU1IDAgMCAwIDYuNDQ0LTIuMzU4YzQyLjY3Mi0zNi4wMDUgNTAuODAyLTg4LjUzMyA1Ni43MzctMTI2Ljg4OC40MTUtMi42ODQuODIxLTUuMzA5IDEuMjI5LTcuODYzIDIuODM0LTE3LjcyMS0uNDU1LTMyLjY0MS05Ljc3Mi00NC4zNDV6bS0yMzIuMzA4IDQyLjYyYy01LjUxNCAwLTEwLTQuNDg2LTEwLTEwdi0xLjMzM2MwLTUuNTE0IDQuNDg2LTEwIDEwLTEwaDE1djIxLjMzM2gtMTV6bS0yLjUtNTIuNjY2YzAtNS41MTQgNC40ODYtMTAgMTAtMTBoNy41djIxLjMzM2gtNy41Yy01LjUxNCAwLTEwLTQuNDg2LTEwLTEwdi0xLjMzM3ptMTcuNSA5My45OTloLTcuNWMtNS41MTQgMC0xMC00LjQ4Ni0xMC0xMHYtMS4zMzNjMC01LjUxNCA0LjQ4Ni0xMCAxMC0xMGg3LjV2MjEuMzMzem0zMC43OTYgMjguODg3Yy01LjUxNCAwLTEwLTQuNDg2LTEwLTEwdi04LjI3MWg5MS40NTdjLS44NTEgNi42NjgtLjQzNyAxMi43ODcuNzMxIDE4LjI3MWgtODIuMTg4em03OS40ODItMTEzLjY5OGMtMy4xMjQgMjAuOTA2IDEyLjQyNyAzMy4xODQgMjEuNjI1IDM3LjA0IDUuNDQxIDIuOTY4IDcuNTUxIDUuNjQ3IDcuNzAxIDcuMTg4LjIxIDIuMTUtMi41NTMgNS42ODQtNC40NzcgNy4yNTEtLjQ4Mi4zNzgtLjkyOS44LTEuMzM1IDEuMjYxLTYuOTg3IDcuOTM2LTExLjk4MiAxNS41Mi0xNS40MzIgMjIuNjg4aC05Ny41NjRWMzBjMC01LjUxNCA0LjQ4Ni0xMCAxMC0xMGgxMjMuNzY5YzUuNTE0IDAgMTAgNC40ODYgMTAgMTB2MTM1LjU3OWMtMy4wMzItLjM4MS02LjE1LS42OTQtOS4zODktLjkxNC0yNS4xNTktMS42OTQtNDIuMzcgNy43NDgtNDQuODk4IDI0LjY2NnoiLz48cGF0aCBkPSJNMTc5LjEyOSA4My4xNjdoLTI0LjA2YTUgNSAwIDAgMC01IDV2MjQuMDYxYTUgNSAwIDAgMCA1IDVoMjQuMDZhNSA1IDAgMCAwIDUtNVY4OC4xNjdhNSA1IDAgMCAwLTUtNXpNMTcyLjYyOSAxNDIuODZoLTEyLjU2VjEzMC44YTUgNSAwIDEgMC0xMCAwdjE3LjA2MWE1IDUgMCAwIDAgNSA1aDE3LjU2YTUgNSAwIDEgMCAwLTEwLjAwMXpNMjE2LjU2OCA4My4xNjdoLTI0LjA2YTUgNSAwIDAgMC01IDV2MjQuMDYxYTUgNSAwIDAgMCA1IDVoMjQuMDZhNSA1IDAgMCAwIDUtNVY4OC4xNjdhNSA1IDAgMCAwLTUtNXptLTUgMjQuMDYxaC0xNC4wNlY5My4xNjdoMTQuMDZ2MTQuMDYxek0yMTEuNjY5IDEyNS45MzZIMTk3LjQxYTUgNSAwIDAgMC01IDV2MTQuMjU3YTUgNSAwIDAgMCA1IDVoMTQuMjU5YTUgNSAwIDAgMCA1LTV2LTE0LjI1N2E1IDUgMCAwIDAtNS01eiIvPjwvc3ZnPg==" style="opacity: 0.8;">
                                            </div>
                                            <div id="reader__dashboard" style="width: 100%;">
                                                <div id="reader__dashboard_section" style="width: 100%; padding: 10px 0px; text-align: left;">
                                                    <div>
                                                        <div id="reader__dashboard_section_csr" style="display: block;">
                                                            <div style="text-align: center;">
                                                                <!-- <button id="html5-qrcode-button-camera-permission" class="html5-qrcode-element">Request Camera Permissions</button> -->
                                                                <button id="html5-qrcode-button-camera-permission" class="html5-qrcode-element">BATAS WAKTU VERIFIKASI SUDAH BERAKHIR</button>
                                                            </div>
                                                        </div>
                                                        <div style="text-align: center; margin: auto auto 10px; width: 80%; max-width: 600px; border: 6px dashed rgb(235, 235, 235); padding: 10px; display: none;">
                                                            <label for="html5-qrcode-private-filescan-input" style="display: inline-block;">
                                                                <button id="html5-qrcode-button-file-selection" class="html5-qrcode-element">Choose Image - No image choosen</button>
                                                                <input id="html5-qrcode-private-filescan-input" class="html5-qrcode-element" type="file" accept="image/*" style="display: none;">
                                                            </label>
                                                            <div style="font-weight: 400;">Or drop an image to scan</div>
                                                        </div>
                                                    </div>
                                                    <div style="text-align: center;">
                                                        <a id="html5-qrcode-anchor-scan-type-change" class="html5-qrcode-element" style="text-decoration: underline;">Scan an Image File</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="empty"></div>
                                        <div id="scanned-result"></div>
                                    </div>
                                    <!-- </form> -->
                                </div>
                            </div>
                            <div class="content">
                                <label>Kode Billing</label>
                                <input type="text" class="form-control" id="billing_code" name="billing_code" autocomplete="off" placeholder="Kode Billing" disabled>
                            </div>
                            <table id="my-table" class="table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Kode Transaksi</th>
                                        <th>Alasan</th>
                                        <th>Keberangkatan</th>
                                        <th>Tujuan</th>
                                        <th>Nomor Kursi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <br>
                            <button class="btn btn-primary" id="btn-scan">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw mx-2">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <polyline points="23 20 23 14 17 14"></polyline>
                                    <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                                </svg>
                                Scan Ulang
                            </button>
                        </div>
                        <div class="tab-pane fade" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Status Verifikasi</label>
                                                        <select class="form-control sel2" id="is_verif" name="is_verif" required>
                                                            <option value="">Pilih Status Verifikasi</option>
                                                            <option value="1">Terverifikasi</option>
                                                            <option value="0">Belum Verifikasi</option>
                                                            <option value="2">Ditolak</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Cetak Data Verifikasi Dari</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2">
                                                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control form-control-md date" name="date-start" id="date-start" placeholder="Tgl Exp Start" required autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Cetak Data Verifikasi Sampai</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2">
                                                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control form-control-md date" name="date-end" id="date-end" placeholder="Tgl Exp End" required autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label>&nbsp;</label>
                                                        <div class="input-group">
                                                            <a href="#" id="cetaklaporan" target="_blank" class="btn btn-primary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer mx-2">
                                                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                                                    <rect x="6" y="14" width="12" height="8"></rect>
                                                                </svg>
                                                                Cetak
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body padding">
                                        <table id="datatable" class="table table-theme table-row v-middle">
                                            <thead>
                                                <tr>
                                                    <th><span>#</span></th>
                                                    <th><span>Nama</span></th>
                                                    <th><span>NIK</span></th>
                                                    <th><span>Kode Transaksi</span></th>
                                                    <th><span>Kode Billing</span></th>
                                                    <th><span>Nomor Kursi</span></th>
                                                    <th><span>Status Mudik</span></th>
                                                    <th><span>Status Verifikasi</span></th>
                                                    <th class="column-2action">Aksi</th>
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
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script type="text/javascript">
    const auth_insert = '<?= $rules->i ?>';
    const auth_edit = '<?= $rules->e ?>';
    const auth_delete = '<?= $rules->d ?>';
    const auth_otorisasi = '<?= $rules->o ?>';

    const url = '<?= base_url() . '/' . uri_segment(0) . '/action/' . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . '/' . uri_segment(0) . '/ajax' ?>';
    const url_pdf_verif = '<?= base_url() . "/" . uri_segment(0) . "/action/pdf/verifikasimudik" ?>';
    const url_pdf_cetak = '<?= base_url() . "/" . uri_segment(0) . "/action/pdfcetak/verifikasimudikcetak" ?>';

    var dataStart = 0;
    var coreEvents;

    const select2Array = [{
            id: 'is_verif',
            url: '/#',
            placeholder: 'Pilih Armada Mudik',
            params: null
        },

    ];

    $(document).ready(function() {
        $('#my-table').attr('hidden', true);
        $('#cetaklaporan').attr('hidden', true);

        //HIDUPKAN KAMERA (HIDUP)
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                delay: 5000,
                mirror: true,
                qrbox: 700
            });

        //HIDUP
        function onScanSuccess(decodedText, decodedResult) {
            html5QrcodeScanner.clear();
            $('#my-table').attr('hidden', false);
            $('.content input#billing_code').val('');
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


                        for (let i = 0; i < data.data.length; i++) {
                            // var today = new Date();
                            var currentdate = new Date();

                            var dd = String(currentdate.getDate()).padStart(2, '0');
                            var mm = String(currentdate.getMonth() + 1).padStart(2, '0'); //January is 0!
                            var yyyy = currentdate.getFullYear();

                            currentdate = yyyy + '-' + mm + '-' + dd;
                            var expiredDate = data.data[i].billing_verif_expired_date;

                            if (expiredDate >= currentdate) {
                                if (data.data[i].is_verified == 1) {
                                    $button = '<div class="d-flex justify-content-center">\
                                            <div class="alert alert-success" role="alert">Verified by <br>' + data.data[i].user_web_name + ' at  <br>' + data.data[i].verified_at_tanggal + ' </div>\
                                            <a href="' + url_pdf_verif + '/p?o=p&search=' + btoa(data.data[i].billing_code) + '.' + btoa(data.data[i].id) + '" target="_blank">\
                                            <button class="btn btn-sm btn-outline-success" title="Print"><i class="fa fa-print"></i></button>\
                                            </a>\
                                            </div>';
                                } else if (data.data[i].is_verified == 2) {
                                    $button = '<div class="d-flex justify-content">\
                                            <div class="alert alert-danger" role="alert">Rejected by <br>' + data.data[i].user_web_name + ' at  <br>' + data.data[i].verified_at_tanggal + '</div>\
                                            </div>';


                                } else {
                                    $button = '<div class="d-flex justify-content-center">\
                                            <a href="#" onClick="verif(' + data.data[i].id + ')" id="' + data.data[i].id + '" class="btn btn-success">Verifikasi</a>\
                                            <a href="#" onClick="unverif(' + data.data[i].id + ')" id="' + data.data[i].id + '" class="btn btn-danger">Tolak</a>\
                                            </div>';
                                }
                            } else {
                                $button = '<div class="d-flex justify-content-center">\
                                            <div class="alert alert-warning" role="alert">Tanggal Verifikasi Telah Lewat</div>\
                                            </div>';
                            }

                           

                            var row = $('<tr>').attr('id', data.data[i].transaction_number).append(
                                // $('<td>').text(data.data[i].billing_code),
                                $('<td>').text(data.data[i].transaction_booking_name),
                                $('<td>').text(data.data[i].transaction_nik),
                                // $('<td style="width:150px"><input type="text" class="form-control" name="transactionBookingName" id="transactionBookingName" autocomplete="off" value="' + data.data[i].transaction_booking_name + '"></td>'),
                                // $('<td style="width:175px"><input type="text" class="form-control" name="transactionNik" id="transactionNik" autocomplete="off" value="' + data.data[i].transaction_nik + '"></td>'),
                                $('<td>').text(data.data[i].transaction_number),
                                $('<td>').text(data.data[i].reject_verified_reason),
                                // $('<td>').text(data.data[i].po_name),
                                // $('<td>').text(data.data[i].armada_name),
                                $('<td>').text(data.data[i].route_from),
                                $('<td>').text(data.data[i].route_to),
                                $('<td>').text(data.data[i].seat_map_detail_name),
                                // $('<td>').text(data.data[i].reject_verified_reason),
                                $('<td>').html($button)

                            );
                            // console.log(data.data[i].id);
                            $('#my-table tbody').append(row);
                            var billingCodeCol = document.getElementById('billing_code');
                            billingCodeCol.value = data.data[i].billing_code
                        }
                        // setTimeout(function() {
                        //     reloadAjax();
                        // }, 3000);

                    } else {
                        $('#scanned-result');
                        Swal.fire({
                            title: 'warning',
                            text: 'Data Tidak Ditemukan, gunakan unduhan tiket terbaru dari aplikasi',
                            icon: 'warning',
                            showConfirmButton: true,
                            // timer: 1500

                        }).then((result) => {
                            //window.location.reload(); // Reload the page
                            reloadScan();
                        });
                    }
                },
                error: function(data) {
                    // console.log(data);
                }
            });
        }

        //HIDUP

        function initScan() {
            html5QrcodeScanner.render(onScanSuccess);
        }
        initScan();

        function reloadScan() {
            $('#my-table tbody').html('');
            $('.content input#billing_code').val('');
            initScan();
        }

        $('#btn-scan').on('click', function(e) {
            reloadScan();
            // $('.content input#billing_code').val('');
        });

        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };
        coreEvents.tableColumn = datatableColumn()

        coreEvents.filter = [1];
        coreEvents.placeholder = "Nama, NIK, No. Transaksi";

        $('#date-start').each(function() {}).on('changeDate', function() {
            dateParamStart = $(this).val();
            // console.log(dateParamStart);
            coreEvents.filter = [$('#date-start').val()];
            // $('#cetaklaporan').attr('href', url_pdf_cetak + '/p?o=p&search=' + btoa(dateParam));
            if ($('#date-start').val() != '' && $('#date-end').val() != '') {
                $('#cetaklaporan').attr('hidden', false);
            } else {
                $('#cetaklaporan').attr('hidden', true);
            }
            $(this).datepicker('hide');
        });

        $('#date-end').each(function() {}).on('changeDate', function() {
            dateParamEnd = $(this).val();
            // console.log(dateParamEnd);
            coreEvents.filter = [$('#date-end').val()];
            $('#cetaklaporan').attr('href', url_pdf_cetak + '/p?o=p&search=' + btoa(dateParamStart) + '.' + btoa(dateParamEnd) + '.' + btoa($('#is_verif').val()));
            // $('#cetaklaporan').attr('href', url_pdf_cetak + '/p?o=p&search=' + dateParamStart + '.' + dateParamEnd + '.' + $('#is_verif').val());
            if ($('#date-end').val() != '' && $('#date-start').val() != '') {
                $('#cetaklaporan').attr('hidden', false);
            } else {
                $('#cetaklaporan').attr('hidden', true);
            }
            $(this).datepicker('hide');
        });

        coreEvents.datepicker('#date-start', 'yyyy-mm-dd')
        coreEvents.datepicker('#date-end', 'yyyy-mm-dd')

        $('#is_verif').on('change', function() {
            coreEvents.filter = [$('#is_verif').val()]
            if ($('#is_verif').val().length != 0) {
                coreEvents.load(coreEvents.filter, [0, 'asc'], coreEvents.placeholder);
            }
            $('#date-start').datepicker('setDate', null);
            $('#date-end').datepicker('setDate', null);
            $('#status_mudik').val('').trigger('change');

        });

        coreEvents.load(coreEvents.filter, [0, 'asc'], coreEvents.placeholder);

        $('#status_mudik').on('change', function() {
            coreEvents.filter = [$('#status_mudik').val()]
            if ($('#status_mudik').val().length != 0) {
                coreEvents.load(coreEvents.filter, [3, 'asc'], coreEvents.placeholder);
            }

        });

        coreEvents.load(coreEvents.filter, [0, 'asc'], coreEvents.placeholder);

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {}
        }

        coreEvents.deleteHandler = {
            placeholder: '',
            afterAction: function() {}
        }

        coreEvents.resetHandler = {
            action: function() {}
        }

    });

    function unverif(id) {
        var id = id;
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
                        'id': id,
                        'reject_verified_reason': result.value,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>' // just for security purpose
                    },
                    success: function(data) {
                        Swal.close();
                        if (data.success) {
                            for (let i = 0; i < data.data.length; i++) {
                                var row = $('tr#' + data.data[i].transaction_number);
                                row.remove(); // remove any existing alert
                                if (data.data[i].is_verified == 1) {
                                    $button = '<div class="d-flex justify-content-center">\
                                            <div class="alert alert-success" role="alert">Verified by <br>' + data.data[i].user_web_name + ' at  <br>' + data.data[i].verified_at_tanggal + ' </div>\
                                            <a href="' + url_pdf_verif + '/p?o=p&search=' + btoa(data.data[i].billing_code) + '.' + btoa(data.data[i].id) + '" target="_blank">\
                                            <button class="btn btn-sm btn-outline-success" title="Print"><i class="fa fa-print"></i></button>\
                                            </a>\
                                            </div>';
                                } else if (data.data[i].is_verified == 2) {
                                    $button = '<div class="d-flex justify-content">\
                                            <div class="alert alert-danger" role="alert">Rejected by <br>' + data.data[i].user_web_name + ' at  <br>' + data.data[i].verified_at_tanggal + '</div>\
                                            </div>';

                                } else {
                                    $button = '<div class="d-flex justify-content-center">\
                                            <a href="#" onClick="verif(' + data.data[i].id + ')" id="' + data.data[i].id + '" class="btn btn-success">Verifikasi</a>\
                                            <a href="#" onClick="unverif(' + data.data[i].id + ')" id="' + data.data[i].id + '" class="btn btn-danger">Tolak</a>\
                                            </div>';
                                }

                                var row = $('<tr>').attr('id', data.data[i].transaction_number).append(
                                    $('<td>').text(data.data[i].transaction_booking_name),
                                    $('<td>').text(data.data[i].transaction_nik),
                                    $('<td>').text(data.data[i].transaction_number),
                                    $('<td>').text(data.data[i].reject_verified_reason),
                                    $('<td>').text(data.data[i].route_from),
                                    $('<td>').text(data.data[i].route_to),
                                    $('<td>').text(data.data[i].seat_map_detail_name),
                                    $('<td>').html($button)
                                );
                                $('#my-table tbody').append(row);
                                var billingCodeCol = document.getElementById('billing_code');
                                billingCodeCol.value = data.data[i].billing_code
                            }
                            Swal.fire({
                                title: data.title,
                                text: data.message,
                                icon: data.status,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        } else {
                            Swal.fire({
                                title: data.title,
                                text: data.message,
                                icon: data.status,
                                showConfirmButton: false,
                                timer: 2000
                            }).then((result) => {
                                window.location.reload(); // Reload the page
                            });
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

    function verif(id) {
        var id = id;
        $.ajax({
            url: url + '_save',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                'transaction_booking_name': $('#transactionBookingName').val(),
                'transaction_nik': $('#transactionNik').val(),
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            },
            success: function(data) {
                // console.log(data.data.length);
                if (data.success == 1) {
                    for (let i = 0; i < data.data.length; i++) {
                        var row = $('tr#' + data.data[i].transaction_number);
                        row.remove(); // remove any existing alert
                        if (data.data[i].is_verified == 1) {
                            $button = '<div class="d-flex justify-content-center">\
                                            <div class="alert alert-success" role="alert">Verified by <br>' + data.data[i].user_web_name + ' at  <br>' + data.data[i].verified_at_tanggal + ' </div>\
                                            <a href="' + url_pdf_verif + '/p?o=p&search=' + btoa(data.data[i].billing_code) + '.' + btoa(data.data[i].id) + '" target="_blank">\
                                            <button class="btn btn-sm btn-outline-success" title="Print"><i class="fa fa-print"></i></button>\
                                            </a>\
                                            </div>';
                        } else if (data.data[i].is_verified == 2) {
                            $button = '<div class="d-flex justify-content">\
                                            <div class="alert alert-danger" role="alert">Rejected by <br>' + data.data[i].user_web_name + ' at  <br>' + data.data[i].verified_at_tanggal + '</div>\
                                            </div>';

                        } else {
                            $button = '<div class="d-flex justify-content-center">\
                                            <a href="#" onClick="verif(' + data.data[i].id + ')" id="' + data.data[i].id + '" class="btn btn-success">Verifikasi</a>\
                                            <a href="#" onClick="unverif(' + data.data[i].id + ')" id="' + data.data[i].id + '" class="btn btn-danger">Tolak</a>\
                                            </div>';
                        }

                        var row = $('<tr>').attr('id', data.data[i].transaction_number).append(
                            $('<td>').text(data.data[i].transaction_booking_name),
                            $('<td>').text(data.data[i].transaction_nik),
                            $('<td>').text(data.data[i].transaction_number),
                            $('<td>').text(data.data[i].reject_verified_reason),
                            $('<td>').text(data.data[i].route_from),
                            $('<td>').text(data.data[i].route_to),
                            $('<td>').text(data.data[i].seat_map_detail_name),
                            $('<td>').html($button)
                        );
                        $('#my-table tbody').append(row);
                        var billingCodeCol = document.getElementById('billing_code');
                        billingCodeCol.value = data.data[i].billing_code
                    }

                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: data.status,
                        icon: "success",
                        showCancelButton: false,
                        showCancelButton: false,
                        timer: 10000, // Set the timer to 5 seconds
                    });
                } else if (data.success == 2) {
                    Swal.fire({
                        title: 'warning',
                        text: data.message,
                        icon: 'warning',
                        showConfirmButton: true,
                        timer: 5000
                    });
                }
            }
        });
    }

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
        }).on('select2:selected', function(e) {
            var data = e.params.data;
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
                data: "transaction_booking_name",
                orderable: true
            },
            {
                data: "transaction_nik",
                orderable: false
            },
            {
                data: "transaction_number",
                orderable: false
            },
            {
                data: "billing_code",
                orderable: false
            },
            {
                data: "seat_map_detail_name",
                orderable: false
            },
            {
                data: "jadwal_type",
                orderable: false
            },
            {
                data: "is_verified",
                orderable: true
            },
            {
                data: "id",
                orderable: false,
                render: function(a, type, data, index) {
                    let button = ''
                    if (auth_edit == "1") {
                        if (data['is_verified'] == "Terverifikasi") {
                            button += ' <a href="' + url_pdf_verif + '/p?o=p&search=' + btoa(data['billing_code']) + '.' + btoa(data['id']) + '" target="_blank">\
                                    <button class="btn btn-sm btn-outline-success" title="Print"><i class="fa fa-print"></i></button>\
                                </a>';
                        } else if (data['is_verified'] == "Belum Verifikasi") {
                            // button += ' <a href="#" onclick="verif(' + data['id'] + ')" >\
                            // <button class="btn btn-raised btn-wave btn-icon btn-rounded mb-2 light-green text-white" title="Verifikasi">\
                            //                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>\
                            //             </button>\
                            //     </a>';
                            // button += ' <a href="#" onclick="unverif(' + data['id'] + ')" >\
                            // <button class="btn btn-raised btn-wave btn-icon btn-rounded mb-2 red text-white" title="Unverifikasi">\
                            //                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>\
                            //             </button>\
                            //     </a>';
                        } else if (data['is_verified'] == "Ditolak") {
                            button += ' <a href="#" >\
                                    <button class="btn btn-sm btn-outline-danger"  title=""><i class="fa fa-times"  aria-hidden="true"></i> </button>\
                                </a>';
                        }
                    }
                    button += (button == '') ? "<b>TIDAK ADA AKSI</b>" : ""
                    return button;
                }
            }
        ];
        return columns;
    }
</script>
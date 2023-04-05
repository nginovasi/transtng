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
                                                                <div style="text-align: center;"><button id="html5-qrcode-button-camera-permission" class="html5-qrcode-element">BATAS WAKTU VERIFIKASI TELAH BERAKHIR</button></div>
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
                                                <input type="hidden" class="form-control" id="id_jadwal" name="id_jadwal" autocomplete="off" placeholder="ID">
                                                <br />
                                                <label>KODE</label>
                                                <input type="text" class="form-control" id="motis_code" name="motis_code" autocomplete="off" placeholder="KODE MOTIS" disabled>
                                                <br />
                                                <label>NAMA</label>
                                                <input type="text" class="form-control" id="nama_pemilik_kendaraan" name="nama_pemilik_kendaraan" autocomplete="off" placeholder="NAMA PEMILIK KENDARAAN">
                                                <br />
                                                <label>NIK</label>
                                                <input type="text" class="form-control" id="nik_pendaftar_kendaraan" name="nik_pendaftar_kendaraan" autocomplete="off" placeholder="NIK" disabled>
                                                <br />
                                                <label>NO POLISI</label>
                                                <input type="text" class="form-control" id="no_kendaraan" name="no_kendaraan" autocomplete="off" placeholder="NO POLISI" disabled>
                                                <br />
                                                <label>JENIS KENDARAAN</label>
                                                <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" autocomplete="off" placeholder="JENIS KENDARAAN" disabled>
                                                <br />
                                                <label>NO STNK</label>
                                                <input type="text" class="form-control" id="no_stnk_kendaraan" name="no_stnk_kendaraan" autocomplete="off" placeholder="NO STNK" disabled>
                                                <br />
                                                <label>Rute Asal</label>
                                                <input type="text" class="form-control" id="route_from" name="route_from" autocomplete="off" placeholder="route_from" disabled>
                                                <br />
                                                <label>Rute Tujuan</label>
                                                <input type="text" class="form-control" id="route_to" name="route_to" autocomplete="off" placeholder="route_to" disabled>
                                                <br />
                                                <div class="form-group">
                                                    <label>Nama Armada</label>
                                                    <select class="form-control select2_motis_armada_id" id="motis_armada_id" name="motis_armada_id" required aria-required="true"></select>
                                                </div>
                                                <!-- </br>
                                                <td><img src="" id="foto_kendaraan" name="foto_kendaraan" /></td>
                                                </br>
                                                <td><img src="" id="foto_stnk" name="foto_stnk" /></td> -->
                                                <!-- <div class="form-group">
                                                    <label>Foto Kendaraan</label>
                                                    <div class="files" id="foto_kendaraan" style="width: 200px;">
                                                        <img src="" id="foto_kendaraan" name="foto_kendaraan" height="150px">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Foto STNK</label>
                                                    <div class="files" id="foto_stnk" style="width: 200px;">
                                                        <img src="" id="foto_stnk" name="foto_stnk" height="150px">
                                                    </div>
                                                </div> -->
                                                <!-- <div class="table-responsive">
                                                    <div class="row">
                                                        <div class="card-body">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="row"> -->
                                                <!-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Foto Kendaraan</label>
                                                        <td><img src="" id="foto_kendaraan" name="foto_kendaraan" height="250px" /></td>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Foto STNK</label>
                                                        <td><img src="" id="foto_stnk" name="foto_stnk" height="250px" /></td>
                                                    </div>
                                                </div> -->
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="card p-3">Foto Kendaraan
                                                            <td><img src="" id="foto_kendaraan" name="foto_kendaraan" height="250px" /></td>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card p-3">Foto STNK
                                                            <td><img src="" id="foto_stnk" name="foto_stnk" height="250px" /></td>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card p-3">Foto KTP
                                                            <td><img src="" id="foto_ktp" name="foto_ktp" height="250px" /></td>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <td><img src="" id="foto_ktp" name="foto_ktp" /></td>
                                                    </div>
                                                </div> -->
                                                <!-- </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="card-footer text-center">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="d-flex justify-content-center">
                                                                <a href="#" onClick="verif()" class="btn btn-success" id="btn-verif" hidden>Verifikasi</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="d-flex justify-content-center">
                                                                <a href="#" onClick="unverif()" class="btn btn-danger" id="btn-unverif" hidden>Tolak</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center" id="btn-printpdf" hidden></div>
                                                    <div class="d-flex justify-content-center">
                                                        <a href="#" class="btn btn-danger" id="btn-reload" hidden>Scan Ulang</a>
                                                    </div>
                                                </div>
                                    </form>
                            </div>
                            </section>
                            <button class="btn btn-primary" id="btn-scan">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw mx-2">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <polyline points="23 20 23 14 17 14"></polyline>
                                    <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                                </svg>
                                Scan Ulang
                            </button>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                        <div class="table-responsive">
                            <div class="row">
                                <div class="card-body">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="row mb-3">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="input-group">
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
                                            <div class="col-md-3">
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
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="padding">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-theme table-row v-middle">
                                                <thead>
                                                    <th><span>#</span></th>
                                                    <th><span>Kode Motis</span></th>
                                                    <th><span>NIK</span></th>
                                                    <th><span>NO Polisi</span></th>
                                                    <th><span>Jenis Kendaraan</span></th>
                                                    <th><span>No STNK</span></th>
                                                    <th><span>Armada</span></th>
                                                    <th><span>Status</span></th>
                                                    <th class="column-2action">Cetak</th>
                                                    <th><span></span></th>
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
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

        <script type="text/javascript">
            const auth_insert = '<?= $rules->i ?>';
            const auth_edit = '<?= $rules->e ?>';
            const auth_delete = '<?= $rules->d ?>';
            const auth_otorisasi = '<?= $rules->o ?>';
            const url_pdf_verif = '<?= base_url() . "/" . uri_segment(0) . "/action/pdf/verifikasikendaraanmudik" ?>';

            const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
            const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';
            const url_pdf_cetak = '<?= base_url() . "/" . uri_segment(0) . "/action/pdfcetak/verifikasikendaraanmudikcetak" ?>';

            var dataStart = 0;
            var coreEvents;

            const select2Array = [{
                id: 'motis_armada_id',
                url: '/armada_id_select_get',
                placeholder: 'Pilih Armada',
                params: null
            }];

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
                                        timer: 2000
                                    }).then((result) => {
                                        //window.location.reload(); // Reload the page
                                        reloadScan();
                                    });
                                } else {
                                    Swal.fire({
                                        title: data.title,
                                        text: data.message,
                                        icon: data.status,
                                        showConfirmButton: false,
                                        timer: 2000
                                    }).then((result) => {
                                        //window.location.reload(); // Reload the page
                                        reloadScan();
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


            $(document).ready(function() {
                //HIDUP
                var html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", {
                        fps: 10,
                        delay: 5000,
                        mirror: true,
                        qrbox: 700
                    });
                //MATI


                // $('#btn-verif').removeAttr("style", "display:none")
                // $('#btn-unverif').attr("style").hide();
                // $('#btn-printpdf').attr("style").hide();
                $('#cetaklaporan').attr('hidden', true);


                //HIDUP
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
                            'motis_code': qrid,
                            <?= csrf_token() ?>: '<?= csrf_hash() ?>' // just for security purpose
                        },
                        success: function(data) {
                            Swal.close();
                            if (data.success) {
                                var currentdate = new Date();

                                var dd = String(currentdate.getDate()).padStart(2, '0');
                                var mm = String(currentdate.getMonth() + 1).padStart(2, '0'); //January is 0!
                                var yyyy = currentdate.getFullYear();

                                currentdate = yyyy + '-' + mm + '-' + dd;
                                var expiredDate = data.data.motis_verif_expired_date;

                                // console.log(data.data);
                                $('#motis_code').val(data.data.motis_code);
                                $('#nama_pemilik_kendaraan').val(data.data.nama_pemilik_kendaraan);
                                $('#nik_pendaftar_kendaraan').val(data.data.nik_pendaftar_kendaraan);
                                $('#no_kendaraan').val(data.data.no_kendaraan);
                                $('#jenis_kendaraan').val(data.data.jenis_kendaraan);
                                $('#no_stnk_kendaraan').val(data.data.no_stnk_kendaraan);
                                $('#id').val(data.data.id);
                                $('id_jadwal').val(data.data.id_jadwal);
                                select2Init('#motis_armada_id', '/armada_id_select_get', 'Pilih Armada', {
                                    'id_jadwal': data.data.id_jadwal
                                });
                                $('#motis_status_verif').val(data.data.motis_status_verif);
                                $('#motis_armada_id').val(data.data.armada_code);
                                $('#route_from').val(data.data.route_from);
                                $('#route_to').val(data.data.route_to);
                                $('#foto_kendaraan').attr('src', '<?= base_url() ?>/' + data.data.foto_kendaraan);
                                $('#foto_ktp').attr('src', '<?= base_url() ?>/' + data.data.foto_ktp);
                                $('#foto_stnk').attr('src', '<?= base_url() ?>/' + data.data.foto_stnk);

                                // console.log(data.data);
                                // console.log(expiredDate);
                                // console.log(currentdate);
                                if (expiredDate >= currentdate) {

                                    if (data.data.motis_status_verif == 0) {
                                        $('#btn-verif').attr("hidden", false);
                                        $('#btn-unverif').attr("hidden", false);
                                    } else if (data.data.motis_status_verif == 1) {
                                        let button = ''

                                        button += ' <a class="btn btn-sm btn-outline-success" href="' + url_pdf_verif + '/p?o=p&search=' + btoa(data.data.motis_code) + '.' + btoa(data.data.id) + '" target="_blank" title="Print">\
                                    <i class="fa fa-print"></i> Cetak Tiket</a>'
                                        $('#btn-printpdf').attr("hidden", false);
                                        $('#btn-printpdf').html(button);
                                        $('#motis_armada_id').select2('trigger', 'select', {
                                            data: {
                                                id: data.data.armada_id,
                                                text: data.data.armada_code + " || " + data.data.armada_name
                                            }
                                        });
                                        $('#motis_armada_id').attr("disabled", true);
                                    } else {
                                        $('#btn-reload').attr("hidden", false);
                                    }
                                } else {
                                    $('#scanned-result');
                                    Swal.fire({
                                        title: 'warning',
                                        text: 'Batas Tanggal Verifikasi Telah Lewat',
                                        icon: 'warning',
                                        showConfirmButton: true,
                                    }).then((result) => {
                                        //window.location.reload(); // Reload the page
                                        reloadScan();
                                    });
                                }
                            } else {
                                // $('#scanned-result').html('<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
                                $('#scanned-result');
                                Swal.fire({
                                    title: 'warning',
                                    text: 'Data Tidak Ditemukan',
                                    icon: 'warning',
                                    showConfirmButton: true,
                                }).then((result) => {
                                    //window.location.reload(); // Reload the page
                                    reloadScan();
                                });
                            }
                        },
                        error: function(data) {

                        }
                    });
                }



                function initScan() {
                    html5QrcodeScanner.render(onScanSuccess);
                }
                initScan();

                function reloadScan() {
                    $('#motis_code').val('');
                    // $('.nik_pendaftar_kendaraan').val('');
                    $('#nama_pemilik_kendaraan').val('');
                    $('#nik_pendaftar_kendaraan').val('');
                    $('#no_kendaraan').val('');
                    $('#jenis_kendaraan').val('');
                    $('#no_stnk_kendaraan').val('');
                    $('#id').val('');
                    // $('#motis_status_verif').val('');
                    $('#motis_armada_id').val('');
                    $('#route_from').val('');
                    $('#route_to').val('');
                    $('#btn-verif').attr("hidden", true);
                    $('#btn-unverif').attr("hidden", true);
                    $('#btn-printpdf').attr("hidden", true);
                    $('#motis_armada_id').html('');
                    $('#foto_kendaraan').attr('src', '');
                    $('#foto_ktp').attr('src', '');
                    $('#foto_stnk').attr('src', '');

                    initScan();
                }

                $('#btn-scan').on('click', function(e) {
                    reloadScan();
                    // $('.content input#billing_code').val('');
                });

                //MATI

                coreEvents = new CoreEvents();
                coreEvents.url = url;
                coreEvents.ajax = url_ajax;
                coreEvents.csrf = {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                };
                coreEvents.tableColumn = datatableColumn()

                coreEvents.filter = [1];

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
                        coreEvents.load(coreEvents.filter);
                    }
                    $('#date-start').datepicker('setDate', null);
                    $('#date-end').datepicker('setDate', null);

                    // $(this).datepicker('hide');
                });

                coreEvents.load(coreEvents.filter);

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
                            // 
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
                                        //window.location.reload(); // Reload the page
                                        reloadScan();
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
                                    timer: 5000,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        //window.location.reload(); // Reload the page
                                        reloadScan();
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
                                //window.location.reload(); // Reload the page
                                reloadScan();
                            });
                        }
                    });
                })

                coreEvents.editHandler = {
                    placeholder: '',
                    afterAction: function(result) {

                        //window.location.reload();
                        reloadScan();
                    }
                }

                coreEvents.deleteHandler = {
                    placeholder: '',
                    afterAction: function() {

                    }
                }

                coreEvents.resetHandler = {
                    action: function() {

                    }
                }

                coreEvents.load(coreEvents.filter);

                select2Array.forEach(function(x) {
                    select2Init('#' + x.id, x.url, x.placeholder, x.params);
                });
            });

            function verif(id) {
                var id = id;
                $.ajax({
                    url: url + '_save',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        'motis_code': $('#motis_code').val(),
                        'id': $('#id').val(),
                        'motis_armada_id': $('#motis_armada_id').val(),
                        'motis_status_verif': $('#motis_status_verif').val(),
                        'nama_pemilik_kendaraan': $('#nama_pemilik_kendaraan').val(),
                        // 'reject_verified_reason': result.value,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>' // just for security purpose
                    },
                    success: function(data) {
                        // console.log(data.data);
                        if (data.success == 1 && data.success == true) {
                            $('#motis_code').val(data.data[0].motis_code);
                            $('#nama_pemilik_kendaraan').val(data.data[0].nama_pemilik_kendaraan);
                            $('#nik_pendaftar_kendaraan').val(data.data[0].nik_pendaftar_kendaraan);
                            $('#no_kendaraan').val(data.data[0].no_kendaraan);
                            $('#jenis_kendaraan').val(data.data[0].jenis_kendaraan);
                            $('#no_stnk_kendaraan').val(data.data[0].no_stnk_kendaraan);
                            $('#id').val(data.data[0].id);
                            $('#motis_status_verif').val(data.data[0].motis_status_verif);
                            $('#motis_armada_id').val(data.data[0].armada_code);
                            $('#motis_date_verif').val(data.data[0].motis_date_verif);
                            $('#foto_kendaraan').attr('src', '<?= base_url() ?>/' + data.data.foto_kendaraan);
                            $('#foto_ktp').attr('src', '<?= base_url() ?>/' + data.data.foto_ktp);
                            $('#foto_stnk').attr('src', '<?= base_url() ?>/' + data.data.foto_stnk);
                            // console.log(data.data[0].motis_status_verif);
                            if (data.data[0].motis_status_verif == 1) {
                                let button = ''
                                button += '<div class="alert alert-success" role="alert">Verified at <br>' + data.data[0].motis_date_verif + ' </div>\
                                <div> <a class="btn btn-xm btn-outline-success" href="' + url_pdf_verif + '/p?o=p&search=' + btoa(data.data[0].motis_code) + '.' + btoa(data.data[0].id) + '" target="_blank" title="Print">\
                                    <i class="fa fa-print"></i> Cetak Tiket</a></div>'
                                $('#btn-printpdf').attr("hidden", false);
                                $('#btn-printpdf').html(button);
                                $('#motis_armada_id').attr("disabled", true);

                                $('#btn-verif').attr("hidden", true);
                                $('#btn-unverif').attr("hidden", true);
                            } else if (data.data[0].motis_status_verif == 2) {
                                $button = '<div class="d-flex justify-content">\
                                            <div class="alert alert-danger" role="alert">Rejected by</div>\
                                            </div>';
                            } else {
                                $('#btn-reload').attr("hidden", false);
                                $button = '<div class="d-flex justify-content">\
                                            <div class="alert alert-danger" role="alert">Rejected by</div>\
                                            </div>';
                            }
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
                                    // window.location.reload(); // Reload the page
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
                                timer: 5000,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // window.location.reload(); // Reload the page
                                }
                            });
                        } else {
                            Swal.fire({
                                title: data.title,
                                text: data.message,
                                icon: data.status,
                                showConfirmButton: true,
                                confirmButtonText: "Oke",
                                timer: 5000,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // window.location.reload(); // Reload the page
                                    // console.log("outer");
                                }
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
                        data: "motis_code",
                        orderable: true
                    },
                    {
                        data: "nik_pendaftar_kendaraan",
                        orderable: true
                    },
                    {
                        data: "no_kendaraan",
                        orderable: true
                    },
                    {
                        data: "jenis_kendaraan",
                        orderable: true
                    },
                    {
                        data: "no_stnk_kendaraan",
                        orderable: true
                    },
                    {
                        data: "armada_name",
                        orderable: true
                    },
                    {
                        data: "motis_status_verif",
                        orderable: true
                    },
                    {
                        data: "id",
                        orderable: false,
                        render: function(a, type, data, index) {
                            let button = ''
                            // console.log(data['id']);
                            if (auth_edit == "1") {
                                if (data['motis_status_verif'] == "Terverifikasi") {
                                    button += ' <a href="' + url_pdf_verif + '/p?o=p&search=' + btoa(data['motis_code']) + '.' + btoa(data['id']) + '" target="_blank">\
                                    <button class="btn btn-sm btn-outline-success" title="Print"><i class="fa fa-print"></i></button>\
                                </a>';
                                    //     } else if (data['motis_status_verif'] == "Belum Verifikasi") {
                                    //         button += ' <a href="#" onclick="verif(' + data['id'] + ')" >\
                                    // <button class="btn btn-raised btn-wave btn-icon btn-rounded mb-2 light-green text-white" title="Verifikasi">\
                                    //                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>\
                                    //             </button>\
                                    //     </a>';
                                }

                                button += (button == '') ? "" : ""

                                return button;
                            }
                        }
                    }


                    // {
                    //     data: "id",
                    //     orderable: false,
                    //     render: function(a, type, data, index) {
                    //         let button = ''

                    //         if (auth_edit == "1") {
                    //             button += '<button class="btn btn-sm btn-outline-success" data-id="' + data.id + '" title="Print" target="_blank">\
                    //         <i class="fa fa-print"></i> \
                    //         </button>\
                    //         ';
                    //         }

                    //         button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

                    //         return button;
                    //     }
                    // }
                ];

                return columns;
            }
        </script>
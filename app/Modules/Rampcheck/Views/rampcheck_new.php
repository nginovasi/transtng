<style>
#sig-canvas,
#sig-canvas-penguji,
#sig-canvas-penyidik {
    border: 2px dotted #CCCCCC;
    border-radius: 15px;
    cursor: crosshair;
    /* disable scroll when touch */
    touch-action: none;
}

.select2-container {
    width: 100% !important;
}

/* set nav-item responsive on mobile view */
@media (max-width: 767px) {
    .nav-item {
        width: 50%;
    }
}
</style>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

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
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-form" role="tab"
                            aria-controls="tab-form" aria-selected="false">Form</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-data" role="tab" aria-controls="tab-data"
                            aria-selected="false">Data</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                            <form id="form" data-plugin="parsley" data-option="{}">
                                <div id="rootwizard" data-plugin="bootstrapWizard" data-option="{
																										tabClass: '',
																										nextSelector: '.button-next',
																										previousSelector: '.button-previous',
																										firstSelector: '.button-first',
																										lastSelector: '.button-last',
																										onTabClick: function(tab, navigation, index) {
																										return false;
																										},
																										onNext: function(tab, navigation, index) {
																										var instance = $('#form').parsley();
																										instance.validate();
																										if(!instance.isValid()) {
																												return false;
																										}
																										}
																								}">
                                    <input type="hidden" class="form-control" id="id" name="id" value="">
                                    <?=csrf_field();?>
                                    <ul class="nav mb-3">
                                        <li class="nav-item">
                                            <a class="nav-link text-center" href="#tab1" data-toggle="tab">
                                                <span
                                                    class="w-32 d-inline-flex align-items-center justify-content-center circle bg-light active-bg-primary">1</span>
                                                <div class="mt-2">
                                                    <div class="text-muted">Data</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-center" href="#tab2" data-toggle="tab">
                                                <span
                                                    class="w-32 d-inline-flex align-items-center justify-content-center circle bg-light active-bg-primary">2</span>
                                                <div class="mt-2">
                                                    <div class="text-muted">Unsur Administrasi</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-center" href="#tab3" data-toggle="tab">
                                                <span
                                                    class="w-32 d-inline-flex align-items-center justify-content-center circle bg-light active-bg-primary">3</span>
                                                <div class="mt-2">
                                                    <div class="text-muted">Unsur Teknis Utama</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-center" href="#tab4" data-toggle="tab">
                                                <span
                                                    class="w-32 d-inline-flex align-items-center justify-content-center circle bg-light active-bg-primary">4</span>
                                                <div class="mt-2">
                                                    <div class="text-muted">Unsur Teknis Penunjang</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-center" href="#tab5" data-toggle="tab">
                                                <span
                                                    class="w-32 d-inline-flex align-items-center justify-content-center circle bg-light active-bg-primary">5</span>
                                                <div class="mt-2">
                                                    <div class="text-muted">Kesimpulan</div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-3">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="form-group">
                                                <label>Hari / Tanggal</label>
                                                <input type="date" class="form-control" name="rampcheck_date"
                                                    id="rampcheck_date" required="true">
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <label>Lokasi</label>
                                                    <select id="rampcheck_jenis_lokasi_id"
                                                        name="rampcheck_jenis_lokasi_id"
                                                        class="form-control select2JenisLokasi" style="width: 100%;"
                                                        required="true">
                                                    </select>
                                                </div>
                                                <div class="col-sm-6" style="display:none"
                                                    id="rampcheck_nama_lokasi_select">
                                                    <label>Nama Lokasi</label>
                                                    <select class="form-control select2NamaLokasi"
                                                        id="rampcheck_nama_lokasi" name="rampcheck_nama_lokasi_sel">
                                                    </select>
                                                </div>
                                                <div class="col-sm-6" style="display:none"
                                                    id="rampcheck_nama_lokasi_text">
                                                    <label>Nama Lokasi</label>
                                                    <input type="text" class="form-control" name="rampcheck_nama_lokasi_text"
                                                        id="rampcheck_nama_lokasi">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <label>Nama Pengemudi</label>
                                                    <input type="text" class="form-control" placeholder="Nama Pengemudi"
                                                        name="rampcheck_pengemudi" id="rampcheck_pengemudi"
                                                        required="true">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Umur</label>
                                                    <input type="number" class="form-control"
                                                        placeholder="Umur Pengemudi" name="rampcheck_umur_pengemudi"
                                                        id="rampcheck_umur_pengemudi" required="true">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label>Nomor Kendaraan <b
                                                            style="font-size: 8px; color: blue">(blue)</b></label>
                                                    <input type="text" class="form-control" name="rampcheck_noken"
                                                        id="rampcheck_noken" placeholder="X XXXX XXX" required="true">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>Nama PO <b
                                                            style="font-size: 8px; color: red">(spionam)</b></label>
                                                    <input type="text" class="form-control" name="rampcheck_po_name"
                                                        id="rampcheck_po_name" placeholder="Nama PO" required="true">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>Nomor STUK <b
                                                            style="font-size: 8px; color: blue">(blue)</b></label>
                                                    <input type="text" class="form-control" name="rampcheck_stuk"
                                                        id="rampcheck_stuk" placeholder="Nomor STUK">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label>Jenis Angkutan <b
                                                            style="font-size: 8px; color: red">(spionam)</b></label>
                                                    <select class="form-control select2JenisAngkutan"
                                                        id="rampcheck_jenis_angkutan_id"
                                                        name="rampcheck_jenis_angkutan_id" required="true">
                                                    </select>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label>Trayek <b
                                                            style="font-size: 8px; color: red">(spionam)</b></label>
                                                    <input type="text" class="form-control" name="rampcheck_trayek"
                                                        id="rampcheck_trayek" placeholder="Trayek" required="true">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Nomor Sticker</label>
                                                    <input type="text" class="form-control" placeholder="Nomor Sticker"
                                                        name="rampcheck_sticker_no" id="rampcheck_sticker_no"
                                                        required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab2">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kartu Uji / STUK <b
                                                        style="font-size: 8px; color: blue">(blue)</b></label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_adm_ku">
                                                        <div class="form-check form-check-inline w-25">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_ku"
                                                                    id="rampcheck_adm_ku0" value="0"><i
                                                                    class="messageCheckbox green"></i>
                                                                Ada, Berlaku
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline w-25">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_ku"
                                                                    id="rampcheck_adm_ku1" value="1"><i
                                                                    class="messageCheckbox red"></i>
                                                                Tidak Berlaku
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline w-25">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_ku"
                                                                    id="rampcheck_adm_ku2" value="2"><i
                                                                    class="messageCheckbox red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline w-25">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_ku"
                                                                    id="rampcheck_adm_ku3" value="3"><i
                                                                    class="messageCheckbox red"></i>
                                                                Tidak Sesuai Fisik
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">KP. Reguler <b
                                                        style="font-size: 8px; color: red">(spionam)</b></label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_adm_kpr">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_kpr"
                                                                    id="rampcheck_adm_kpr0" value="0"><i
                                                                    class="green"></i>
                                                                Ada, Berlaku
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_kpr"
                                                                    id="rampcheck_adm_kpr1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Berlaku
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_kpr"
                                                                    id="rampcheck_adm_kpr2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_kpr"
                                                                    id="rampcheck_adm_kpr3" value="3"><i
                                                                    class="red"></i>
                                                                Tidak Sesuai Fisik
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">KP. Cadangan (untuk kendaraan
                                                    cadangan) <b
                                                        style="font-size: 8px; color: red">(spionam)</b></label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_adm_kpc">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_kpc"
                                                                    id="rampcheck_adm_kpc0" value="0"><i
                                                                    class="green"></i>
                                                                Ada, Berlaku
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_kpc"
                                                                    id="rampcheck_adm_kpc1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Berlaku
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_kpc"
                                                                    id="rampcheck_adm_kpc2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_kpc"
                                                                    id="rampcheck_adm_kpc3" value="3"><i
                                                                    class="red"></i>
                                                                Tidak Sesuai Fisik
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">SIM Pengemudi</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_adm_sim">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_sim"
                                                                    id="rampcheck_adm_sim0" value="0"><i
                                                                    class="green"></i>
                                                                A Umum
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_sim"
                                                                    id="rampcheck_adm_sim1" value="1"><i
                                                                    class="green"></i>
                                                                B1 Umum
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_sim"
                                                                    id="rampcheck_adm_sim2" value="2"><i
                                                                    class="green"></i>
                                                                B2 Umum
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_adm_sim"
                                                                    id="rampcheck_adm_sim3" value="3"><i
                                                                    class="red"></i>
                                                                SIM Tidak Sesuai
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab3">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <h6>A. SISTEM PENERANGAN</h6>
                                                </label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Lampu Utama Kendaraan -
                                                    Dekat</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_lukd">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lukd"
                                                                    id="rampcheck_utu_lukd0" value="0"><i
                                                                    class="green"></i>
                                                                Semua Menyala
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lukd"
                                                                    id="rampcheck_utu_lukd1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Menyala: Kanan
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lukd"
                                                                    id="rampcheck_utu_lukd2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Menyala: Kiri
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Lampu Utama Kendaraan -
                                                    Jauh</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_lukj">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lukj"
                                                                    id="rampcheck_utu_lukj0" value="0"><i
                                                                    class="green"></i>
                                                                Semua Menyala
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lukj"
                                                                    id="rampcheck_utu_lukj1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Menyala: Kanan
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lukj"
                                                                    id="rampcheck_utu_lukj2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Menyala: Kiri
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Lampu Penunjuk Arah -
                                                    Dekat</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_lpad">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lpad"
                                                                    id="rampcheck_utu_lpad0" value="0"><i
                                                                    class="green"></i>
                                                                Semua Menyala
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lpad"
                                                                    id="rampcheck_utu_lpad1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Menyala: Kanan
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lpad"
                                                                    id="rampcheck_utu_lpad2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Menyala: Kiri
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Lampu Penunjuk Arah -
                                                    Jauh</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_lpaj">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lpaj"
                                                                    id="rampcheck_utu_lpaj0" value="0"><i
                                                                    class="green"></i>
                                                                Semua Menyala
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lpaj"
                                                                    id="rampcheck_utu_lpaj1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Menyala: Kanan
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lpaj"
                                                                    id="rampcheck_utu_lpaj2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Menyala: Kiri
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Lampu Rem</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_lr">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lr"
                                                                    id="rampcheck_utu_lr0" value="0"><i
                                                                    class="green"></i>
                                                                Semua Menyala
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lr"
                                                                    id="rampcheck_utu_lr1" value="1"><i class="red"></i>
                                                                Tidak Menyala: Kanan
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lr"
                                                                    id="rampcheck_utu_lr2" value="2"><i class="red"></i>
                                                                Tidak Menyala: Kiri
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Lampu Mundur</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_lm">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lm"
                                                                    id="rampcheck_utu_lm0" value="0"><i
                                                                    class="green"></i>
                                                                Semua Menyala
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lm"
                                                                    id="rampcheck_utu_lm1" value="1"><i class="red"></i>
                                                                Tidak Menyala: Kanan
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_lm"
                                                                    id="rampcheck_utu_lm2" value="2"><i class="red"></i>
                                                                Tidak Menyala: Kiri
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <!-- Beginning of Sistem Pengereman -->
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <h6>B. SISTEM PENGEREMAN</h6>
                                                </label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kondisi Rem Utama</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_kru">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_kru"
                                                                    id="rampcheck_utu_kru0" value="0"><i
                                                                    class="green"></i>
                                                                Berfungsi
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_kru"
                                                                    id="rampcheck_utu_kru1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Berfungsi
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kondisi Rem Parkir</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_krp">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_krp"
                                                                    id="rampcheck_utu_krp0" value="0"><i
                                                                    class="green"></i>
                                                                Berfungsi
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_krp"
                                                                    id="rampcheck_utu_krp1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Berfungsi
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Sistem Pengereman -->
                                            <!-- Beginning of Ban -->
                                            <br>
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <h6>C. BAN</h6>
                                                </label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kondisi Ban Depan</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_kbd">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_kbd"
                                                                    id="rampcheck_utu_kbd0" value="0"><i
                                                                    class="green"></i>
                                                                Semua Laik
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_kbd"
                                                                    id="rampcheck_utu_kbd1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Laik: Kanan
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_kbd"
                                                                    id="rampcheck_utu_kbd2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Laik: Kiri
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kondisi Ban Belakang</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_kbb">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_kbb"
                                                                    id="rampcheck_utu_kbb0" value="0"><i
                                                                    class="green"></i>
                                                                Semua Laik
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_kbb"
                                                                    id="rampcheck_utu_kbb1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Laik: Kanan
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_kbb"
                                                                    id="rampcheck_utu_kbb2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Laik: Kiri
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Ban -->
                                            <!-- Beginning of Perlengkapan -->
                                            <br>
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <h6>D. PERLENGKAPAN</h6>
                                                </label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Sabuk Keselamatan
                                                    Pengemudi</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_skp">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_skp"
                                                                    id="rampcheck_utu_skp0" value="0"><i
                                                                    class="green"></i>
                                                                Ada dan Fungsi
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_skp"
                                                                    id="rampcheck_utu_skp1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Fungsi
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_skp"
                                                                    id="rampcheck_utu_skp2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Perlengkapan -->
                                            <!-- Beginning of Pengukur Kecepatan -->
                                            <br>
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <h6>E. PENGUKUR KECEPATAN</h6>
                                                </label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Pengukur Kecepatan</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_pk">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_pk"
                                                                    id="rampcheck_utu_pk0" value="0"><i
                                                                    class="green"></i>
                                                                Ada dan Berfungsi
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_pk"
                                                                    id="rampcheck_utu_pk1" value="1"><i class="red"></i>
                                                                Tidak Berfungsi
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_pk"
                                                                    id="rampcheck_utu_pk2" value="2"><i class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Pengukur Kecepatan -->
                                            <!-- Beginning of Penghapus Kaca -->
                                            <br>
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <h6>F. PENGHAPUS KACA (WIPER)</h6>
                                                </label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Penghapus Kaca</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_pkw">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_pkw"
                                                                    id="rampcheck_utu_pkw0" value="0"><i
                                                                    class="green"></i>
                                                                Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_pkw"
                                                                    id="rampcheck_utu_pkw1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Berfungsi
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_pkw"
                                                                    id="rampcheck_utu_pkw2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Penghapus Kaca -->
                                            <!-- Beginning of Tanggap Darurat -->
                                            <br>
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <h6>G. TANGGAP DARURAT</h6>
                                                </label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Pintu Darurat</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_pd">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_pd"
                                                                    id="rampcheck_utu_pd0" value="0"><i
                                                                    class="green"></i>
                                                                Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_pd"
                                                                    id="rampcheck_utu_pd1" value="1"><i class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Jendela Darurat</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_jd">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_jd"
                                                                    id="rampcheck_utu_jd0" value="0"><i
                                                                    class="green"></i>
                                                                Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_jd"
                                                                    id="rampcheck_utu_jd1" value="1"><i class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Alat Pemukul/Pemecah Kaca</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_apk">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_apk"
                                                                    id="rampcheck_utu_apk0" value="0"><i
                                                                    class="green"></i>
                                                                Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_apk"
                                                                    id="rampcheck_utu_apk1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">APAR (Alat Pemadam Api
                                                    Ringan)</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utu_apar">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_apar"
                                                                    id="rampcheck_utu_apar0" value="0"><i
                                                                    class="green"></i>
                                                                Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_apar"
                                                                    id="rampcheck_utu_apar1" value="1"><i
                                                                    class="red"></i>
                                                                Kadaluarsa
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utu_apar"
                                                                    id="rampcheck_utu_apar2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Tanggap Darurat -->
                                        </div>
                                        <div class="tab-pane" id="tab4">
                                            <!-- Beginning of Sistem Penerangan -->
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <h6>A. SISTEM PENERANGAN</h6>
                                                </label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Lampu Posisi Depan</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_sp_dpn">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_sp_dpn"
                                                                    id="rampcheck_utp_sp_dpn0" value="0"><i
                                                                    class="green"></i>
                                                                Semua Menyala
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_sp_dpn"
                                                                    id="rampcheck_utp_sp_dpn1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Menyala: Kanan
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_sp_dpn"
                                                                    id="rampcheck_utp_sp_dpn2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Menyala: Kiri
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Lampu Posisi Belakang</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_sp_blk">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_sp_blk"
                                                                    id="rampcheck_utp_sp_blk0" value="0"><i
                                                                    class="green"></i>
                                                                Semua Menyala
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_sp_blk"
                                                                    id="rampcheck_utp_sp_blk1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Menyala: Kanan
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_sp_blk"
                                                                    id="rampcheck_utp_sp_blk2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Menyala: Kiri
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Sistem Penerangan -->
                                            <!-- Beginning of Badan Kendaraan -->
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <h6>B. BADAN KENDARAAN</h6>
                                                </label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kondisi Kaca Depan</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_bk_kcd">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_bk_kcd"
                                                                    id="rampcheck_utp_bk_kcd0" value="0"><i
                                                                    class="green"></i>
                                                                Baik
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_bk_kcd"
                                                                    id="rampcheck_utp_bk_kcd1" value="1"><i
                                                                    class="red"></i>
                                                                Kurang Baik
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Pintu Utama</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_bk_pu">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_bk_pu"
                                                                    id="rampcheck_utp_bk_pu0" value="0"><i
                                                                    class="green"></i>
                                                                Baik
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_bk_pu"
                                                                    id="rampcheck_utp_bk_pu1" value="1"><i
                                                                    class="red"></i>
                                                                Kurang Baik
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kondisi Rem Utama</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_bk_kru">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_bk_kru"
                                                                    id="rampcheck_utp_bk_kru0" value="0"><i
                                                                    class="green"></i>
                                                                Sesuai
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_bk_kru"
                                                                    id="rampcheck_utp_bk_kru1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Sesuai
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kondisi Rem Parkir</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_bk_krp">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_bk_krp"
                                                                    id="rampcheck_utp_bk_krp0" value="0"><i
                                                                    class="green"></i>
                                                                Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_bk_krp"
                                                                    id="rampcheck_utp_bk_krp1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Berfungsi
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_bk_krp"
                                                                    id="rampcheck_utp_bk_krp2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kondisi Lantai dan Tangga</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_bk_ldt">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_bk_ldt"
                                                                    id="rampcheck_utp_bk_ldt0" value="0"><i
                                                                    class="green"></i>
                                                                Baik
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_bk_ldt"
                                                                    id="rampcheck_utp_bk_ldt1" value="1"><i
                                                                    class="red"></i>
                                                                Keropos/Berlubang
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Badan Kendaraan -->
                                            <!-- Beginning of Kapasitas Tempat Duduk -->
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <h6>C. KAPASITAS TEMPAT DUDUK</h6>
                                                </label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Jumlah Tempat Duduk
                                                    Penumpang</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_ktd_jtd">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_ktd_jtd"
                                                                    id="rampcheck_utp_ktd_jtd0" value="0"><i
                                                                    class="green"></i>
                                                                Sesuai
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_ktd_jtd"
                                                                    id="rampcheck_utp_ktd_jtd1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Sesuai
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Kapasitas Tempat Duduk -->
                                            <!-- Beginning of Perlengkapan Kendaraan -->
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <h6>D. PERLENGKAPAN KENDARAAN</h6>
                                                </label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Ban Cadangan</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_pk_bc">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_bc"
                                                                    id="rampcheck_utp_pk_bc0" value="0"><i
                                                                    class="green"></i>
                                                                Ada dan Laik
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_bc"
                                                                    id="rampcheck_utp_pk_bc1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Laik
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_bc"
                                                                    id="rampcheck_utp_pk_bc2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Segitiga Pengaman</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_pk_sp">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_sp"
                                                                    id="rampcheck_utp_pk_sp0" value="0"><i
                                                                    class="green"></i>
                                                                Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_sp"
                                                                    id="rampcheck_utp_pk_sp1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Dongkrak</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_pk_dkr">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_dkr"
                                                                    id="rampcheck_utp_pk_dkr0" value="0"><i
                                                                    class="green"></i>
                                                                Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_dkr"
                                                                    id="rampcheck_utp_pk_dkr1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Pembuka Roda</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_pk_pbr">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_pbr"
                                                                    id="rampcheck_utp_pk_pbr0" value="0"><i
                                                                    class="green"></i>
                                                                Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_pbr"
                                                                    id="rampcheck_utp_pk_pbr1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Lampu Senter</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_pk_ls">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_ls"
                                                                    id="rampcheck_utp_pk_ls0" value="0"><i
                                                                    class="green"></i>
                                                                Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_ls"
                                                                    id="rampcheck_utp_pk_ls1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Berfungsi
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_ls"
                                                                    id="rampcheck_utp_pk_ls2" value="2"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Pengganjal Roda</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_pk_pgr">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_pgr"
                                                                    id="rampcheck_utp_pk_pgr0" value="0"><i
                                                                    class="green"></i>
                                                                Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_pgr"
                                                                    id="rampcheck_utp_pk_pgr1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Sabuk Keselamatan
                                                    Penumpang</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_pk_skp">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_skp"
                                                                    id="rampcheck_utp_pk_skp0" value="0"><i
                                                                    class="green"></i>
                                                                Ada dan Laik
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_skp"
                                                                    id="rampcheck_utp_pk_skp1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kotak PT3K</label>
                                                <div class="col-sm-9">
                                                    <div class="mt-2" id="rampcheck_utp_pk_ptk">
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_ptk"
                                                                    id="rampcheck_utp_pk_ptk0" value="0"><i
                                                                    class="green"></i>
                                                                Ada
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="md-check">
                                                                <input type="radio" name="rampcheck_utp_pk_ptk"
                                                                    id="rampcheck_utp_pk_ptk1" value="1"><i
                                                                    class="red"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Perlengkapan Kendaraan -->
                                        </div>
                                        <div class="tab-pane" id="tab5">
                                            <div class="form-group">
                                                <h4>
                                                    <strong>BEDASARKAN HASIL DIATAS, MAKA KENDARAAN TERSEBUT DINYATAKAN
                                                        :</strong>
                                                </h4>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label"
                                                        style="color:green;"><strong>Laik Jalan</strong></label>
                                                    <div class="col-sm-9">
                                                        <div class="mt-2" id="rampcheck_kesimpulan_status">
                                                            <div class="form-check form-check-inline">
                                                                <label class="md-check">
                                                                    <input type="radio"
                                                                        name="rampcheck_kesimpulan_status"
                                                                        id="rampcheck_kesimpulan_status0" value="0"><i
                                                                        class="green"></i>
                                                                    DIIJINKAN OPERASIONAL
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="md-check">
                                                                    <input type="radio"
                                                                        name="rampcheck_kesimpulan_status"
                                                                        id="rampcheck_kesimpulan_status1" value="1"><i
                                                                        class="green"></i>
                                                                    PERINGATAN/PERBAIKI
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label"
                                                        style="color:red;"><strong>Tidak Laik Jalan</strong></label>
                                                    <div class="col-sm-9">
                                                        <div class="mt-2" id="rampcheck_kesimpulan_status">
                                                            <div class="form-check form-check-inline">
                                                                <label class="md-check">
                                                                    <input type="radio"
                                                                        name="rampcheck_kesimpulan_status"
                                                                        id="rampcheck_kesimpulan_status2" value="2"><i
                                                                        class="red"></i>
                                                                    TILANG DAN DILARANG OPERASIONAL
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="md-check">
                                                                    <input type="radio"
                                                                        name="rampcheck_kesimpulan_status"
                                                                        id="rampcheck_kesimpulan_status3" value="3"><i
                                                                        class="red"></i>
                                                                    DILARANG OPERASIONAL
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <br>
                                                    <div class="input-group mb-5">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Catatan</span>
                                                        </div>
                                                        <textarea class="form-control" aria-label="Catatan"
                                                            style="max-width:1024px;height:150px;"
                                                            name="rampcheck_kesimpulan_catatan"></textarea>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                  <div id="my-dropzone" class="dropzone"></div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-4">
                                                        <!-- //test signature -->
                                                        <!-- Content -->
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <p><b>Pengemudi</b></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <canvas id="sig-canvas"
                                                                    name="rampcheck_kesimpulan_ttd_pengemudi"></canvas>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="btn btn-info btn-sm" id="sig-submitBtn">
                                                                    Simpan Tanda Tangan</div>
                                                                <div class="btn btn-default btn-sm" id="sig-clearBtn">
                                                                    Clear</div>
                                                                    <!-- icon checked if signature is saved -->
                                                                    <i class="fa fa-check" id="sig-check" style="display:none;"> Tanda Tangan Pengemudi Tersimpan</i>
                                                            </div>
                                                        </div>
                                                        <div hidden>
                                                            <div class="col-md-12">
                                                                <textarea id="sig-dataUrl" class="form-control"
                                                                    rows="5">Data URL for your signature will go here!</textarea>
                                                            </div>
                                                        </div>
                                                        <!-- //test signature -->
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <!-- //test signature -->
                                                        <!-- Content -->
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <p><b>Penguji Kendaraan Bermotor</b></p>
                                                            </div>
                                                        </div>
                                                        <d-pengujiiv class="row">
                                                            <d-pengujiiv class="col-lg-12">
                                                                <canvas id="sig-canvas-penguji"
                                                                    name="rampcheck_kesimpu-pengujilan_ttd_penguji"></canvas>
                                                            </d-pengujiiv>
                                                        </d-pengujiiv>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="btn btn-info btn-sm"
                                                                    id="sig-submitBtn-penguji">
                                                                    Simpan Tanda Tangan</div>
                                                                <div class="btn btn-default btn-sm"
                                                                    id="sig-clearBtn-penguji">
                                                                    Clear</div>
                                                                    <!-- icon checked if signature is saved -->
                                                                    <i class="fa fa-check" id="sig-check-penguji" style="display:none;"> Tanda Tangan Penguji Tersimpan</i>
                                                            </div>
                                                        </div>
                                                        <div hidden>
                                                            <div class="col-md-12">
                                                                <textarea id="sig-dataUrl-penguji" class="form-control"
                                                                    rows="5">Data URL for your signature will go here!</textarea>
                                                            </div>
                                                        </div>
                                                        <!-- //test signature -->
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <!-- //test signature -->
                                                        <!-- Content -->
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <p><b>Penyidik Pegawai Negeri Sipil</b></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <canvas id="sig-canvas-penyidik"
                                                                    name="rampcheck_kesimpulan_nama_penyidik"></canvas>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="btn btn-info btn-sm"
                                                                    id="sig-submitBtn-penyidik">
                                                                    Simpan Tanda Tangan</div>
                                                                <div class="btn btn-default btn-sm"
                                                                    id="sig-clearBtn-penyidik">
                                                                    Clear</div>
                                                                    <!-- icon checked if signature is saved -->
                                                                    <i class="fa fa-check" id="sig-check-penyidik" style="display:none;"> Tanda Tangan Penyidik Tersimpan</i>
                                                            </div>
                                                        </div>
                                                        <div hidden>
                                                            <div class="col-md-12">
                                                                <textarea id="sig-dataUrl-penyidik" class="form-control"
                                                                    rows="5">Data URL for your signature will go here!</textarea>
                                                            </div>
                                                        </div>
                                                        <!-- //test signature -->
                                                    </div>
                                                </div>
                                                  <?php 
                                                    $session = \Config\Services::session();
                                                    $user = $session->get('name');
                                                  ?>
                                                <div class="form-group row">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control"
                                                            name="rampcheck_kesimpulan_nama_penguji"
                                                            id="rampcheck_kesimpulan_nama_penguji"
                                                            placeholder="Nama Penguji" value="<?=$user?>">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control"
                                                            name="rampcheck_kesimpulan_nama_penyidik"
                                                            id="rampcheck_kesimpulan_nama_penyidik"
                                                            placeholder="Nama Penyidik">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control"
                                                            name="rampcheck_kesimpulan_no_penguji"
                                                            id="rampcheck_kesimpulan_no_penguji"
                                                            placeholder="NRP Penguji" required>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control"
                                                            name="rampcheck_kesimpulan_no_penyidik"
                                                            id="rampcheck_kesimpulan_no_penyidik"
                                                            placeholder="AHU Penyidik" required>
                                                    </div>
                                                </div>
                                                <br>
                                                <h6>Catatan : Jika setiap unsur terdapat pelanggaran, maka sanksi yang
                                                    dikenakan adalah sanksi yang paling berat</h6>


                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row py-3">
                                            <div class="col-6">
                                                <a href="#" class="btn btn-white button-next">
                                                    <i data-feather="chevron-left"></i>
                                                </a>
                                                <a href="#" class="btn btn-white button-previous">
                                                    <i data-feather="arrow-left"></i>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" class="btn btn-white button-next"
                                                        onClick="checkSelected()">
                                                        <i data-feather="arrow-right"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-white button-last"
                                                        onClick="checkSelected()">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <table class="table table-theme table-row v-middle" id="datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Rampcheck</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Jenis Lokasi</th>
                                        <th>Nama Lokasi</th>
                                        <th>Nama PO</th>
                                        <th>Nomor Kendaraan</th>
                                        <th>Nomor STUK</th>
                                        <th>Jenis Angkutan</th>
                                        <th>Trayek</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
Dropzone.options.myDropzone = {
  url: '<?=base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1)?>' + '_upload',
  maxFilesize: 10, // MB
  acceptedFiles: 'image/*',
  addRemoveLinks: true,
  dictDefaultMessage: 'Masukkan gambar rampcheck disini',
  dictRemoveFile: 'Remove',
  uploadMultiple: false,
  maxFiles: 5,
  resizeQuality: 0.5,
  headers: {
    "<?=csrf_token()?>": "<?=csrf_hash()?>"
  },
  init: function() {
    this.on('sending', function(file, xhr, formData) {
      formData.append('<?=csrf_token()?>', '<?=csrf_hash()?>');
      console.log(file);
    }).on('complete', function(file) {
      var documentName = file.name;
      var name = file.upload.uuid;
      var dataUrl = file.dataURL;
      
      // send to controller via ajax
      $.ajax({
        url: '<?=base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1)?>' + '_upload',
        type: 'POST',
        data: {
          '<?=csrf_token()?>': '<?=csrf_hash()?>',
          'documentName': documentName,
          'name': name,
          'dataUrl': dataUrl
        },
        success: function(data) {
          console.log(data);
        }
      });
    });
    
  }
};
</script>

<script>
const url = '<?=base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1)?>';
const url_save = '<?=base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) . "/_save"?>';
const url_ajax = '<?=base_url() . "/" . uri_segment(0) . "/ajax"?>';
const url_pdf_rampcheck = '<?=base_url() . "/" . uri_segment(0) . "/action/pdf/rampcheck"?>';

$(document).ready(function() {

    ////////////////////////////////
    // Set Default Date Formating
    ////////////////////////////////
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);

    $('#rampcheck_date').val(today);

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust()
    });

    // rampcheck_noken on type remove space and make it capslock
    $('#rampcheck_noken').on('keyup', function() {
        var val = $(this).val();
        val = val.replace(/\s+/g, '');
        val = val.toUpperCase();
        $(this).val(val);
    });


    // Get Data from API Spionam and Blue after inserting Noken
    $('#rampcheck_noken').on('blur', function() {
        var val = $(this).val();
        var today = new Date();
        var date = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') +
            '-' + today.getDate().toString().padStart(2, '0');
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date + ' ' + time;
        if (val != '') {
            $.ajax({
                url: url_ajax + '/getSpionamAPI',
                type: 'POST',
                data: {
                    'noken': val,
                    '<?=csrf_token()?>': '<?=csrf_hash()?>'
                },
                success: function(data) {
                    data = JSON.parse(data);
                    //// console.log('apiSpionam');
                    //// console.log(data);

                    if (data.message == 'Success') {
                        var perusahaan_id = data.data.perusahaan_id;
                        var nama_trayek = data.data.rute;

                        $('#rampcheck_trayek').val(nama_trayek);

                        // default button for rampcheck_adm_kpr from spionam

                        if (new Date(data.data.tgl_exp_kps) >= new Date(dateTime)) {
                            // set rampcheck_adm_kpr selected value to 0
                            let radBtnRampAdmKpr = document.getElementById(
                                'rampcheck_adm_kpr0');
                            radBtnRampAdmKpr.checked = true;
                        } else if (new Date(data.data.tgl_exp_kps) < new Date(dateTime)) {
                            // set rampcheck_adm_kpr selected value to 1
                            let radBtnRampAdmKpr = document.getElementById(
                                'rampcheck_adm_kpr1');
                            radBtnRampAdmKpr.checked = true;
                        } else {
                            // set rampcheck_adm_kpr selected value to 3
                            let radBtnRampAdmKpr = document.getElementById(
                                'rampcheck_adm_kpr3');
                            radBtnRampAdmKpr.checked = true;
                        }

                        // search perusahaan name from getPerusahaanSpionam by perusahaan_id
                        $.ajax({
                            url: url_ajax + '/getPerusahaanSpionam',
                            type: 'POST',
                            data: {
                                'perusahaan_id': perusahaan_id,
                                '<?=csrf_token()?>': '<?=csrf_hash()?>'
                            },
                            success: function(data) {
                                data = JSON.parse(data);

                                if (data.length > 0) {
                                    var nama_perusahaan = data[0]
                                        .nama_perusahaan;
                                    var jenis_angkutan = data[0]
                                    .jenis_pelayanan;

                                    if (jenis_angkutan != null) {
                                        // check jenis angkutan id and name from database and set it to select2 rampcheck_jenis_angkutan_id
                                        $.ajax({
                                            url: url_ajax +
                                                '/getJenisAngkutanByName',
                                            type: 'POST',
                                            data: {
                                                'jenis_angkutan': jenis_angkutan,
                                                '<?=csrf_token()?>': '<?=csrf_hash()?>'
                                            },
                                            success: function(data) {
                                                data = JSON.parse(
                                                    data);

                                                if (data.length >
                                                    0) {
                                                    var kategori_angkutan =
                                                        data[0]
                                                        .kategori_angkutan_name;
                                                    var kategori_angkutan_id =
                                                        data[0].id;

                                                    $('#rampcheck_jenis_angkutan_id')
                                                        .html(
                                                            '<option value="' +
                                                            kategori_angkutan_id +
                                                            '">' +
                                                            kategori_angkutan +
                                                            '</option>'
                                                            );
                                                }
                                            },
                                            error: function(error) {
                                                //// console.log(error);
                                                $('#rampcheck_jenis_angkutan_id')
                                                    .html(
                                                        '<option value="">Pilih Jenis Angkutan</option>'
                                                        );
                                            }
                                        });
                                    }
                                    $('#rampcheck_po_name').val(
                                    nama_perusahaan);
                                } else {
                                    $('#rampcheck_po_name').val('');
                                    $('#rampcheck_jenis_angkutan_id').html(
                                        '<option value="">Pilih Jenis Angkutan</option>'
                                        );
                                }
                            }
                        });
                    } else {
                        $('#rampcheck_po_name').val('');
                        $('#rampcheck_jenis_angkutan_id').html(
                            '<option value="">Pilih Jenis Angkutan</option>');

                        // default button for rampcheck_adm_kpr from spionam

                        let radBtnRampAdmKpr = document.getElementById(
                        'rampcheck_adm_kpr2');
                        radBtnRampAdmKpr.checked = true;
                    }
                }
            });

            $.ajax({
                url: url_ajax + '/getBlueAPI',
                type: 'POST',
                data: {
                    'noken': val,
                    '<?=csrf_token()?>': '<?=csrf_hash()?>'
                },
                success: function(data) {
                    data = JSON.parse(data);
                    //// console.log(data)
                    if (data.message == 'Tidak Ada Data') {
                        $('#rampcheck_stuk').val('');
                        $('#rampcheck_adm_ku').val('0');

                        // set rampcheck_adm_ku selected value to 2
                        let radBtnRampAdmKu = document.getElementById('rampcheck_adm_ku2');
                        radBtnRampAdmKu.checked = true;

                    } else if (data.message == 'Success') {

                        $('#rampcheck_stuk').val(data.data.no_uji_kendaraan);

                        if (new Date(data.data.masa_berlaku) >= new Date( dateTime)) {
                            // set rampcheck_adm_ku selected value to 0
                            let radBtnRampAdmKu = document.getElementById(
                                'rampcheck_adm_ku0');
                            radBtnRampAdmKu.checked = true;
                        } else if (new Date(data.data.masa_berlaku) <  new Date(dateTime)) {
                            // set rampcheck_adm_ku selected value to 1
                            let radBtnRampAdmKu = document.getElementById(
                                'rampcheck_adm_ku1');
                            radBtnRampAdmKu.checked = true;
                        } else {

                            // set rampcheck_adm_ku selected value to 3
                            let radBtnRampAdmKu = document.getElementById(
                                'rampcheck_adm_ku3');
                            radBtnRampAdmKu.checked = true;
                        }
                    }
                    //// console.log('current : ' + new Date(dateTime) + ' exp : ' +
                    //         new Date(data.data.masa_berlaku) + ' result : ' + (new Date(
                    //             data.data.masa_berlaku) > new Date(today)));
                }
            });
        }
    });


    $('#rampcheck_jenis_lokasi_id').on('select2:select', function(e) {
        var data = e.params.data;

        if (data.id == 1) {
            $('#rampcheck_nama_lokasi_text').hide();
            $('#rampcheck_nama_lokasi_select').show();
        } else {
            $('#rampcheck_nama_lokasi_text').show();
            $('#rampcheck_nama_lokasi_select').hide();
        }
    });

    ////////////////////////////////
    // Datatable Rampcheck
    ////////////////////////////////
    var table = $('#datatable').DataTable({
        lengthMenu: [
            [5, 10, 30, -1],
            [5, 10, 30, "All"]
        ],
        pageLength: 5,
        bProcessing: true,
        serverSide: true,
        scrollY: "500px",
        scrollX: true,
        responsive: true,
        scrollCollapse: true,
        ajax: {
            url: url_ajax + "/ajaxLoadData",
            type: "post",
            data: {
                "<?=csrf_token()?>": "<?=csrf_hash()?>"
            }
        },
        columns: [

            {
                "data": null,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: "rampcheck_no",
                width: "200px"
            },
            {
                data: "rampcheck_kesimpulan_status",
                render: function(data, type, row, meta) {
                    if (data === "0") {
                        return '<div class="alert alert-success" role="alert">Diijinkan Operasional</div>';
                    }
                    if (data === "1") {
                        return '<div class="alert alert-success" role="alert">Peringatan/Perbaiki</div>';
                    }
                    if (data === "2") {
                        return '<div class="alert alert-danger" role="alert">Tilang dan Dilarang Operasional</div>';
                    }
                    if (data === "3") {
                        return '<div class="alert alert-danger" role="alert">Dilarang Operasional</div>';
                    }
                },
                width: "250px"
            },
            {
                data: "rampcheck_date",
                width: "150px"
            },
            {
                data: "jenis_lokasi_name",
                width: "100px"
            },
            {
                data: "terminal_name",
                width: "300px"
            },
            {
                data: "rampcheck_po_name",
                width: "200px"
            },
            {
                data: "rampcheck_noken",
                width: "100px"
            },
            {
                data: "rampcheck_stuk"
            },
            {
                data: "jenis_angkutan_name"
            },
            {
                data: "trayek_name",
                width: "300px"
            },
            {
                data: "id",
                render: function(a, type, data, index) {
                    return '<a href="' + url_pdf_rampcheck + '/p?o=p&search=' + btoa(data['rampcheck_no']) + '.' +
                        btoa(data[
                            'id']) + '" target="_BLANK">\
                            <button class="btn btn-sm btn-outline-success" title="Print"><i class="fa fa-print"></i></button></a>\
                            <button class="btn btn-sm btn-outline-danger hapus" data-id="' + data.id + '" title="Delete">\
                                <i class="fa fa-trash-o"></i>\
                            </button>';
                },
                width: "100px"
            },
        ],
        columnDefs: [{
            searchable: true,
            orderable: true,
            sortable: true,
            targets: 0
        }],
        fixedColumns: true,
        bFilter: true,
    });


    ////////////////////////////////
    // Select2 Jenis Lokasi
    ////////////////////////////////
    $('.select2JenisLokasi').select2({
        placeholder: 'Pilih Jenis Lokasi',
        ajax: {
            url: url_ajax + '/getJenisLokasi',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    ////////////////////////////////
    // Select2 Nama Lokasi - Terminal
    ////////////////////////////////
    $('.select2NamaLokasi').select2({
        placeholder: 'Pilih Nama Lokasi',
        ajax: {
            url: url_ajax + '/getNamaLokasi',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    ////////////////////////////////
    // Select2 Jenis Angkutan
    ////////////////////////////////
    $('.select2JenisAngkutan').select2({
        placeholder: 'Pilih Jenis Angkutan',
        ajax: {
            url: url_ajax + '/getJenisAngkutan',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    ////////////////////////////////
    // Select2 Trayek
    ////////////////////////////////
    $('.select2Trayek').select2({
        placeholder: 'Pilih Trayek',
        ajax: {
            url: url_ajax + '/getTrayek',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $(document).on('submit', '#form', function(e) {
        var sigText = document.getElementById("sig-dataUrl").value;
        var sigTextPenguji = document.getElementById("sig-dataUrl-penguji").value;
        var sigTextPenyidik = document.getElementById("sig-dataUrl-penyidik").value;

        e.preventDefault();
        Swal.fire({
            title: "Simpan data ?",
            text: "Apakah anda yakin akan menyimpan data ini, data yang sudah disimpan tidak dapat diubah atau edit ?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                Swal.fire({
                    title: "",
                    icon: "info",
                    text: "Proses menyimpan data, mohon ditunggu...",
                    didOpen: function() {
                        Swal.showLoading()
                    }
                });
                $.ajax({
                    url: url + "_save",
                    type: 'post',
                    data: $('#form').serialize() + "&sigText=" + sigText +
                        "&sigTextPenguji=" +
                        sigTextPenguji + "&sigTextPenyidik=" + sigTextPenyidik,
                    dataType: 'json',
                    success: function(result) {
                        Swal.close();
                        if (result.success) {
                            Swal.fire('Sukses', result.message, 'success');
                            table.ajax.reload();
                            window.location.href =
                                "<?=base_url('/rampcheck/rampcheck')?>";
                        } else {
                            Swal.fire('Error', result.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire('Error', 'Terjadi kesalahan pada server',
                            'error');
                        table.ajax.reload();
                    }
                });
                //console.log(result);
            }
        });
    });

    $(document).on('click', '.hapus', function() {
            var csrf = {
                "<?=csrf_token()?>": "<?=csrf_hash()?>"
            };
            let $this = $(this);
            let data = {
                id: $this.data('id')
            }
            //console.log(data);
            $.extend(data, csrf);

            Swal.fire({
                title: "Hapus data ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                confirmButtonColor: '#d33',
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: url + "_delete",
                        type: 'post',
                        data: data,
                        dataType: 'json',
                        success: function(result) {
                            Swal.close();
                            if (result.success) {
                                Swal.fire('Sukses', result.message, 'success');
                                table.ajax.reload();
                            } else {
                                Swal.fire('Error', result.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.close();
                            Swal.fire('Error', 'Terjadi kesalahan pada server',
                                'error');
                        }
                    });
                }
            })
        }).on('click', '.edit', function() {
            var csrf = {
                "<?=csrf_token()?>": "<?=csrf_hash()?>"
            };
            let $this = $(this);
            let data = {
                id: $this.data('id')
            }

            //// console.log(data);
            $.extend(data, csrf);

            Swal.fire({
                title: "",
                icon: "info",
                text: "Proses mengambil data, mohon ditunggu...",
                didOpen: function() {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: url + "_edit",
                type: 'post',
                data: data,
                dataType: 'json',
                success: function(result) {
                    Swal.close();
                    if (result.success) {

                        for (var keyy in result.data) {

                            if (result.data[keyy] == 0 || result.data[keyy] == 1 || result.data[
                                    keyy] == 2 || result.data[keyy] == 3) {

                                //// console.log('#' + keyy + result.data[keyy]);
                                $('#' + keyy + result.data[keyy]).prop('checked', true);
                            } else {
                                if (keyy == 'jenis_lokasi_name' || keyy == 'terminal_name' ||
                                    keyy == 'jenis_angkutan_name' || keyy == 'trayek_name') {
                                    //console.log(result.data);
                                    $('#rampcheck_jenis_lokasi_id').html('<option value = "' +
                                        result.data.rampcheck_jenis_lokasi_id +
                                        '" selected >' + result.data.jenis_lokasi_name +
                                        '</option>');
                                    $('#rampcheck_nama_lokasi').html('<option value = "' +
                                        result.data.rampcheck_nama_lokasi + '" selected >' +
                                        result.data.terminal_name + '</option>');
                                    $('#rampcheck_jenis_angkutan_id').html('<option value = "' +
                                        result.data.rampcheck_jenis_angkutan_id +
                                        '" selected >' + result.data.jenis_angkutan_name +
                                        '</option>');
                                    $('#rampcheck_trayek').html('<option value = "' + result
                                        .data.rampcheck_trayek + '" selected >' + result
                                        .data.trayek_name + '</option>');
                                }
                                //// console.log('#' + keyy + ':' + result.data[keyy]);
                                $('#' + keyy).val(result.data[keyy]);
                            }

                        }
                        $('ul#tab li a').first().trigger('click');

                    } else {
                        Swal.fire('Error', result.message, 'error');
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                }
            });
        });


    $(document).on('click', '.print', function() {
            var csrf = {
                "<?=csrf_token()?>": "<?=csrf_hash()?>"
            };
            let $this = $(this);
            let data = {
                id: $this.data('id')
            }
            $.extend(data, csrf);

            Swal.fire({
                title: "",
                icon: "info",
                text: "Proses mengambil data, mohon ditunggu...",
                didOpen: function() {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: url + "_print",
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(result) {
                    Swal.close();
                    if (result.success) {
                        $('#' + result.atr.modal_body).html(result.data)
                        $('#' + result.atr.modal).modal('toggle');
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                }
            });
        })
});

////////////////////////////////
// Default value checklist form
////////////////////////////////

var defaultVal = [
    // Administrasi
    "rampcheck_adm_ku0", "rampcheck_adm_kpr0", "rampcheck_adm_kpc0", "rampcheck_adm_sim0",
    // Unsur Teknis Utama
    "rampcheck_utu_lukd0", "rampcheck_utu_lukj0", "rampcheck_utu_lpad0", "rampcheck_utu_lpaj0",
    "rampcheck_utu_lr0",
    "rampcheck_utu_lm0",
    "rampcheck_utu_kru0", "rampcheck_utu_krp0", "rampcheck_utu_kbd0", "rampcheck_utu_kbb0",
    "rampcheck_utu_skp0",
    "rampcheck_utu_pk0", "rampcheck_utu_pkw0", "rampcheck_utu_pd0", "rampcheck_utu_jd0",
    "rampcheck_utu_apk0",
    "rampcheck_utu_apar0",
    // Unsur Teknis Penunjang
    "rampcheck_utp_bk_ldt0", "rampcheck_utp_bk_krp0", "rampcheck_utp_bk_kru0", "rampcheck_utp_bk_pu0",
    "rampcheck_utp_bk_kcd0", "rampcheck_utp_sp_blk0", "rampcheck_utp_sp_dpn0",
    "rampcheck_utp_ktd_jtd0",
    "rampcheck_utp_pk_bc0", "rampcheck_utp_pk_sp0", "rampcheck_utp_pk_dkr0", "rampcheck_utp_pk_pbr0",
    "rampcheck_utp_pk_ls0", "rampcheck_utp_pk_pgr0", "rampcheck_utp_pk_skp0", "rampcheck_utp_pk_ptk0",
    // Kesimpulan
    "rampcheck_kesimpulan_status0"
];
for (var i = 0; i < defaultVal.length; i++) {
    let radBtnDefault = document.getElementById(defaultVal[i]);
    radBtnDefault.checked = true;
}

function checkSelected() {
    // show sweetalert if required field is empty
    var required = [
        "rampcheck_date", "rampcheck_jenis_lokasi_id", "rampcheck_jenis_angkutan_id",
        "rampcheck_pengemudi", "rampcheck_umur_pengemudi", "rampcheck_noken", "rampcheck_po_name", "rampcheck_stuk", "rampcheck_sticker_no", "rampcheck_trayek"
    ];
    var empty = false;
    for (var i = 0; i < required.length; i++) {
        if (document.getElementById(required[i]).value == "") {
            empty = true;
            break;
        }
    }
    if (empty) {
        Swal.fire('Error', 'Harap isi semua field yang wajib diisi', 'error');
        return false;
    }


    // Kartu Uji / STUK group
    var kartuUji = document.getElementsByName('rampcheck_adm_ku');
    var selectedKartuUji;
    for (var i = 0; i < kartuUji.length; i++) {
        if (kartuUji[i].checked) {
            selectedKartuUji = kartuUji[i].value;
            break;
        }
    }
    //console.log('Kartu Uji / STUK: ' + selectedKartuUji);

    // KP. Reguler group
    var kpReguler = document.getElementsByName('rampcheck_adm_kpr');
    var selectedKpReguler;
    for (var i = 0; i < kpReguler.length; i++) {
        if (kpReguler[i].checked) {
            selectedKpReguler = kpReguler[i].value;
            break;
        }
    }
    //console.log('KP. Reguler: ' + selectedKpReguler);

    // KP. Cadangan group
    var kpCadangan = document.getElementsByName('rampcheck_adm_kpc');
    var selectedKpCadangan;
    for (var i = 0; i < kpCadangan.length; i++) {
        if (kpCadangan[i].checked) {
            selectedKpCadangan = kpCadangan[i].value;
            break;
        }
    }
    //console.log('KP. Cadangan: ' + selectedKpCadangan);

    // SIM group
    var sim = document.getElementsByName('rampcheck_adm_sim');
    var selectedSim;
    for (var i = 0; i < sim.length; i++) {
        if (sim[i].checked) {
            selectedSim = sim[i].value;
            break;
        }
    }
    //console.log('SIM: ' + selectedSim);

    // rampcheck_utp_sp_dpn group
    var rampcheck_utp_sp_dpn = document.getElementsByName('rampcheck_utp_sp_dpn');
    var selectedRampcheck_utp_sp_dpn;
    for (var i = 0; i < rampcheck_utp_sp_dpn.length; i++) {
        if (rampcheck_utp_sp_dpn[i].checked) {
            selectedRampcheck_utp_sp_dpn = rampcheck_utp_sp_dpn[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_sp_dpn: ' + selectedRampcheck_utp_sp_dpn);

    // rampcheck_utp_sp_blk group
    var rampcheck_utp_sp_blk = document.getElementsByName('rampcheck_utp_sp_blk');
    var selectedRampcheck_utp_sp_blk;
    for (var i = 0; i < rampcheck_utp_sp_blk.length; i++) {
        if (rampcheck_utp_sp_blk[i].checked) {
            selectedRampcheck_utp_sp_blk = rampcheck_utp_sp_blk[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_sp_blk: ' + selectedRampcheck_utp_sp_blk);

    // rampcheck_utp_bk_kcd group
    var rampcheck_utp_bk_kcd = document.getElementsByName('rampcheck_utp_bk_kcd');
    var selectedRampcheck_utp_bk_kcd;
    for (var i = 0; i < rampcheck_utp_bk_kcd.length; i++) {
        if (rampcheck_utp_bk_kcd[i].checked) {
            selectedRampcheck_utp_bk_kcd = rampcheck_utp_bk_kcd[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_bk_kcd: ' + selectedRampcheck_utp_bk_kcd);

    // rampcheck_utp_bk_pu group
    var rampcheck_utp_bk_pu = document.getElementsByName('rampcheck_utp_bk_pu');
    var selectedRampcheck_utp_bk_pu;
    for (var i = 0; i < rampcheck_utp_bk_pu.length; i++) {
        if (rampcheck_utp_bk_pu[i].checked) {
            selectedRampcheck_utp_bk_pu = rampcheck_utp_bk_pu[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_bk_pu: ' + selectedRampcheck_utp_bk_pu);

    //rampcheck_utp_bk_kru group
    var rampcheck_utp_bk_kru = document.getElementsByName('rampcheck_utp_bk_kru');
    var selectedRampcheck_utp_bk_kru;
    for (var i = 0; i < rampcheck_utp_bk_kru.length; i++) {
        if (rampcheck_utp_bk_kru[i].checked) {
            selectedRampcheck_utp_bk_kru = rampcheck_utp_bk_kru[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_bk_kru: ' + selectedRampcheck_utp_bk_kru);

    // rampcheck_utp_bk_krp group
    var rampcheck_utp_bk_krp = document.getElementsByName('rampcheck_utp_bk_krp');
    var selectedRampcheck_utp_bk_krp;
    for (var i = 0; i < rampcheck_utp_bk_krp.length; i++) {
        if (rampcheck_utp_bk_krp[i].checked) {
            selectedRampcheck_utp_bk_krp = rampcheck_utp_bk_krp[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_bk_krp: ' + selectedRampcheck_utp_bk_krp);

    // rampcheck_utp_bk_ldt group
    var rampcheck_utp_bk_ldt = document.getElementsByName('rampcheck_utp_bk_ldt');
    var selectedRampcheck_utp_bk_ldt;
    for (var i = 0; i < rampcheck_utp_bk_ldt.length; i++) {
        if (rampcheck_utp_bk_ldt[i].checked) {
            selectedRampcheck_utp_bk_ldt = rampcheck_utp_bk_ldt[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_bk_ldt: ' + selectedRampcheck_utp_bk_ldt);

    // rampcheck_utp_ktd_jtd group
    var rampcheck_utp_ktd_jtd = document.getElementsByName('rampcheck_utp_ktd_jtd');
    var selectedRampcheck_utp_ktd_jtd;
    for (var i = 0; i < rampcheck_utp_ktd_jtd.length; i++) {
        if (rampcheck_utp_ktd_jtd[i].checked) {
            selectedRampcheck_utp_ktd_jtd = rampcheck_utp_ktd_jtd[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_ktd_jtd: ' + selectedRampcheck_utp_ktd_jtd);

    // rampcheck_utp_pk_bc  group
    var rampcheck_utp_pk_bc = document.getElementsByName('rampcheck_utp_pk_bc');
    var selectedRampcheck_utp_pk_bc;
    for (var i = 0; i < rampcheck_utp_pk_bc.length; i++) {
        if (rampcheck_utp_pk_bc[i].checked) {
            selectedRampcheck_utp_pk_bc = rampcheck_utp_pk_bc[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_pk_bc: ' + selectedRampcheck_utp_pk_bc);

    // rampcheck_utp_pk_sp group
    var rampcheck_utp_pk_sp = document.getElementsByName('rampcheck_utp_pk_sp');
    var selectedRampcheck_utp_pk_sp;
    for (var i = 0; i < rampcheck_utp_pk_sp.length; i++) {
        if (rampcheck_utp_pk_sp[i].checked) {
            selectedRampcheck_utp_pk_sp = rampcheck_utp_pk_sp[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_pk_sp: ' + selectedRampcheck_utp_pk_sp);

    // rampcheck_utp_pk_dkr group
    var rampcheck_utp_pk_dkr = document.getElementsByName('rampcheck_utp_pk_dkr');
    var selectedRampcheck_utp_pk_dkr;
    for (var i = 0; i < rampcheck_utp_pk_dkr.length; i++) {
        if (rampcheck_utp_pk_dkr[i].checked) {
            selectedRampcheck_utp_pk_dkr = rampcheck_utp_pk_dkr[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_pk_dkr: ' + selectedRampcheck_utp_pk_dkr);

    // rampcheck_utp_pk_pbr group
    var rampcheck_utp_pk_pbr = document.getElementsByName('rampcheck_utp_pk_pbr');
    var selectedRampcheck_utp_pk_pbr;
    for (var i = 0; i < rampcheck_utp_pk_pbr.length; i++) {
        if (rampcheck_utp_pk_pbr[i].checked) {
            selectedRampcheck_utp_pk_pbr = rampcheck_utp_pk_pbr[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_pk_pbr: ' + selectedRampcheck_utp_pk_pbr);

    // rampcheck_utp_pk_ls group
    var rampcheck_utp_pk_ls = document.getElementsByName('rampcheck_utp_pk_ls');
    var selectedRampcheck_utp_pk_ls;
    for (var i = 0; i < rampcheck_utp_pk_ls.length; i++) {
        if (rampcheck_utp_pk_ls[i].checked) {
            selectedRampcheck_utp_pk_ls = rampcheck_utp_pk_ls[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_pk_ls: ' + selectedRampcheck_utp_pk_ls);

    // rampcheck_utp_pk_pgr group
    var rampcheck_utp_pk_pgr = document.getElementsByName('rampcheck_utp_pk_pgr');
    var selectedRampcheck_utp_pk_pgr;
    for (var i = 0; i < rampcheck_utp_pk_pgr.length; i++) {
        if (rampcheck_utp_pk_pgr[i].checked) {
            selectedRampcheck_utp_pk_pgr = rampcheck_utp_pk_pgr[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_pk_pgr: ' + selectedRampcheck_utp_pk_pgr);

    // rampcheck_utp_pk_skp group
    var rampcheck_utp_pk_skp = document.getElementsByName('rampcheck_utp_pk_skp');
    var selectedRampcheck_utp_pk_skp;
    for (var i = 0; i < rampcheck_utp_pk_skp.length; i++) {
        if (rampcheck_utp_pk_skp[i].checked) {
            selectedRampcheck_utp_pk_skp = rampcheck_utp_pk_skp[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_pk_skp: ' + selectedRampcheck_utp_pk_skp);

    // rampcheck_utp_pk_ptk group
    var rampcheck_utp_pk_ptk = document.getElementsByName('rampcheck_utp_pk_ptk');
    var selectedRampcheck_utp_pk_ptk;
    for (var i = 0; i < rampcheck_utp_pk_ptk.length; i++) {
        if (rampcheck_utp_pk_ptk[i].checked) {
            selectedRampcheck_utp_pk_ptk = rampcheck_utp_pk_ptk[i].value;
            break;
        }
    }
    //console.log('rampcheck_utp_pk_ptk: ' + selectedRampcheck_utp_pk_ptk);


    if (selectedKartuUji != '0' || selectedKpReguler != '0' || selectedKpCadangan != '0' || selectedSim != '0') {

        //console.log('tidak laik & tilang');
          // set rampcheck_kesimpulan_status checked = 2
          document.getElementById('rampcheck_kesimpulan_status2').checked = true;
    } else {

      if (selectedRampcheck_utp_sp_dpn != '0' || selectedRampcheck_utp_sp_blk != '0' ||
            selectedRampcheck_utp_bk_kcd != '0' || selectedRampcheck_utp_bk_pu != '0' ||
            selectedRampcheck_utp_bk_kru != '0' || selectedRampcheck_utp_bk_krp != '0' ||
            selectedRampcheck_utp_bk_ldt != '0' || selectedRampcheck_utp_ktd_jtd != '0' ||
            selectedRampcheck_utp_pk_bc != '0' || selectedRampcheck_utp_pk_sp != '0' ||
            selectedRampcheck_utp_pk_dkr != '0' || selectedRampcheck_utp_pk_pbr != '0' ||
            selectedRampcheck_utp_pk_ls != '0' || selectedRampcheck_utp_pk_pgr != '0' ||
            selectedRampcheck_utp_pk_skp != '0' || selectedRampcheck_utp_pk_ptk != '0') {

              //console.log('Peringatan Perbaiki');
              // set rampcheck_kesimpulan_status checked = 1
              document.getElementById('rampcheck_kesimpulan_status1').checked = true;

        } else {

          //console.log('laik');
          // set rampcheck_kesimpulan_status checked = 0
          document.getElementById('rampcheck_kesimpulan_status0').checked = true;

        }

    }
}
</script>

<!-- JS tanda tangan pengemudi -->
<script src="<?=base_url();?>/assets/js/canvas-pengemudi.js"></script>
<!-- JS tanda tangan penguji -->
<script src="<?=base_url();?>/assets/js/canvas-penguji.js"></script>
<!-- JS tanda tangan penyidik -->
<script src="<?=base_url();?>/assets/js/canvas-penyidik.js"></script>

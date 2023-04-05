<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rampcheck</title>
    <style>
    .dirjen {
        text-align: left;
        font-size: 12px;
        font-weight: bold;
        padding-top: 10px;
    }

    .no-rampcheck {
        text-align: right;
        font-size: 12px;
        font-weight: bold;
        padding-top: -10px;
    }

    .no-sticker {
        text-align: right;
        font-size: 12px;
        font-weight: bold;
        padding-top: -10px;
        padding-right: 20px;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        border: 1px solid black;
        width: 100%;
        font-size: 12px;
        vertical-align: baseline;
    }

    td {
        padding: 5.8px;
        border: 1px solid black;
    }

    th {
        padding: 5.4px;
        background-color: #224DDD;
        border: 1px solid black;
    }
    </style>
</head>

<body>
    <?php 
		if (empty($result->id)) { ?>
    <div style="text-align: center; font-size: 32px;">Maaf Data Tidak Ditemukan</div>
    <?php } else {
	?>
    <div class="row">
        <div class="dirjen">
            DIREKTORAT JENDERAL PERHUBUNGAN DARAT
            <br>
            No Rampcheck : <?=$result->rampcheck_no?>
        </div>
        <div class="no-sticker">
            No Sticker : 
                <?php if($result->rampcheck_sticker_no != null || $result->rampcheck_sticker_no != ''){
                    echo $result->rampcheck_sticker_no;
                } else {
                    echo '-';
                }?>
        </div>
    </div>
    <!-- //////////////////////
        ////////// Data ///////
    ///////////////////// -->
    <div class="table-data">
        <table>
            <tr>
                <th colspan="6" style="text-align:center; color: white;">DATA</th>
            </tr>
            <tr>
                <td style="width:5%; text-align:center;">1.</td>
                <td style="width:15%;">Hari/Tanggal</td>
                <td style="width:25%">
                    <?=date("d M Y" , strtotime($result->rampcheck_date))?>
                </td>
                <td style="width:5%; text-align:center;">6.</td>
                <td style="width:25%">Nama PO</td>
                <td><?=$result->rampcheck_po_name?> 
                </td> 
            </tr>
            <tr>
                <td style="text-align:center;">2.</td>
                <td>Lokasi</td>
                <td><?=$result->jenis_lokasi_name?></td>
                <td style="text-align:center;">7.</td>
                <td>Nomor Kendaraan</td>
                <td><?=$result->rampcheck_noken?></td>
            </tr>
            <tr>
                <td style="text-align:center;">3.</td>
                <td>Nama Lokasi</td>
                <td><?=$result->terminal_name?></td>
                <td style="text-align:center;">8.</td>
                <td>Nomor STUK</td>
                <td><?=$result->rampcheck_stuk?></td>
            </tr>
            <tr>
                <td style="text-align:center;">4.</td>
                <td>Nama Pengemudi</td>
                <td><?=$result->rampcheck_pengemudi?></td>
                <td style="text-align:center;">9.</td>
                <td>Jenis Angkutan</td>
                <td><?=$result->jenis_angkutan_name?></td>
            </tr>
            <tr>
                <td style="text-align:center;">5.</td>
                <td>Umur</td>
                <td><?=$result->rampcheck_umur_pengemudi?> Tahun</td>
                <td style="text-align:center;">10.</td>
                <td>Trayek</td>
                <td><?=$result->trayek_name?></td>
            </tr>
        </table>
    </div>
    <br>
    <!-- //////////////////////
        // Data Administrasi //
    /////////////////////// -->
    <div class="table-administrasi">
        <table>
            <?php $arrAdministrasi = json_decode($result->administrasi);
					foreach ($arrAdministrasi as $dataAdm) {
                        if($dataAdm->rampcheck_adm_ku === "0"){
                            $admKuStatus = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada, Sesuai';
                        }else if($dataAdm->rampcheck_adm_ku === "1"){
                            $admKuStatus = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Berlaku';
                        }else if($dataAdm->rampcheck_adm_ku === "2"){
                            $admKuStatus = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                        }else {
                            $admKuStatus = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Sesuai Fisik';
                        }

                        if($dataAdm->rampcheck_adm_kpr === "0"){
                            $admKpr = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada, Sesuai';
                        }else if($dataAdm->rampcheck_adm_kpr === "1"){
                            $admKpr = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Berlaku';
                        }else if($dataAdm->rampcheck_adm_kpr === "2"){
                            $admKpr = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                        }else {
                            $admKpr = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Sesuai Fisik';
                        }

                        if($dataAdm->rampcheck_adm_kpc === "0"){
                            $admKpc = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada, Sesuai';
                        }else if($dataAdm->rampcheck_adm_kpc === "1"){
                            $admKpc = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Berlaku';
                        }else if($dataAdm->rampcheck_adm_kpc === "2"){
                            $admKpc = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                        }else {
                            $admKpc = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Sesuai Fisik';
                        }

                        if($dataAdm->rampcheck_adm_sim === "0"){
                            $admSim = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> A Umum';
                        }else if($dataAdm->rampcheck_adm_sim === "1"){
                            $admSim = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> B1 Umum';
                        }else if($dataAdm->rampcheck_adm_sim === "2"){
                            $admSim = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> B2 Umum';
                        }else {
                            $admSim = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> SIM Tidak Sesuai';
                        }
				?>

            <tr style="font-weight: bold;">
                <th colspan="2" style="width: 60%; color: white; text-align: center;">I. UNSUR ADMINISTRASI</th>
                <th style="text-align:center; width: 50%; color: white;">HASIL/SANKSI
                </th>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">1.</td>
                <td style="width: 50%">KARTU UJI / STUK</td>
                <td style="width: 50%">
                    <?=$admKuStatus?>
                </td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">2.</td>
                <td style="width: 50%">KP. Reguler</td>
                <td style="width: 50%">
                    <?=$admKpr?>
                </td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">3.</td>
                <td style="width: 50%">KP. Cadangan (untuk kendaraan cadangan)</td>
                <td style="width: 50%">
                    <?=$admKpc?>
                </td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">4.</td>
                <td style="width: 50%">SIM Pengemudi</td>
                <td style="width: 50%">
                    <?=$admSim?>
                </td>
            </tr>
            <?php }
				?>
        </table>
    </div>
    <br>
<!-- //////////////////////
        // Data Umum //
    /////////////////////// -->
    <div class="table-umum">
        <table class="table-umum">
            <?php $arrUtama = json_decode($result->unsur_utama);
				foreach ($arrUtama as $dataUtama) {
                    if($dataUtama->rampcheck_utu_lukd === "0"){
                        $lukd = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Semua Menyala';
                    }else if($dataUtama->rampcheck_utu_lukd === "1"){
                        $lukd = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kanan';
                    }else {
                        $lukd = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kiri';
                    }

                    if($dataUtama->rampcheck_utu_lukj === "0"){
                        $lukj = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Semua Menyala';
                    }else if($dataUtama->rampcheck_utu_lukj === "1"){
                        $lukj = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kanan';
                    }else {
                        $lukj = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kiri';
                    }

                    if($dataUtama->rampcheck_utu_lpad === "0"){
                        $lpad = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Semua Menyala';
                    }else if($dataUtama->rampcheck_utu_lpad === "1"){
                        $lpad = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kanan';
                    }else {
                        $lpad = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kiri';
                    }

                    if($dataUtama->rampcheck_utu_lpaj === "0"){
                        $lpaj = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Semua Menyala';
                    }else if($dataUtama->rampcheck_utu_lpaj === "1"){
                        $lpaj = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kanan';
                    }else {
                        $lpaj = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kiri';
                    }

                    if($dataUtama->rampcheck_utu_lr === "0"){
                        $lr = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Semua Menyala';
                    }else if($dataUtama->rampcheck_utu_lr === "1"){
                        $lr = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kanan';
                    }else {
                        $lr = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kiri';
                    }

                    if($dataUtama->rampcheck_utu_lm === "0"){
                        $lm = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Semua Menyala';
                    }else if($dataUtama->rampcheck_utu_lm === "1"){
                        $lm = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kanan';
                    }else {
                        $lm = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kiri';
                    }

                    if($dataUtama->rampcheck_utu_kbd === "0"){
                        $kbd = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Semua Laik';
                    }else if($dataUtama->rampcheck_utu_kbd === "1"){
                        $kbd = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Laik : Kanan';
                    }else {
                        $kbd = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Laik : Kiri';
                    }

                    if($dataUtama->rampcheck_utu_kbb === "0"){
                        $kbb = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Semua Laik';
                    }else if($dataUtama->rampcheck_utu_kbb === "1"){
                        $kbb = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Laik : Kanan';
                    }else {
                        $kbb = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Laik : Kiri';
                    }

                    if($dataUtama->rampcheck_utu_kru === "0"){
                        $kru = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Berfungsi';
                    }else {
                        $kru = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Berfungsi';
                    }

                    if($dataUtama->rampcheck_utu_krp === "0"){
                        $krp = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Berfungsi';
                    }else {
                        $krp = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Berfungsi';
                    }

                    if($dataUtama->rampcheck_utu_skp === "0"){
                        $skp = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada dan Fungsi';
                    }else if($dataUtama->rampcheck_utu_skp === "1"){
                        $skp = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Fungsi';
                    }else {
                        $skp = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataUtama->rampcheck_utu_pk === "0"){
                        $pk = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada dan Berfungsi';
                    }else if($dataUtama->rampcheck_utu_pk === "1"){
                        $pk = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Berfungsi';
                    }else {
                        $pk = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataUtama->rampcheck_utu_pkw === "0"){
                        $pkw = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada dan Berfungsi';
                    }else if($dataUtama->rampcheck_utu_pkw === "1"){
                        $pkw = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Berfungsi';
                    }else {
                        $pkw = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataUtama->rampcheck_utu_pd === "0"){
                        $pd = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else {
                        $pd = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataUtama->rampcheck_utu_jd === "0"){
                        $jd = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else {
                        $jd = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataUtama->rampcheck_utu_apk === "0"){
                        $apk = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else {
                        $apk = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataUtama->rampcheck_utu_apar === "0"){
                        $apar = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else if($dataUtama->rampcheck_utu_apar === "1"){
                        $apar = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Kadaluarsa';
                    }else {
                        $apar = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }
        ?>
            <tr>
                <th colspan="2" style="text-align:center; color: white;">II. UNSUR TEKNIS UTAMA</th>
                <th style="text-align:center; color: white;">HASIL / SANKSI</th>
            </tr>
            <tr>
                <td colspan="3">A. SISTEM PENERANGAN</td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">1.</td>
                <td colspan="2" style="width:50%;">Lampu Utama Kendaraan</td>
            </tr>
            <tr>
                <td></td>
                <td>a. Dekat</td>
                <td><?=$lukd?></td>
            </tr>
            <tr>
                <td></td>
                <td>b. Jauh</td>
                <td><?=$lukj?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">2.</td>
                <td colspan="2" style="width:50%;">Lampu Penunjuk Jalan</td>
            </tr>
            <tr>
                <td></td>
                <td>a. Dekat</td>
                <td><?=$lpad?></td>
            </tr>
            <tr>
                <td></td>
                <td>b. Jauh</td>
                <td><?=$lpaj?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">3.</td>
                <td style="width:50%;">Lampu Rem</td>
                <td><?=$lr?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">4.</td>
                <td style="width:50%;">Lampu Mundur</td>
                <td><?=$lm?></td>
            </tr>
            <tr>
                <td colspan="3">B. SISTEM PENGEREMAN</td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">5.</td>
                <td style="width:50%;">a. Kondisi Rem Utama</td>
                <td><?=$kru?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">6.</td>
                <td style="width:50%;">a. Kondisi Rem Belakang</td>
                <td><?=$krp?></td>
            </tr>
            <tr>
                <td colspan="3">C. BAN</td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">7.</td>
                <td style="width:50%;">a. Kondisi Ban Depan</td>
                <td><?=$kbd?></td>
            </tr>
            <tr>
                <td></td>
                <td>b. Kondisi Ban Belakang</td>
                <td><?=$kbb?></td>
            </tr>
            <tr>
                <td colspan="3">D. PERLENGKAPAN</td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">8.</td>
                <td style="width:50%;">Sabuk Keselamatan Pengemudi</td>
                <td><?=$skp?></td>
            </tr>
            <tr>
                <td colspan="3">E. PENGUKUR KECEPATAN</td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">9.</td>
                <td style="width:50%;">Pengukur Kecepatan</td>
                <td><?=$pk?></td>
            </tr>
            <tr>
                <td colspan="3">F. PENGHAPUS KACA (WIPER)</td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">10.</td>
                <td style="width:50%;">Penghapus Kaca</td>
                <td><?=$pkw?></td>
            </tr>
            <tr>
                <td colspan="3">G. TANGGAP DARURAT</td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">11.</td>
                <td style="width:50%;">Pintu Darurat</td>
                <td><?=$pd?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">12.</td>
                <td style="width:50%;">Jendela Darurat</td>
                <td><?=$jd?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">13.</td>
                <td style="width:50%;">Alat Pemukul/Pemecah Kaca</td>
                <td><?=$apk?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">14.</td>
                <td style="width:50%;">Alat Pemadam Api Ringan (APAR)</td>
                <td><?=$apar?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <br>

    <!-- //////////////////////
        // Data Penunjang //
    /////////////////////// -->
    <div class="table-penunjang">
        <table class="table-penunjang">
            <?php $arrPenunjang = json_decode($result->unsur_penunjang);
				foreach ($arrPenunjang as $dataPenunjang) {
                    if($dataPenunjang->rampcheck_utp_sp_dpn === "0"){
                        $dpn = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Semua Menyala';
                    }else if($dataPenunjang->rampcheck_utp_sp_dpn === "1"){
                        $dpn = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kanan';
                    }else {
                        $dpn = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kiri';
                    }

                    if($dataPenunjang->rampcheck_utp_sp_blk === "0"){
                        $blk = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Semua Menyala';
                    }else if($dataPenunjang->rampcheck_utp_sp_blk === "1"){
                        $blk = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kanan';
                    }else {
                        $blk = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Menyala : Kiri';
                    }

                    if($dataPenunjang->rampcheck_utp_bk_kcd === "0"){
                        $kcd = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Baik';
                    }else {
                        $kcd = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Kurang Baik';
                    }

                    if($dataPenunjang->rampcheck_utp_bk_pu === "0"){
                        $pu = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Baik';
                    }else {
                        $pu = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Kurang Baik';
                    }

                    if($dataPenunjang->rampcheck_utp_bk_kru === "0"){
                        $kru = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Sesuai';
                    }else {
                        $kru = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Sesuai';
                    }

                    if($dataPenunjang->rampcheck_utp_bk_krp === "0"){
                        $bk_krp = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else if($dataPenunjang->rampcheck_utp_bk_krp === "1"){
                        $bk_krp = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Berfungsi';
                    }else {
                        $bk_krp = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataPenunjang->rampcheck_utp_bk_ldt === "0"){
                        $ldt = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Baik';
                    }else {
                        $ldt = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Keropos/Berlubang';
                    }

                    if($dataPenunjang->rampcheck_utp_ktd_jtd === "0"){
                        $jtd = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Sesuai';
                    }else {
                        $jtd = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Sesuai';
                    }

                    if($dataPenunjang->rampcheck_utp_pk_bc === "0"){
                        $pk_bc = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada dan Laik';
                    }else if($dataPenunjang->rampcheck_utp_pk_bc === "1"){
                        $pk_bc = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Laik';
                    }else {
                        $pk_bc = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataPenunjang->rampcheck_utp_pk_sp === "0"){
                        $pk_sp = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else {
                        $pk_sp = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataPenunjang->rampcheck_utp_pk_dkr === "0"){
                        $pk_dkr = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else {
                        $pk_dkr = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataPenunjang->rampcheck_utp_pk_pbr === "0"){
                        $pk_pbr = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else {
                        $pk_pbr = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataPenunjang->rampcheck_utp_pk_ls === "0"){
                        $pk_ls = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else if($dataPenunjang->rampcheck_utp_pk_ls === "1"){
                        $pk_ls = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Berfungsi';
                    }else {
                        $pk_ls = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataPenunjang->rampcheck_utp_pk_pgr === "0"){
                        $pk_pgr = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else {
                        $pk_pgr = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }
                    
                    if($dataPenunjang->rampcheck_utp_pk_pgr === "0"){
                        $pk_pgr = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else {
                        $pk_pgr = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataPenunjang->rampcheck_utp_pk_skp === "0"){
                        $pk_skp = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else {
                        $pk_skp = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }

                    if($dataPenunjang->rampcheck_utp_pk_ptk === "0"){
                        $pk_ptk = '<img src="'.base_url().'/assets/img/check.png" style="width:10px;height:auto;padding-right:5px;"> Ada';
                    }else {
                        $pk_ptk = '<img src="'.base_url().'/assets/img/cross.png" style="width:10px;height:auto;padding-right:5px;"> Tidak Ada';
                    }
                    
        ?>
            <tr>
                <th colspan="2" style="text-align:center; color: white;">III. UNSUR TEKNIS PENUNJANG</th>
                <th style="text-align:center; color: white;">HASIL / SANKSI</th>
            </tr>
            <tr>
                <td colspan="3">A. SISTEM PENERANGAN</td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">15.</td>
                <td colspan="2" style="width:50%;">Lampu Posisi</td>
            </tr>
            <tr>
                <td></td>
                <td>a. Depan</td>
                <td><?=$dpn?></td>
            </tr>
            <tr>
                <td></td>
                <td>b. Belakang</td>
                <td><?=$blk?></td>
            </tr>
            <tr>
                <td colspan="3">B. BADAN KENDARAAN</td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">16.</td>
                <td style="width:50%;">Kondisi Kaca Depan</td>
                <td><?=$kcd?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">17.</td>
                <td style="width:50%;">Pintu Utama</td>
                <td><?=$pu?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">18.</td>
                <td style="width:50%;">Kondisi Rem Utama</td>
                <td><?=$kru?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">19.</td>
                <td style="width:50%;">Kondisi Rem Parkir</td>
                <td><?=$bk_krp?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">20.</td>
                <td style="width:50%;">Lantai dan Tangga</td>
                <td><?=$ldt?></td>
            </tr>
            <tr>
                <td colspan="3">C. KAPASITAS TEMPAT DUDUK</td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">21.</td>
                <td style="width:50%;">Jumlah Tempat Duduk Penumpang</td>
                <td><?=$jtd?></td>
            </tr>
            <tr>
                <td colspan="3">D. PERLENGKAPAN KENDARAAN</td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">22.</td>
                <td style="width:50%;">Ban Cadangan</td>
                <td><?=$pk_bc?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">23.</td>
                <td style="width:50%;">Segitiga Pengaman</td>
                <td><?=$pk_sp?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">24.</td>
                <td style="width:50%;">Dongkrak</td>
                <td><?=$pk_dkr?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">25.</td>
                <td style="width:50%;">Pembuka Roda</td>
                <td><?=$pk_pbr?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">26.</td>
                <td style="width:50%;">Lampu Senter</td>
                <td><?=$pk_ls?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">27.</td>
                <td style="width:50%;">Pengganjal Roda</td>
                <td><?=$pk_pgr?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">28.</td>
                <td style="width:50%;">Sabuk Keselamatan Penumpang</td>
                <td><?=$pk_skp?></td>
            </tr>
            <tr>
                <td style="width:6%; text-align:center;">29.</td>
                <td style="width:50%;">Kotak PT3K</td>
                <td><?=$pk_ptk?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <br>
<!-- //////////////////////
        // Data Kesimpulan //
    /////////////////////// -->
    <div class="table-kesimpulan">
        <table class="table-kesimpulan">
            <?php $arrKesimpulan = json_decode($result->unsur_kesimpulan);
				foreach ($arrKesimpulan as $dataKesimpulan) {
                    if($dataKesimpulan->rampcheck_kesimpulan_status === "0"){
                        $kesimpulan = '<img src="'.base_url().'/assets/img/check.png" style="width:15px;height:auto;padding-right:5px;"> DIIJINKAN OPERASIONAL  <b style="color:green"> LAIK JALAN </b>';
                    }else if($dataKesimpulan->rampcheck_kesimpulan_status === "1"){
                        $kesimpulan = '<img src="'.base_url().'/assets/img/check.png" style="width:15px;height:auto;padding-right:5px;"> PERINGATAN / PERBAIKAN <b style="color:green"> LAIK JALAN </b>';
                    }else if($dataKesimpulan->rampcheck_kesimpulan_status === "2"){
                        $kesimpulan = '<img src="'.base_url().'/assets/img/cross.png" style="width:15px;height:auto;padding-right:5px;"> TILANG DAN DILARANG OPERASIONAL <b style="color:red"> TIDAK LAIK JALAN </b>';
                    }else {
                        $kesimpulan = '<img src="'.base_url().'/assets/img/cross.png" style="width:15px;height:auto;padding-right:5px;"> DILARANG OPERASIONAL <b style="color:red"> TIDAK LAIK JALAN </b>';
                    }
        ?>
            <tr>
                <th colspan="2" style="text-align:center; color: white;">KESIMPULAN</th>
            </tr>
            <tr>
                <td style="width:50%">BEDASARKAN HASIL DIATAS, MAKA KENDARAAN TERSEBUT DINYATAKAN :</td>
                <td><?=$kesimpulan?></td>
            </tr>
            <tr>
                <td style="width:50%; height: 100px;">CATATAN :</td>
                <td><?=$dataKesimpulan->rampcheck_kesimpulan_catatan?></td>
            </tr>
        </table>
        <br>
        <table class="table-ttd">
            <tr>
                <th style="text-align: center; font-size: 14px; color: white;">PENGEMUDI</th>
                <th style="text-align: center; font-size: 14px; color: white;">PENGUJI KENDARAAN BERMOTOR</th>
                <th style="text-align: center; font-size: 14px; color: white;">PENYIDIK PEGAWAI NEGERI SIPIL</th>
            </tr>
            <tr>
                <td style="text-align: center; height:100px; width: 30%">
                    <img src="<?=base_url().'/'.$dataKesimpulan->rampcheck_kesimpulan_ttd_pengemudi?>" alt="" srcset="">
                </td>
                <td style="text-align: center; height:100px; width: 30%">
                    <img src="<?=base_url().'/'.$dataKesimpulan->rampcheck_kesimpulan_ttd_penguji?>" alt="" srcset="">
                </td>
                <td style="text-align: center; height:100px; width: 30%">
                    <?php if($dataKesimpulan->rampcheck_kesimpulan_ttd_penyidik != null || $dataKesimpulan->rampcheck_kesimpulan_ttd_penyidik != ''){ ?>
                        <img src="<?=base_url().'/'.$dataKesimpulan->rampcheck_kesimpulan_ttd_penyidik?>" alt="" srcset="">
                    <?php } else {
                        echo '';
                    } ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    <b>Nama : <?=$dataKesimpulan->nama_pengemudi?></b>
                </td>
                <td style="text-align: center;">
                    <b>
                        Nama : <?=$dataKesimpulan->rampcheck_kesimpulan_nama_penguji?> <br>
                        NRP : <?=$dataKesimpulan->rampcheck_kesimpulan_no_penguji?>
                    </b>
                </td>
                <td style="text-align: center;">
                    <b>
                        Nama : <?=$dataKesimpulan->rampcheck_kesimpulan_nama_penyidik?> <br>
                        AHU : <?=$dataKesimpulan->rampcheck_kesimpulan_no_penyidik?>
                    </b>
                </td>
            </tr>
            <?php }
				?>
        </table>
        <p style="font-size: 12px; font-style: italic; color: grey;">Catatan : Jika setiap unsur terdapat pelanggaran,
            maka sanksi yang dikenakan adalah sanksi yang paling berat</p>
    </div>
    <pagebreak/>
    <table class="table-lampiran">
          
            <tr>
                <th colspan="5" style="text-align:center; color: white;">LAMPIRAN</th>
            </tr>
    </table>
    <table class="table-lampiran">
        <tr>
   
            <?php $arrLampiran = json_decode($result->foto_pendukung);
                
				foreach ($arrLampiran as $dataLampiran) {
                  
                    echo '<td><img src="' . $dataLampiran->lampiran . '" height="100%" width="100%" /></td>';
                  
                  
                    }
                 ?>
      
        </tr>
          
        </table>


    <?php
        }
    ?>

    
</body>

</html>

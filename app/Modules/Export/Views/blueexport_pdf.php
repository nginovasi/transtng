<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;800&display=swap" rel="stylesheet">

	<title><?= $result ? $result->no_registrasi_kendaraan : '-';  ?>_<?= $result ? $result->no_srut : '-'; ?></title>
</head>
<body>
	<style type="text/css">
		body{
			font-family: 'Manrope', sans-serif;
			font-size: 12px;
			color: #1D2939;
		}

		.label {
			width: 240px;
			height: 16px;
			padding: 1px 0px;
		}

		.colon {
			padding: 1px 0px;
			width: 10px;
		}

		.judultd{
			width: 145px;
		}
	</style>

	<div style="margin-bottom: 75px;">
		<div style="padding-top: 20px; font-weight: bold; font-size: 20px; line-height: 28px">SURAT KETERANGAN BLUE / BLUE RFID</div>
		<div style="font-weight: 400; font-size: 12px; line-height: 16px">NO SRUT : <?= $result ? $result->no_srut : '-' ?></div>
	</div>

	<?php if (!$result) { ?>
		<div style="text-align: center; font-weight: bold">Data Tidak Ditemukan</div>
	<?php } else { ?>
		<table width="100%">
			<tr>
				<td class="label">Tanggal</td>
				<td class="colon">:</td>
				<td><?= $result->date ? $result->date : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Nama Pemilik</td>
				<td class="colon">:</td>
				<td><?= $result->nama_pemilik ? $result->nama_pemilik : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Alamat Pemilik</td>
				<td class="colon">:</td>
				<td><?= $result->alamat_pemilik ? $result->alamat_pemilik : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">No SRUT</td>
				<td class="colon">:</td>
				<td><?= $result->no_srut ? $result->no_srut : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Tanggal SRUT</td>
				<td class="colon">:</td>
				<td><?= $result->tgl_srut ? date('d-m-yy', strtotime($result->tgl_srut)) : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">No Registrasi Kendaraan</td>
				<td class="colon">:</td>
				<td><?= $result->no_registrasi_kendaraan ? $result->no_registrasi_kendaraan : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">No Rangka</td>
				<td class="colon">:</td>
				<td><?= $result->no_rangka ? $result->no_rangka : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">No Mesin</td>
				<td class="colon">:</td>
				<td><?= $result->no_mesin ? $result->no_mesin : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Jenis Kendaraan</td>
				<td class="colon">:</td>
				<td><?= $result->jenis_kendaraan ? $result->jenis_kendaraan : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Merk</td>
				<td class="colon">:</td>
				<td><?= $result->merk ? $result->merk : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Tipe</td>
				<td class="colon">:</td>
				<td><?= $result->tipe ? $result->tipe : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Tahun Rakit</td>
				<td class="colon">:</td>
				<td><?= $result->tahun_rakit ? $result->tahun_rakit : '-'; ?></td>
			</tr>
		</table>
	<?php } ?>
</body>
</html>
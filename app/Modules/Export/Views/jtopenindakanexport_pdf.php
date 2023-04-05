<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;800&display=swap" rel="stylesheet">

	<title><?= $result ? $result->no_kend : '-';  ?>_<?= $result ? $result->nama_jembatan : '-'; ?></title>
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
		<div style="padding-top: 20px; font-weight: bold; font-size: 20px; line-height: 28px">SURAT KETERANGAN JTO PENINDAKAN</div>
		<div style="font-weight: 400; font-size: 12px; line-height: 16px">NO KENDARAAN : <?= $result ? $result->no_kend : '-' ?></div>
	</div>

	<?php if (!$result) { ?>
		<div style="text-align: center; font-weight: bold">Data Tidak Ditemukan</div>
	<?php } else { ?>
		<table width="100%">
			<tr>
				<td class="label">Nama Jembatan</td>
				<td class="colon">:</td>
				<td><?= $result->nama_jembatan ? $result->nama_jembatan : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Tanggal</td>
				<td class="colon">:</td>
				<td><?= $result->tanggal ? $result->tanggal : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Toleransi</td>
				<td class="colon">:</td>
				<td><?= $result->toleransi ? $result->toleransi : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">No Kendaraan</td>
				<td class="colon">:</td>
				<td><?= $result->no_kend ? $result->no_kend : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Pelanggaran</td>
				<td class="colon">:</td>
				<td><?= $result->pelanggaran ? $result->pelanggaran : '-'; ?></td>
			</tr>
		</table>
	<?php } ?>
</body>
</html>
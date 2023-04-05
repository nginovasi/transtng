<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;800&display=swap" rel="stylesheet">

	<title><?= $result ? $result->id : '-';  ?>_<?= $result ? $result->nama_jembatan : '-'; ?></title>
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
		<div style="padding-top: 20px; font-weight: bold; font-size: 20px; line-height: 28px">SURAT KETERANGAN JTO MASTER</div>
		<div style="font-weight: 400; font-size: 12px; line-height: 16px">ID : <?= $result ? $result->id : '-' ?></div>
	</div>

	<?php if (!$result) { ?>
		<div style="text-align: center; font-weight: bold">Data Tidak Ditemukan</div>
	<?php } else { ?>
		<table width="100%">
			<tr>
				<td class="label">Nama Provinsi</td>
				<td class="colon">:</td>
				<td><?= $result->nama_provinsi ? $result->nama_provinsi : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Nama Kota</td>
				<td class="colon">:</td>
				<td><?= $result->nama_kota ? $result->nama_kota : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Nama Jembatan</td>
				<td class="colon">:</td>
				<td><?= $result->nama_jembatan ? $result->nama_jembatan : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Alamat</td>
				<td class="colon">:</td>
				<td><?= $result->alamat ? $result->alamat : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">ETL Date</td>
				<td class="colon">:</td>
				<td><?= $result->etl_date ? $result->etl_date : '-'; ?></td>
			</tr>
		</table>
	<?php } ?>
</body>
</html>
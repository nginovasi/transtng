<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;800&display=swap" rel="stylesheet">

	<title><?= $result ? $result->belangko : '-';  ?>_<?= $result ? $result->no_polisi : '-'; ?></title>
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
		<div style="padding-top: 20px; font-weight: bold; font-size: 20px; line-height: 28px">SURAT KETERANGAN ETILANG</div>
		<div style="font-weight: 400; font-size: 12px; line-height: 16px">NO POLISI : <?= $result ? $result->no_polisi : '-' ?></div>
	</div>

	<?php if (!$result) { ?>
		<div style="text-align: center; font-weight: bold">Data Tidak Ditemukan</div>
	<?php } else { ?>
		<table width="100%">
			<tr>
				<td class="label">Belangko</td>
				<td class="colon">:</td>
				<td><?= $result->belangko ? $result->belangko : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Tanggal Penindakan</td>
				<td class="colon">:</td>
				<td><?= $result->tanggal_penindakan ? date('d-m-yy', strtotime($result->tanggal_penindakan)) : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Tanggal Sidang</td>
				<td class="colon">:</td>
				<td><?= $result->tanggal_sidang ? date('d-m-yy', strtotime($result->tanggal_sidang)) : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Tanggal Bayar</td>
				<td class="colon">:</td>
				<td><?= $result->tanggal_bayar ? date('d-m-yy', strtotime($result->tanggal_bayar)) : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Nama PPNS</td>
				<td class="colon">:</td>
				<td><?= $result->nama_ppns ? $result->nama_ppns : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Satuan Kerja</td>
				<td class="colon">:</td>
				<td><?= $result->satuan_kerja ? $result->satuan_kerja : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Nama Pelanggar</td>
				<td class="colon">:</td>
				<td><?= $result->nama_pelanggar ? $result->nama_pelanggar : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">No Polisi</td>
				<td class="colon">:</td>
				<td><?= $result->no_polisi ? $result->no_polisi : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Kendaraan</td>
				<td class="colon">:</td>
				<td><?= $result->kendaraan ? $result->kendaraan : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Titipan</td>
				<td class="colon">:</td>
				<td><?= $result->titipan ? $result->titipan : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Denda</td>
				<td class="colon">:</td>
				<td><?= $result->denda ? $result->denda : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Pasal</td>
				<td class="colon">:</td>
				<td><?= $result->pasal ? $result->pasal : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Denda Maksimum</td>
				<td class="colon">:</td>
				<td><?= $result->denda_maksimum ? $result->denda_maksimum : '-'; ?></td>
			</tr>
		</table>
	<?php } ?>
</body>
</html>
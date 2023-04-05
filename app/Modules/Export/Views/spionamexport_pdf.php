<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;800&display=swap" rel="stylesheet">

	<title><?= $result ? $result->noken : '-';  ?>_<?= $result ? $result->perusahaan_id : '-'; ?></title>
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
		<div style="padding-top: 20px; font-weight: bold; font-size: 20px; line-height: 28px">SURAT KETERANGAN SPIONAM</div>
		<div style="font-weight: 400; font-size: 12px; line-height: 16px">NO KPS : <?= $result ? $result->no_kps : '-'?></div>
	</div>

	<?php if (!$result) { ?>
		<div style="text-align: center; font-weight: bold">Data Tidak Ditemukan</div>
	<?php } else { ?>
		<table width="100%">
			<tr>
				<td class="label">Perusahaan ID</td>
				<td class="colon">:</td>
				<td><?= $result->perusahaan_id ? $result->perusahaan_id : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Jenis Pelayanan</td>
				<td class="colon">:</td>
				<td><?= $result->jenis_pelayanan ? $result->jenis_pelayanan : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Kode Kendaraan</td>
				<td class="colon">:</td>
				<td><?= $result->kode_kendaraan ? $result->kode_kendaraan : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Noken</td>
				<td class="colon">:</td>
				<td><?= $result->noken ? $result->noken : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">No Uji</td>
				<td class="colon">:</td>
				<td><?= $result->no_uji ? $result->no_uji : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Tanggal Exp Uji</td>
				<td class="colon">:</td>
				<td><?= $result->tgl_exp_uji ? date('d-m-yy', strtotime($result->tgl_exp_uji)) : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">No KPS</td>
				<td class="colon">:</td>
				<td><?= $result->no_kps ? $result->no_kps : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Tanggal Exp KPS</td>
				<td class="colon">:</td>
				<td><?= $result->tgl_exp_kps ? date('d-m-yy', strtotime($result->tgl_exp_kps)) : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">No Srut</td>
				<td class="colon">:</td>
				<td><?= $result->no_srut ? $result->no_srut : '-'; ?></td>
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
				<td class="label">No merek</td>
				<td class="colon">:</td>
				<td><?= $result->merek ? $result->merek : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Tahun</td>
				<td class="colon">:</td>
				<td><?= $result->tahun ? $result->tahun : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Seat</td>
				<td class="colon">:</td>
				<td><?= $result->seat ? $result->seat : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Kode Trayek</td>
				<td class="colon">:</td>
				<td><?= $result->kode_trayek ? $result->kode_trayek : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Nama Trayek</td>
				<td class="colon">:</td>
				<td><?= $result->nama_trayek ? $result->nama_trayek : '-'; ?></td>
			</tr>
			<tr>
				<td class="label">Rute</td>
				<td class="colon">:</td>
				<td><?= $result->rute ? $result->rute : '-'; ?></td>
			</tr>
		</table>
	<?php } ?>
</body>
</html>
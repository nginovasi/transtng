<!DOCTYPE html>
<html>
<head>
	<title>Data Paguyuban</title>
</head>
<body>
	<div class="">
		<h4 align="center" style="text-decoration: underline;">Data Paguyuban</h4>
		<h4 align="left" style="text-decoration: underline;">Paguyuban : <?= $data_excel['paguyuban']->paguyuban_mudik_name; ?></h4>
		<h4 align="left" style="text-decoration: underline;">Jadwal : <?= $data_excel['jadwal']->text; ?> </h4>
	</div>

	<small>Download date : <?=date("d M Y H:i:s")?></small>
	<table width="100%" border="1">
		<thead>
			<tr>
				<th>Kursi</th>
				<th>Nama</th>
				<th>Email (Sudah pernah login apk mitra darat & belum daftar mudik sebelumnya)</th>
				<th>No WA</th>
				<th>NIK</th>
				<th>No KK</th>
			</tr>
		</thead>
        <tbody>
        <?php
            foreach ($data_excel['seats'] as $item) { 
        ?>
                <tr>
                    <td><?= $item->seat_map_detail_name; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
        <?php 
            }
		?>
        </tbody>
	</table>
</body>
</html>
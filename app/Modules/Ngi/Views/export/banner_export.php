<!DOCTYPE html>
<html>
<head>
	<title>Data Banner</title>
</head>
<body>
	<style type="text/css">
		table{
			border-collapse: collapse;
			width: 100%;
		}

		table th, td {
			padding: 6px 8px;
		}

		.export_by_system {
			font-size: 10px;
			color: #8C8C8C;
			font-style: italic;
			margin-top: 10px;
		}

		.judul {
			text-align: center;
			margin-bottom: 20px;
		}
	</style>

	<div class="judul">
		<div>LAPORAN DATA BANNER </div>
		<div>TANGGAL <?=date('d M Y')?></div>
	</div>
	<table border="1">
		<thead>
			<tr>
				<th>NO</th>
				<th>NAMA BANNER</th>
				<th>URUT</th>
				<th>BANNER</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$no = 0;
				foreach ($data_excel as $item) { $no++;
					?>
				<tr>
					<td><?=$no?></td>
					<td><?=$item->banner_name?></td>
					<td><?=$item->banner_order?></td>
					<td><?=$data_url=='pdf'? '<img src="'.$item->banner_link.'" alt="'.$item->banner_link.'" height="30px" >' :  $item->banner_link ?></td>
				</tr>
				<?php 
				}	
			?>
		</tbody>		
	</table>
	<div class="export_by_system">Export From System <?=date('d-m-Y H:i:s')?></div>
</body>
</html>
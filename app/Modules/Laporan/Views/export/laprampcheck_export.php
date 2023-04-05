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

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        border: 1px solid black;
        table-layout: fixed;
        width: 100%;
        font-size: 12px;
        margin-top: 15px;
    }

    td {
        padding: 5.4px;
        border: 1px solid black;
        max-width: 100px;
        height: auto;
        overflow: wrap;
    }

    th {
        padding: 5.4px;
        background-color: #224DDD;
        border: 1px solid black;
        color: white;
    }
    </style>
</head>

<body>
    <div class="row">
        <div class="dirjen">
            DIREKTORAT JENDERAL PERHUBUNGAN DARAT
        </div>
    </div>

    <?php
        
        $table = '<table>';
        $table .= '<tr>';
        $table .= '<th>No</th>';
        $table .= '<th>Nomor Rampcheck</th>';
        $table .= '<th>Tanggal Rampcheck</th>';
        $table .= '<th>Jenis Lokasi</th>';
        $table .= '<th>Nama Lokasi</th>';
        $table .= '<th>Nama PO</th>';
        $table .= '<th>Nomor Kendaraan</th>';
        $table .= '<th>Trayek</th>';
        $table .= '<th>Kesimpulan</th>';
        $table .= '</tr>';
        $no = 1;
        foreach ($data_rampcheck as $row) {
            $table .= '<tr>';
            $table .= '<td>' . $no . '</td>';
            $table .= '<td>' . $row->rampcheck_no . '</td>';
            $table .= '<td>' . $row->rampcheck_date . '</td>';
            $table .= '<td>' . $row->jenis_lokasi_name . '</td>';
            $table .= '<td>' . $row->rampcheck_nama_lokasi . '</td>';
            $table .= '<td>' . $row->rampcheck_po_name . '</td>';
            $table .= '<td>' . $row->rampcheck_noken . '</td>';
            $table .= '<td>' . $row->rampcheck_trayek . '</td>';
            $table .= '<td>' . $row->rampcheck_kesimpulan . '</td>';
            $table .= '</tr>';
            $no++;
        }
        $table .= '</table>';

        echo $table;
    ?>
</body>

</html>

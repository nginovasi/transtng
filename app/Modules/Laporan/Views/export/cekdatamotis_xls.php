<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Motis dalam Jadwal/Armada</title>
    <style>
        .dirjen {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            padding-top: 30px;
        }

        .no-spda {
            text-align: center;
            font-size: 13px;
            /* font-weight: bold; */
            /* padding-top: 30px; */
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            border: 1px solid black;
            width: 100%;
            font-size: 12px;
        }

        td {
            padding: 5.4px;
            border: 1px solid black;
        }

        th {
            padding: 5.4px;
            background-color: #0081C9;
            color: white;
            border: 1px solid black;
        }

        .table-data {
            padding-top: 10px;
        }

        /* odd and even rows */
        tr:nth-child(even) {
            background-color: #e6e6e6;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="dirjen" colspan="13">
            LAPORAN DATA MOTIS DALAM JADWAL/ARMADA
        </div>
    </div>
    <div class="table-data">
        <table>
            <thead>
                <tr rowspan="2">
                    <th rowspan="1">No</th>
                    <th rowspan="1">Nama Pendaftar</th>
                    <th rowspan="1">Nama STNK</th>
                    <th rowspan="1" style="width:11%">NIK</th>
                    <th rowspan="1" style="width:10%">No. HP</th>
                    <th rowspan="1" style="width:10%">E-Mail</th>
                    <th rowspan="1" style="width:10%">Kendaraan</th>
                    <th rowspan="1">No. STNK</th>
                    <th rowspan="1" style="width:10%">Armada</th>
                    <th rowspan="1" style="width:10%">Route</th>
                    <th rowspan="1" style="width:8%">Terminal Keberangkatan</th>
                    <th rowspan="1" style="width:8%">Terminal Kedatangan</th>
                    <th rowspan="1" style="width:5%">Arus</th>
                    <th rowspan="1" style="width:5%">Jenis</th>
                    <th rowspan="1" style="width:5%">Status</th>
                    <th rowspan="1" style="width:8%">LOG Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($data_excel[0] == null) {
                    echo "<tr><td colspan='13' align='center'><b>Maaf Data Tidak Ditemukan</b></td></tr>";
                } else {
                    $no = 1;
                    foreach ($data_excel[0] as $data) {
                ?>
                        <tr>
                            <td align="center"><?= $no++ ?></td>
                            <td><?= strtoupper($data->user_mobile_name) ?></td>
                            <td><?= strtoupper($data->nama_pemilik_kendaraan) ?></td>
                            <td><?= $data->nik_pendaftar_kendaraan ?></td>
                            <td><?= $data->user_mobile_phone?></td>
                            <td><?= $data->user_mobile_email?></td>
                            <td><?= strtoupper($data->kendaraan) ?></td>
                            <td><?= $data->no_stnk_kendaraan ?></td>
                            <td align="center"><?= $data->armada_name ?></td>
                            <td align="center"><?= $data->route_name ?></td>
                            <td align="center"><?= $data->route_from; ?></td>
                            <td align="center"><?= $data->route_to ?></td>
                            <td align="center"><?= $data->arus ?></td>
                            <td align="center">
                                <?php 
                                if ($data->motis_is_paguyuban == '0') {
                                    echo "Umum";
                                } else {
                                    echo "Paguyuban";
                                }
                                ?>
                            </td>
                            <td align="center">
                                <?php
                                if ($data->status_expired == 'Expired') {
                                    echo "<span style='color:red; font-weight:bold;'>" . $data->status_expired . "</span>";
                                } else {
                                    echo "<span style='color:green; font-weight:bold;'>" . $data->status_expired . "</span>";
                                }
                                ?>
                            </td>
                            <td><?= $data->motis_date_verif ?></td>
                        </tr>
                <?php }
                } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="16" style="text-align: center; font-size: 12px;">Dicetak pada <?= date('d-m-Y H:i:s') ?>, dengan user <?= session()->get('username') ?> dan IP <?= $_SERVER['REMOTE_ADDR'] ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <br>
</body>

</html>
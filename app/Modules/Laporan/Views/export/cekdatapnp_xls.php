<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Penumpang dalam Jadwal/Armada</title>
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
    <?php
    if ($data_excel == null) {
    ?>
        <div style="text-align: center; font-size: 32px;">Maaf Data Tidak Ditemukan</div>
    <?php return;
    } else { ?>
        <div class="row">
            <div class="dirjen">
                LAPORAN DATA PENUMPANG<?php if ($data_excel[1] == "Mudik") {
                                            echo " RUTE MUDIK";
                                        } else if ($data_excel[1] == "Balik") {
                                            echo " RUTE BALIK";
                                        } else {
                                            echo "";
                                        }
                                        ?> DALAM JADWAL/ARMADA
            </div>
            <?php if ($data_excel[1] == "Mudik") { ?>
                <div class="no-spda"></div>
            <?php } else if ($data_excel[1] == "Balik") { ?>
                <div class="no-spda"></div>
            <?php } else { ?>
                <div class="no-spda"> <?php print_r($data_excel[0][0]->info_jadwal); ?> </div>
            <?php } ?>
        </div>
        <div class="table-data">
            <table>
                <thead>
                    <tr rowspan="2">
                        <th rowspan="1">No</th>
                        <th rowspan="1" style="width:15%">Nama Penumpang</th>
                        <th rowspan="1">NIK</th>
                        <th rowspan="1">No. HP</th>
                        <th rowspan="1" style="width:15%">Rute</th>
                        <th rowspan="1" style="width:15%">Armada</th>
                        <th rowspan="1">Kode Armada</th>
                        <th rowspan="1">Baris & Nomor<br>Bangku</th>
                        <?php if (($data_excel[1] == "Mudik") || ($data_excel[1] == "Balik")) { ?>
                            <th rowspan="1">Arus</th>
                        <?php } else { ?>
                            <th rowspan="1">Arus</th>
                        <?php } ?>
                        <th rowspan="1" style="width:8%">Status</th>
                        <th rowspan="1"style="width:8%">LOG Date</th>
                        <th rowspan="1"style="width:8%">LOG Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($data_excel[0] as $data) {
                        // $no++;
                        // $tbn = $data->transaction_booking_name;
                        // $nik = $data->nik;
                        // $sgb = $data->seat_group_baris;
                        // $smd = $data->seat_map_detail_name;
                        // $ij = $data->info_jadwal;
                        // $bvs = $data->billing_status_verif;
                        // $va = $data->verified_at;
                        // $uwn = $data->user_web_name;
                    ?>
                        <tr>
                            <td align="center"><?= $no++ ?></td>
                            <td><?= strtoupper($data->transaction_booking_name) ?></td>
                            <td><?= strtoupper($data->nik) ?></td>
                            <td align="center"><?=$data->phone?></td>
                            <td><?=$data->route_name?></td>
                            <td><?=$data->armada_name?></td>
                            <td align="center"><?=$data->armada_code?></td>
                            <td align="center"><?php echo $data->seat_group_baris;
                                                echo " " . $data->seat_map_detail_name ?></td>
                            <?php if (($data_excel[1] == "Mudik") || ($data_excel[1] == "Balik")) { ?>
                                <td><?php echo $data->arus; ?></td>
                            <?php } else { ?>
                                <td><?php echo $data->arus; ?></td>
                            <?php } ?>
                            <td align="center">
                                <?php
                                if ($data->billing_status_verif == '1') {
                                    echo "<font color=green>Sudah Validasi</font>";
                                    // if ($data->status_expired == '1') {
                                    //     echo "<br><font color=red>Sudah Expired</font>";
                                    // } else {
                                    //     echo "<br><font color=green>Belum Expired</font>";
                                    // }
                                } else {
                                    // echo "<font color=red>Belum Validasi</font>";
                                    if ($data->status_expired == '1') {
                                        echo "<br><font color=red>Sudah Expired</font>";
                                    } else {
                                        echo "<br><font color=green>Belum Expired</font>";
                                    }
                                }
                                ?>
                            </td>
                            <td><?=$data->verified_at ?></td>
                            <td><?=$data->user_web_name ?></td>
                        </tr>
                    <?php } ?>

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="12" style="text-align: center; font-size: 12px;">Dicetak pada <?= date('d-m-Y H:i:s') ?>, dengan user <?= session()->get('username') ?> dan IP <?= $_SERVER['REMOTE_ADDR'] ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php } ?>
    <br>
</body>

</html>
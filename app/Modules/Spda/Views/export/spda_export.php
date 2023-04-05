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
            font-size: 15px;
            font-weight: bold;
            padding-top: 30px;
        }

        .no-spda {
            text-align: right;
            font-size: 15px;
            font-weight: bold;
            padding-top: 30px;
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
            background-color: #224DDD;
            border: 1px solid black;
        }

        .table-data {
            padding-top: 80px;
        }

        .table-ttd {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <?php
    if ($data_excel->id == null) { ?>
        <div style="text-align: center; font-size: 32px;">Maaf Data Tidak Ditemukan</div>
    <?php } else {
    ?>
        <div class="row">
            <div class="dirjen">
                DIREKTORAT JENDERAL PERHUBUNGAN DARAT
            </div>
            <div class="no-spda">
                <?= $data_excel->no_spda ?>
            </div>
        </div>


        <div class="table-data">
            <table>
                <tr>
                    <th colspan="6" style="text-align:center; color: white;"><?= $data_excel->trayek_name ?></th>
                </tr>
                <tr>
                    <td style="width:6%; text-align:center;">1.</td>
                    <td>Hari/Tanggal</td>
                    <td>
                        <?= date("d M Y", strtotime($data_excel->tgl_spda)) ?>
                    </td>
                    <td style="width:6%; text-align:center;">6.</td>
                    <td style="width:25%">Konsumsi BBM</td>
                    <td><?= $data_excel->bbm_spda ?> Liter</td>
                </tr>
                <tr>
                    <td style="text-align:center;">2.</td>
                    <td>Nama Pengemudi</td>
                    <td><?= $data_excel->nama_pengemudi ?></td>
                    <td style="text-align:center;">7.</td>
                    <td>Waktu Tempuh</td>
                    <td><?= $data_excel->wkt_tempuh_spda ?></td>
                </tr>
                <tr>
                    <td style="text-align:center;">3.</td>
                    <td>Kode Bus</td>
                    <td><?= $data_excel->armada_code ?></td>
                    <td style="text-align:center;">8.</td>
                    <td>Kapasitas Bus</td>
                    <td><?= $data_excel->armada_kapasitas ?> Seat</td>
                </tr>
                <tr>
                    <td style="text-align:center;">4.</td>
                    <td>Ritase</td>
                    <td><?= $data_excel->ritase_spda ?></td>
                    <td style="text-align:center;">9.</td>
                    <td>Total Penumpang</td>
                    <td><?= $data_excel->ttl_penumpang_spda ?> Orang</td>
                </tr>
                <tr>
                    <td style="text-align:center;">5.</td>
                    <td>Jarak</td>
                    <td><?= $data_excel->jrk_tempuh_spda ?></td>
                    <td style="text-align:center;">10.</td>
                    <td>Total Pendapatan</td>
                    <td><?= "Rp " . number_format($data_excel->ttl_pdptan_spda, 0, ',', '.') ?></td>
                </tr>
            </table>
        </div>
        <table class="table-ttd">
            <tr>
                <th style="text-align: center; font-size: 14px; color: white;">Pengemudi</th>
                <th style="text-align: center; font-size: 14px; color: white;">Manager</th>
            </tr>
            <tr>
                <td style="text-align: center; height:100px">
                    <img src="<?= $data_excel->form_spda_ttd_pengemudi ?>" alt="" srcset="">
                </td>
                <td style="text-align: center; height:100px">
                    <img src="<?= $data_excel->form_spda_ttd_manager ?>" alt="">
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    <b>Nama : <?= $data_excel->nama_pengemudi ?></b>
                </td>
                <td style="text-align: center;">
                    <b>
                        Nama : <?= $data_excel->form_spda_nama_manager ?> <br>
                    </b>
                </td>
            </tr>
        </table>
    <?php } ?>
    <br>
</body>

</html>
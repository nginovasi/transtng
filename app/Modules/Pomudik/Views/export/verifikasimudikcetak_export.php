<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Verifikasi Peserta</title>
</head>
<style>
    .judul {
        text-align: center;
        font-size: 15px;
        font-weight: bold;
        padding-top: 0px;
        padding-bottom: 15px;
    }

    .detail-spda {
        text-align: left;
        font-size: 15px;
        font-weight: normal;
        padding: 0px 10px 5px 0px;
        margin: 0px;
        border: none;

    }

    .table-detail {
        border: none;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        border: 1px solid black;
        width: 100%;
        font-size: 12px;
    }

    .signatures {
        border: 1px solid white;
        width: 33%;
        text-align: center;
    }

    td {
        padding: 5.4px;
        border: 1px solid black;
        /* text-align: center; */
    }

    th {
        padding: 5.4px;
        background-color: #224DDD;
        border: 1px solid black;
        color: white;
        text-align: center;
    }

    .table-data {
        padding-top: 30px;
    }

    .table-ttd {
        margin-top: 100px;
    }
</style>

<body>

    <?php
    if (empty($data_excel)) {
        echo "<div style='text-align: center; font-size: 32px;'>Maaf Data Tidak Ditemukan</div>";
        return false;
    }
    $STATUS = $data_excel[0]->STATUS;
    $tanggalstart = $data_excel[0]->$dateStart;
    $tanggalend = $data_excel[1]->$dateEnd;

    ?>
    <div class="judul">
        DIREKTORAT JENDERAL PERHUBUNGAN DARAT <br>
        LAPORAN VERIFIKASI DATA PESERTA
    </div>

    <div class="row">
        <div class="dirjen">
            &nbsp; <br>

        </div>

    </div>
    <table class="table-detail">
        <tr>
            <td class="detail-spda px-0 py-0" style="width:0px;height:0px">Status</td>
            <td class="detail-spda">: <?php echo $STATUS;
                                        ?></td>
        </tr>
        <tr>
            <td class="detail-spda px-0 py-0" style="width:0px;height:0px">Tanggal</td>
            <td class=" detail-spda">: <?php echo $tanggalstart . ' s/d ' . $tanggalend;
                                        ?></td>
        </tr>

    </table>
    <div class="row"></div>
    <div class="table-data">
        <table>
            <thead>
                <tr>
                    <th style="text-align:center">NO</th>
                    <th>NAMA</th>
                    <th>NIK</th>
                    <th>KODE TRANSAKSI</th>
                    <th>ALASAN</th>
                    <th>ASAL TERMINAL</th>
                    <th>TUJUAN TERMINAL</th>
                    <th>STATUS</th>
                    <th>VERIFIKATOR</th>
                    <!-- <th>WAKTU</th> -->
                </tr>
            </thead>
            <tbody>

                <?php
                $result = $data_excel;
                $no = 1;
                foreach ($result as $row) {

                    $name = $row->transaction_booking_name;
                    $nik = $row->transaction_nik;
                    $transaction_number = $row->transaction_number;
                    $verified_at = $row->verified_at;
                    $reject_verified_reason = $row->reject_verified_reason;
                    $status = $row->STATUS;
                    $from = $row->route_from == NULL ? 'DITOLAK' : $row->route_from;
                    $to = $row->route_to == NULL ? 'DITOLAK' : $row->route_to;
                    $verivikator = $row->verifikator;
                    $waktu_verif = $row->waktu_verif;
                    $verified_at = $row->verified_at;



                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";

                    if ($transaction_number != null) {
                        echo "<td>" . $name . "</td>";
                    } else {
                        echo "<td>" . date('d F Y', strtotime($row->verified_at)) . "</td>";
                    }

                    echo "<td>" . $nik . "</td>";
                    echo "<td>" . $transaction_number . "</td>";
                    echo "<td>" . $reject_verified_reason . "</td>";
                    echo "<td>" . $from . "</td>";
                    echo "<td>" . $to . "</td>";
                    echo "<td>" . $status . "</td>";
                    echo "<td>" . $verivikator . "<br>" . $verified_at . "<br>" . $waktu_verif . "</td>";
                    // echo "<td>" . $waktu_verif . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
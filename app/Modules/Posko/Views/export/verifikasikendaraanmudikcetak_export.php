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
    }

    th {
        padding: 5.4px;
        background-color: #224DDD;
        border: 1px solid black;
        color: white;
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
    $tanggalstart = $data_excel[0]->motis_date_verif;
    $tanggalend = $data_excel[1]->motis_date_verif;

    ?>

    <div class="judul">
        DIREKTORAT JENDERAL PERHUBUNGAN DARAT <br>
        LAPORAN VERIFIKASI DATA KENDARAAN PESERTA
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
                    <th>NO</th>
                    <!-- <th>VERIFIKATOR</th></th> -->
                    <th>NAMA</th>
                    <th>NIK</th>
                    <th>KODE MOTIS</th>
                    <th>NO POLISI</th>
                    <th>NO STNK</th>
                    <th>JENIS</th>
                    <th>ASAL</th>
                    <th>TUJUAN</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $result = $data_excel;
                $no = 1;
                foreach ($result as $row) {
                    // $verivikator = $row->verifikator;
                    $user_mobile_name = $row->user_mobile_name;
                    $motis_code = $row->motis_code;
                    $nik_pendaftar_kendaraan = $row->nik_pendaftar_kendaraan;
                    $no_kendaraan = $row->no_kendaraan;
                    $no_stnk_kendaraan = $row->no_stnk_kendaraan;
                    $jenis_kendaraan = $row->jenis_kendaraan;
                    $route_from = $row->route_from;
                    $route_to = $row->route_to;
                    $status = $row->STATUS;

                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    // echo "<td>" . $verifikator . "</td>";
                    if ($motis_code != null) {
                        echo "<td>" . $user_mobile_name . "</td>";
                    } else {
                        echo "<td>" . date('d F Y', strtotime($row->motis_date_verif)) . "</td>";
                    }

                    echo "<td>" . $nik_pendaftar_kendaraan . "</td>";
                    echo "<td>" . $motis_code . "</td>";
                    echo "<td>" . $no_kendaraan . "</td>";
                    echo "<td>" . $no_stnk_kendaraan . "</td>";
                    echo "<td>" . $jenis_kendaraan . "</td>";
                    echo "<td>" . $route_from . "</td>";
                    echo "<td>" . $route_to . "</td>";
                    echo "<td>" . $status . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>

        </table>
    </div>
</body>

</html>
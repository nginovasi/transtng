<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan SPDA</title>
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
    $route_name = $data_excel[0]->route_name;
    $armada_kapasitas = $data_excel[0]->armada_kapasitas;
    $kategori_angkutan_name = $data_excel[0]->kategori_angkutan_name;
    $tgl_spda = $data_excel[0]->tgl_spda;
    $armada_plat_number = $data_excel[0]->armada_plat_number;
    ?>
    <div class="judul">
        <?php
        if ($armada_plat_number != null) {
            echo "LAPORAN HARIAN MONITORING<br> SUBSIDI ANGKUTAN " . strtoupper($kategori_angkutan_name) . " TAHUN ANGGARAN " . date('Y', strtotime($tgl_spda));
            $new_date = date('d-m-Y', strtotime($data_excel[0]->tgl_spda));
        } else {
            echo "LAPORAN BULANAN MONITORING<br> SUBSIDI ANGKUTAN " . strtoupper($kategori_angkutan_name) . " TAHUN ANGGARAN " . date('Y', strtotime($tgl_spda));
            $new_date = date('F Y', strtotime($data_excel[0]->tgl_spda));
        }
        ?>
    </div>
    <table class="table-detail">
        <tr>
            <td class="detail-spda px-0 py-0" style="width:0px;height:0px">Rute</td>
            <td class="detail-spda">: <?php echo $route_name; ?></td>
        </tr>
        <tr>
            <td class="detail-spda">Tanggal</td>
            <td class="detail-spda">: <?php echo $new_date; ?></td>
        </tr>
    </table>
    <div class="row">

    </div>
    <div class="table-data">
        <table>
            <thead>
                <tr>
                    <th style="color:#FFFFFF">NO</th>
                    <?php if ($armada_plat_number != null) : ?>
                        <th style="color:#FFFFFF">NO. KENDARAAN</th>
                    <?php else : ?>
                        <th style="color:#FFFFFF">TANGGAL</th>
                    <?php endif; ?>
                    <th style="color:#FFFFFF">JUMLAH BUS</th>
                    <th style="color:#FFFFFF">RIT DILAYANI</th>
                    <th style="color:#FFFFFF">JUMLAH PENUMPANG</th>
                    <th style="color:#FFFFFF">LOAD FACTOR (%)</th>
                    <th style="color:#FFFFFF">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $data_excel;
                $no = 1;
                foreach ($result as $row) {
                    $tanggal = date('d-m-Y', strtotime($row->tgl_spda));
                    $jumlah_bus = $row->jml_bus;
                    $rit_dilayani = $row->ritase_spda;
                    $jumlah_penumpang = $row->ttl_penumpang_spda;
                    $load_factor = $row->load_factor;
                    $kategori = $row->kategori_angkutan_name;
                    $armada = $row->armada_name;
                    $kapasitas = $row->armada_kapasitas;
                    $route = $row->route_name;

                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    if ($armada_plat_number != null) {
                        echo "<td>" . $armada_plat_number . "</td>";
                    } else {
                        echo "<td>" . date('d F Y', strtotime($row->tgl_spda)) . "</td>";
                    }
                    echo "<td>" . $jumlah_bus . "</td>";
                    echo "<td>" . number_format($rit_dilayani, 2) . "</td>";
                    echo "<td>" . $jumlah_penumpang . "</td>";
                    echo "<td>" . $load_factor . "</td>";
                    echo "<td></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold;">JUMLAH</td>
                    <td style="text-align: center; font-weight: bold;"><?= array_sum(array_column($result, 'jml_bus')); ?></td>
                    <td style="text-align: center; font-weight: bold;"><?= number_format(array_sum(array_column($result, 'ritase_spda')), 2); ?></td>
                    <td style="text-align: center; font-weight: bold;"><?= array_sum(array_column($result, 'ttl_penumpang_spda')); ?></td>
                    <td style="text-align: center; font-weight: bold;"><?= array_sum(array_column($result, 'load_factor')) / count($result); ?>%</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <!-- table 3x2 for signatures -->
        <table class="table-ttd">
            <tr>
                <td class="signatures">Mengetahui</td>
                <td class="signatures">Menyetujui</td>
                <td class="signatures">Dibuat Oleh</td>
            </tr>
            <tr>
                <td class="signatures">Kepala Dinas Perhubungan</td>
                <td class="signatures">Kepala Bidang Angkutan</td>
                <td class="signatures">Kepala Bidang Angkutan</td>
            </tr>
            <tr>
                <td class="signatures">Kabupaten/Kota</td>
                <td class="signatures">Kabupaten/Kota</td>
                <td class="signatures">Kabupaten/Kota</td>
            </tr>
            <tr>
                <td class="signatures" style=" height: 100px;"></td>
                <td class="signatures" style=" height: 100px;"></td>
                <td class="signatures" style=" height: 100px;"></td>
            </tr>
            <tr>
                <td class="signatures" style=" font-weight: bold;">Nama</td>
                <td class="signatures" style=" font-weight: bold;">Nama</td>
                <td class="signatures" style=" font-weight: bold;">Nama</td>
            </tr>
            <tr>
                <td class="signatures" style=" font-weight: bold;">NIP</td>
                <td class="signatures" style=" font-weight: bold;">NIP</td>
                <td class="signatures" style=" font-weight: bold;">NIP</td>
            </tr>
        </table>
    </div>
</body>

</html>
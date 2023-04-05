<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boarding Pass</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            /* font-size: 12px; */
            padding-top: 30px;
            margin-left: 10px;
        }



        table {
            font-family: arial, sans-serif;
            /* border-collapse: collapse;
            border: 1px solid black; */
            width: 100%;
            font-size: 12px;

        }

        td {
            padding: 3px;
            /* border: 1px solid black; */



        }

        tr {
            padding: 5.4px;
            /* background-color: #224DDD; */
            /* border: 1px solid black; */
        }

        /* .table-data {
            padding-top: 80px;
        } */
    </style>
</head>

<body>



    <?php
    use Endroid\QrCode\QrCode;
    use Endroid\QrCode\Writer\PngWriter;

    if (!empty($data_excel->id)) {
        $qr_text = sha1($data_excel->motis_billing_hash);
        $qr_size = 350; // Set the size of the QR code
        $qr_code = new QrCode($qr_text);
        $qr_code->setSize($qr_size);
        // $qr_image = $qr_code->writeString();
        $writer = new PngWriter();
        $qr_image = $writer->write($qr_code);
    ?>



        <table>
            <tr>
                <td rowspan="12" style="text-align:center; width:110px">
                    <img src="<?= $qr_image->getDataUri() ?>" alt="QR Code" />
                </td>
                <td rowspan="12" style="width:100px"></td>
                <td style="width:200px; font-size: 16px;">Nama</td>
                <td style="width:350px; font-size: 16px;">: <?php echo $data_excel->nama_pemilik_kendaraan; ?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">NIK</td>
                <td style="font-size: 16px;">: <?php echo $data_excel->nik_pendaftar_kendaraan; ?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Booking Code</td>
                <td style="font-size: 16px;">: <?php echo $data_excel->motis_billing_code; ?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Nama Armada</td>
                <td style="font-size: 16px;">: <?php echo $data_excel->armada_name; ?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">No Armada</td>
                <td style="font-size: 16px;">: <?php echo $data_excel->armada_code; ?> </td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Kota Tujuan Mudik</td>
                <td style="font-size: 16px;">: <?php echo $data_excel->route_name; ?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Lokasi Keberangkatan</td>
                <td style="font-size: 16px;">: <?php echo $data_excel->route_from; ?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Tgl/Jam Keberangkatan</td>
                <td style="font-size: 16px;">: <?php echo $data_excel->jadwal_date_depart;
                                                echo "&nbsp; / "; 
                                                echo $data_excel->jadwal_time_depart; ?></td>
            </tr>
            <!-- <tr>
                <td style="font-size: 16px;">Kota Asal Balik</td>
                <td style="font-size: 16px;">: <?php if ($data_excel->jadwal_type == '2') {
                                                    echo $data_excel->route_name;
                                                } ?>
                </td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Tanggal Arus Balik</td>
                <td style="font-size: 16px;">: <?php if ($data_excel->jadwal_type == '2') {
                                                    echo $data_excel->jadwal_date_depart;
                                                    echo $data_excel->jadwal_time_depart;
                                                } ?></td>
            </tr> -->
            <tr>
                <td style="font-size: 16px;">Nomor Kendaraan</td>
                <td style="font-size: 16px;">: <?php echo $data_excel->no_kendaraan; ?></td>
            </tr>


        </table>
    <?php } else { ?>
        <div style="text-align: center; font-size: 32px;">Maaf Data Tidak Ditemukan</div>
    <?php } ?>

</body>

</html>
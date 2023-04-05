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
            /* padding-top: 30px; */
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

    // use Endroid\QrCode\QrCode;
    // use Endroid\QrCode\Writer\PngWriter;

    if (!empty($result->motis_code)) {
    ?>
        <table>
            <tr>
                <td rowspan="9" style="text-align:center">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?=$result->data_qr?>&amp;size=200x200" alt="QR Code" />
                </td>
                <td rowspan="9" style="width:80px"></td>
                <td style="width:190px; font-size: 16px;">Nama</td>
                <td style="width:260px; font-size: 16px;">:  <?=$result->user_mobile_name?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">NIK</td>
                <td style="font-size: 16px;">: <?=$result->nik_pendaftar_kendaraan?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Booking Code</td>
                <td style="font-size: 16px;">: <?=$result->motis_code?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Nama Armada</td>
                <td style="font-size: 16px;">: <?=$result->armada_name?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Kota Tujuan Mudik</td>
                <td style="font-size: 16px;">: <?=$result->route_name?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">lokasi Keberangkatan</td>
                <td style="font-size: 16px;">: <?=$result->terminal_name?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Tanggal Keberangkatan</td>
                <td style="font-size: 16px;">: <?=$result->date_depart?>, <?=$result->time_depart?> WIB</td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Nomor Kendaraan</td>
                <td style="font-size: 16px;">: <?=$result->no_kendaraan?></td>
            </tr>
            </table> 
            
          
    <?php    
} else { ?>
        <div style="text-align: center; font-size: 32px;">Maaf Data Tidak Ditemukan</div>
    <?php } ?>

  
</body>

</html>
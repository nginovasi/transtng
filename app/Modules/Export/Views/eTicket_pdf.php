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

    if (!empty($result->billing_code)) {

        $arrPenumpang = json_decode($result->data_penumpang);
        // print_r($arrPenumpang);
        // echo count($arrPenumpang);
        foreach ($arrPenumpang as $dataPenumpang) {
     
    ?>
        <table>
            <tr>
                <td rowspan="9" style="text-align:center">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?=$dataPenumpang->data_qr?>&amp;size=200x200" alt="QR Code" />
                </td>
                <td rowspan="9" style="width:80px"></td>
                <td style="width:190px; font-size: 16px;">Nama</td>
                <td style="width:260px; font-size: 16px;">:  <?=$dataPenumpang->data_nama?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">NIK</td>
                <td style="font-size: 16px;">: <?=$dataPenumpang->data_nik?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">No Bus</td>
                <td style="font-size: 16px;">:  <?=$dataPenumpang->armada_code?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Booking Code</td>
                <td style="font-size: 16px;">: <?=$dataPenumpang->billing_code?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Kota Tujuan Mudik</td>
                <td style="font-size: 16px;">: <?=$dataPenumpang->rute?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">lokasi Keberangkatan</td>
                <td style="font-size: 16px;">: <?=$dataPenumpang->terminal_name?></td>
            </tr>
            <tr>
                <td style="font-size: 16px;">Tanggal Keberangkatan</td>
                <td style="font-size: 16px;">: <?=$dataPenumpang->jadwal_date_depart?>, <?=$dataPenumpang->jadwal_time_depart?> WIB</td>
            </tr>
          
                <tr>
                    <td colspan="2" style="text-align: center; font-style: italic;">Kursi yang Anda pilih bisa saja berubah pada saat keberangkatan,<br> disesuaikan dengan kondisi lapangan.</td>
                </tr>

      


            </table> 
            
          
    <?php   } 
} else { ?>
        <div style="text-align: center; font-size: 32px;">Maaf Data Tidak Ditemukan</div>
    <?php } ?>

  
</body>

</html>
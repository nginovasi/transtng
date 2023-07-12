<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;800&display=swap" rel="stylesheet">

    <style type="text/css">
        .logo {
            float: right;
            width: 80px;
        }

        .header h5 {
            position: relative;
            color: #242732;
        }

		table{
			border-collapse: collapse;
			width: 100%;
		}

		table th, td {
			padding: 6px 8px;
		}
	</style>

	<title></title>
</head>
<body>
    <div class="header">
        <img src="<?= base_url() ?>/assets/logo_trans_tangerang.png" alt="Logo" class="logo">
        <h5>BRT (BUS RAPID TRANSIT) <br/>
                    <b>TRANS TANGERANG</b><br/>
                    Jl. Borobudur Raya, RT.002/RW.012,<br/>
                    Cibodas Baru, Kec. Cibodas, Kota Tangerang,<br/>
                    Banten 15138, Indonesia</h5>
    </div>

    <div class="title" style="font-weight: bold; font-size: 20px; text-align: center;">
        <h6><?= $title; ?></h6>
    </div>

    <div class="body">
        <table class="table" id="">
            <thead>
                <tr>
                    <th rowspan="2" style="border:1px solid #555255;">Jenis Transaksi</th>
                    <th colspan="<?= count($total_per_date) - 1 ?>" style="border:1px solid #555255;">Tanggal</th>
                    <th rowspan="2" style="border:1px solid #555255;">Total Trans</th>
                    <th rowspan="2" style="border:1px solid #555255;">Total Rupiah</th>
                </tr>
                <tr>
                    <?php
                        foreach($total_per_date as $key => $val) {
                            if($key != 0) {
                    ?>
                        <th style="border:1px solid #555255;"><?= $key ?></th>
                    <?php 
                            }
                        } 
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($jenis as $key => $val) { ?>
                    <tr>
                        <th style="border:1px solid #555255"><?= $val->jenis ?></th>

                        <?php
                            $ttl_trx_cstm = 0;
                            $jml_trx_cstm = 0;
                        ?>
                        <?php 
                            for ($n = 0; $n < count($total_per_date); $n++) {
                                if($n != 0) {
                        ?>
                            <th style="border:1px solid #555255"><?= isset($result['ttl_trx'][$val->jenis]) ? (isset($result['ttl_trx'][$val->jenis][$n]) ? number_format($result['ttl_trx'][$val->jenis][$n]) : 0) : 0 ?></th>
                        
                            <?php
                                $ttl_trx_cstm += intval(isset($result['ttl_trx'][$val->jenis]) ? (isset($result['ttl_trx'][$val->jenis][$n]) ? $result['ttl_trx'][$val->jenis][$n] : 0) : 0);
                                $jml_trx_cstm += intval(isset($result['jml_trx'][$val->jenis]) ? (isset($result['jml_trx'][$val->jenis][$n]) ? $result['jml_trx'][$val->jenis][$n] : 0) : 0);
                            ?>
                        <?php 
                                }
                            } 
                        ?>


                        <th style="border:1px solid #555255"><?= number_format($ttl_trx_cstm) ?></th>
                        <th style="border:1px solid #555255"><?= number_format($jml_trx_cstm) ?></th>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="border:1px solid #555255">Total</th>
                    <?php 
                        for ($n = 0; $n < count($total_per_date); $n++) {
                            if($n != 0) {
                    ?>
                        <th style="border:1px solid #555255"><?= number_format($total_per_date[$n]) ?></th>
                    <?php 
                            }
                        } 
                    ?>
                    <th style="border:1px solid #555255"><?= number_format($ttl_trx) ?></th>
                    <th style="border:1px solid #555255"><?= number_format($jml_trx) ?></th>
                </tr>
            </tfoot>
        </table>
    </div>

    </body>
</html>
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

        .field {
            border: 1px solid #555255;
        }

        .field-left {
            border: 1px solid #555255;
            text-align: left;
        }

        .field-center {
            border: 1px solid #555255;
            text-align: center;
        }

        .field-right {
            border: 1px solid #555255;
            text-align: right;
        }

        .field-right-foot {
            border: 1px solid #555255;
            text-align: right;
            font-weight: bold;
        }
        
        .text-success {
            color: #5cb85c;
        }

        .text-danger {
            color: #d9534f;
        }

	</style>

	<title></title>
</head>
<body>
    <div class="header">
        <img src="<?= base_url() . '/assets/logo_trans_tangerang.png'?>" alt="Logo" class="logo">
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
                    <th class="field">#</th>
                    <th class="field">Tanggal Transaksi</th>
                    <th class="field">Tanggal Pembayaran</th>
                    <th class="field">Jumlah Transaksi</th>
                    <th class="field">Nominal Transaksi</th>
                    <th class="field">Nominal Dibayarkan</th>
                    <th class="field">Selisih</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($result as $key => $val) { ?>
                    <tr>
                        <td class="field-center"><?= $key + 1 ?></td>
                        <td class="field-center"><?= $val->date_trx ? $val->date_trx : '-' ?></td>
                        <td class="field-center"><?= $val->date_paid ? $val->date_paid : '-' ?></td>
                        <td class="field-right"><?= number_format($val->ttl_trx) ?></td>
                        <td class="field-right"><?= number_format($val->jml_trx) ?></td>
                        <td class="field-right"><?= number_format($val->jml_trx_paid) ?></td>

                        <?php if($val->difference_trx > 0) { ?>
                            <td class="field-right text-success">+<?= number_format($val->difference_trx) ?></td>
                        <?php } else if($val->difference_trx < 0) {  ?>
                            <td class="field-right text-danger"><?= number_format($val->difference_trx) ?></td>
                        <?php } else { ?>
                            <td class="field-right"><?= number_format($val->difference_trx) ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="field-right-foot">Total</td>
                    <td class="field-right-foot"><?= number_format($ttl_trx) ?></td>
                    <td class="field-right-foot"><?= number_format($jml_trx) ?></td>
                    <td class="field-right-foot"><?= number_format($jml_trx_paid) ?></td>
                    <td class="field-right-foot"><?= number_format($difference_trx) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    </body>
</html>